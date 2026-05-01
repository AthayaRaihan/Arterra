import fs from 'fs';
import https from 'https';

const regencies = [
    "Cilacap", "Banyumas", "Purbalingga", "Banjarnegara", "Kebumen", "Purworejo", "Wonosobo",
    "Magelang", "Boyolali", "Klaten", "Sukoharjo", "Wonogiri", "Karanganyar", "Sragen",
    "Grobogan", "Blora", "Rembang", "Pati", "Kudus", "Jepara", "Demak", "Semarang",
    "Temanggung", "Kendal", "Batang", "Pekalongan", "Pemalang", "Tegal", "Brebes",
    "Kota Magelang", "Kota Surakarta", "Kota Salatiga", "Kota Semarang", "Kota Pekalongan", "Kota Tegal"
];

const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

const fetchGeoJSON = (query) => {
    return new Promise((resolve, reject) => {
        const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&polygon_geojson=1&limit=1`;
        https.get(url, { headers: { 'User-Agent': 'Arterra-Map-Builder/1.0' } }, (res) => {
            let data = '';
            res.on('data', chunk => data += chunk);
            res.on('end', () => {
                try {
                    const parsed = JSON.parse(data);
                    resolve(parsed);
                } catch (e) {
                    reject(e);
                }
            });
        }).on('error', reject);
    });
};

async function main() {
    const geojson = {
        type: "FeatureCollection",
        features: []
    };

    // Assign random relative rankings (1-100)
    for (const name of regencies) {
        const query = (name.startsWith('Kota') ? name : `Kabupaten ${name}`) + ', Jawa Tengah, Indonesia';
        console.log(`Fetching: ${query}`);
        try {
            const data = await fetchGeoJSON(query);
            if (data && data.length > 0 && data[0].geojson) {
                const feature = {
                    type: "Feature",
                    properties: {
                        name: name,
                        ranking: Math.floor(Math.random() * 100) + 1 // random ranking 1-100
                    },
                    geometry: data[0].geojson
                };
                geojson.features.push(feature);
            } else {
                console.log(`Failed to find geometry for: ${name}`);
            }
        } catch (error) {
            console.error(`Error for ${name}:`, error);
        }
        await sleep(1500); // 1.5 second delay to respect Nominatim rate limit
    }

    fs.writeFileSync('public/jawa-tengah.geojson', JSON.stringify(geojson));
    console.log('Finished writing public/jawa-tengah.geojson');
}

main();
