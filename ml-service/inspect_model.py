import sys, pickle
sys.path.insert(0, '.')
from sklearn.base import BaseEstimator, TransformerMixin
import pandas as pd

class InvertNegativeFeatures(BaseEstimator, TransformerMixin):
    def __init__(self, kolom_negatif, semua_kolom):
        self.kolom_negatif = kolom_negatif
        self.semua_kolom = semua_kolom
    def fit(self, X, y=None): return self
    def transform(self, X):
        df = pd.DataFrame(X, columns=self.semua_kolom)
        for c in self.kolom_negatif:
            df[c] = 1 - df[c]
        return df.values

sys.modules['__main__'].InvertNegativeFeatures = InvertNegativeFeatures

with open('eqi_model.pkl', 'rb') as f:
    b = pickle.load(f)

sc = b['pipeline'].named_steps['scaler']
print("=== Feature ranges in training data ===")
for feat, mn, mx in zip(b['fitur'], sc.data_min_, sc.data_max_):
    print(f"  {feat}: min={mn:.4f}, max={mx:.4f}")

print(f"\neqi_min={b['eqi_min']:.4f}, eqi_max={b['eqi_max']:.4f}")
