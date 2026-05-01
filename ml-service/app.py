from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, field_validator
from sklearn.base import BaseEstimator, TransformerMixin
import pickle
import numpy as np
import pandas as pd
import uvicorn
import sys

# ── Custom transformer (wajib didefinisikan ulang agar pickle bisa load) ──────
class InvertNegativeFeatures(BaseEstimator, TransformerMixin):
    def __init__(self, kolom_negatif, semua_kolom):
        self.kolom_negatif = kolom_negatif
        self.semua_kolom   = semua_kolom

    def fit(self, X, y=None):
        return self

    def transform(self, X):
        df = pd.DataFrame(X, columns=self.semua_kolom)
        for col in self.kolom_negatif:
            df[col] = 1 - df[col]
        return df.values

sys.modules['__main__'].InvertNegativeFeatures = InvertNegativeFeatures

# ── Load model bundle ─────────────────────────────────────────────────────────
try:
    with open("eqi_model.pkl", "rb") as f:
        bundle = pickle.load(f)

    pipeline = bundle["pipeline"]
    eqi_min  = bundle["eqi_min"]
    eqi_max  = bundle["eqi_max"]
    fitur    = bundle["fitur"]

    print("✓ Model berhasil dimuat")
    print(f"  Fitur  : {fitur}")
    print(f"  EQI min: {eqi_min:.4f} | EQI max: {eqi_max:.4f}")

except FileNotFoundError:
    raise RuntimeError("File eqi_model.pkl tidak ditemukan. Pastikan file ada di folder yang sama dengan app.py")
except KeyError as e:
    raise RuntimeError(f"Bundle tidak lengkap, key tidak ditemukan: {e}")


# ── Inisialisasi FastAPI ──────────────────────────────────────────────────────
app = FastAPI(
    title       = "EQI Prediction API",
    description = "API untuk menghitung Education Quality Index (EQI) kabupaten/kota di Jawa Tengah",
    version     = "1.0.0"
)


# ── Schema input ──────────────────────────────────────────────────────────────
class EQIInput(BaseModel):
    aps                 : float
    apk                 : float
    ruang_kelas_layak   : float  # dalam persen
    rata_lama_sekolah   : float  # dalam tahun
    rasio_guru_siswa    : float
    siswa_per_sekolah   : float
    dropout_rate        : float  # dalam persen
    akses_internet      : float  # dalam persen
    guru_s1             : float  # dalam persen
    sekolah_lab         : float  # dalam persen
    persebaran_sekolah  : float
    akses_sekolah       : float

    # Validasi nilai tidak boleh negatif
    @field_validator('*', mode='before')
    def tidak_boleh_negatif(cls, v):
        if isinstance(v, (int, float)) and v < 0:
            raise ValueError("Nilai tidak boleh negatif")
        return v


# ── Helper: kategorisasi EQI ──────────────────────────────────────────────────
def kategorisasi_eqi(skor: float) -> dict:
    if skor >= 75:
        return {"label": "Sangat Baik", "warna": "#22c55e"}
    elif skor >= 50:
        return {"label": "Baik",        "warna": "#84cc16"}
    elif skor >= 25:
        return {"label": "Cukup",       "warna": "#f59e0b"}
    else:
        return {"label": "Rendah",      "warna": "#ef4444"}


# ── Helper: mapping input ke nama kolom training ──────────────────────────────
def input_ke_dataframe(data: EQIInput) -> pd.DataFrame:
    input_dict = {
        'aps': data.aps,
        'apk': data.apk,
        'ruang_kelas_layak_(%)': data.ruang_kelas_layak,
        'rata"_lama_sekolah_(tahun)': data.rata_lama_sekolah,  # ← FIX INI
        'rasio_guru_siswa': data.rasio_guru_siswa,
        'siswa_per_sekolah': data.siswa_per_sekolah,
        'dropout_rate': data.dropout_rate,
        'akses_internet(%)': data.akses_internet,
        'guru_s1(%)': data.guru_s1,
        'sekolah_lab(%)': data.sekolah_lab,
        'persebaran_sekolah': data.persebaran_sekolah,
        'akses_sekolah': data.akses_sekolah,
    }

    return pd.DataFrame([input_dict], columns=fitur)


# ── Endpoint: health check ────────────────────────────────────────────────────
@app.get("/")
def root():
    return {
        "status" : "ok",
        "message": "EQI Prediction API berjalan",
        "docs"   : "/docs"
    }


# ── Endpoint: prediksi EQI ────────────────────────────────────────────────────
@app.post("/predict")
def predict_eqi(data: EQIInput):
    try:
        # 1. Susun dataframe sesuai urutan fitur training
        input_df = input_ke_dataframe(data)

        # 2. Transform lewat pipeline (scaler → inverter → pca)
        eqi_raw = pipeline.transform(input_df).flatten()[0]

        # 3. Normalisasi ke skala 0–100
        eqi_score = ((eqi_raw - eqi_min) / (eqi_max - eqi_min)) * 100
        eqi_score = float(np.clip(eqi_score, 0, 100))

        # 4. Kategorisasi
        kategori = kategorisasi_eqi(eqi_score)

        return {
            "status"    : "success",
            "eqi_score" : round(eqi_score, 4),
            "kategori"  : kategori["label"],
            "warna"     : kategori["warna"],
            "input"     : data.dict(),
        }

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal memproses prediksi: {str(e)}")


# ── Endpoint: prediksi batch (banyak kabupaten sekaligus) ─────────────────────
@app.post("/predict-batch")
def predict_batch(data_list: list[EQIInput]):
    if len(data_list) == 0:
        raise HTTPException(status_code=400, detail="List input tidak boleh kosong")
    if len(data_list) > 100:
        raise HTTPException(status_code=400, detail="Maksimal 100 input sekaligus")

    try:
        hasil = []
        for i, data in enumerate(data_list):
            input_df  = input_ke_dataframe(data)
            eqi_raw   = pipeline.transform(input_df).flatten()[0]
            eqi_score = ((eqi_raw - eqi_min) / (eqi_max - eqi_min)) * 100
            eqi_score = float(np.clip(eqi_score, 0, 100))
            kategori  = kategorisasi_eqi(eqi_score)

            hasil.append({
                "index"     : i,
                "eqi_score" : round(eqi_score, 4),
                "kategori"  : kategori["label"],
            })

        # Urutkan dari skor tertinggi
        hasil_sorted = sorted(hasil, key=lambda x: x["eqi_score"], reverse=True)
        for rank, item in enumerate(hasil_sorted, start=1):
            item["peringkat"] = rank

        return {
            "status" : "success",
            "total"  : len(hasil),
            "hasil"  : hasil_sorted
        }

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal memproses batch: {str(e)}")


# ── Endpoint: informasi model ─────────────────────────────────────────────────
@app.get("/model-info")
def model_info():
    pca_step      = pipeline.named_steps['pca']
    scaler_step   = pipeline.named_steps['scaler']

    return {
        "fitur"                   : fitur,
        "jumlah_fitur"            : len(fitur),
        "pca_n_components"        : pca_step.n_components,
        "explained_variance_ratio": pca_step.explained_variance_ratio_.tolist(),
        "eqi_min_training"        : eqi_min,
        "eqi_max_training"        : eqi_max,
        "scaler_type"             : type(scaler_step).__name__,
    }


# ── Run server ────────────────────────────────────────────────────────────────
if __name__ == "_main_":
    uvicorn.run("app:app", host="0.0.0.0", port=8000, reload=True)