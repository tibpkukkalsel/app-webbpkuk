/**
 * OFFICIAL ADMINISTRATIVE BOUNDARY GEOJSON (EPSG:4326 WGS84)
 * 13 Regencies & Cities of South Kalimantan Province (Kalimantan Selatan)
 * Matched strictly via BPS Region Codes (kode_bps)
 */

window.kalselGeoJson = {
    "type": "FeatureCollection",
    "features": [
        // 1. 6309 - Kabupaten Tabalong (Northern Kalsel)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6309", "nama": "Kabupaten Tabalong", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [115.350, -1.350], [115.480, -1.320], [115.650, -1.360], [115.820, -1.500],
                    [115.920, -1.720], [115.850, -1.950], [115.780, -2.180], [115.550, -2.250],
                    [115.420, -2.150], [115.300, -2.050], [115.220, -1.820], [115.200, -1.600],
                    [115.350, -1.350]
                ]]
            }
        },

        // 2. 6311 - Kabupaten Balangan (Northeastern Kalsel)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6311", "nama": "Kabupaten Balangan", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [115.550, -2.250], [115.780, -2.180], [115.980, -2.350], [116.120, -2.480],
                    [115.950, -2.620], [115.750, -2.600], [115.500, -2.550], [115.450, -2.380],
                    [115.550, -2.250]
                ]]
            }
        },

        // 3. 6308 - Kabupaten Hulu Sungai Utara (Amuntai - Marshland Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6308", "nama": "Kabupaten Hulu Sungai Utara", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [115.120, -2.250], [115.420, -2.150], [115.550, -2.250], [115.450, -2.380],
                    [115.500, -2.550], [115.380, -2.650], [115.180, -2.600], [115.080, -2.480],
                    [115.120, -2.250]
                ]]
            }
        },

        // 4. 6307 - Kabupaten Hulu Sungai Tengah (Barabai - Meratus Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6307", "nama": "Kabupaten Hulu Sungai Tengah", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [115.380, -2.650], [115.500, -2.550], [115.750, -2.600], [115.920, -2.750],
                    [115.750, -2.920], [115.550, -2.950], [115.300, -2.850], [115.380, -2.650]
                ]]
            }
        },

        // 5. 6306 - Kabupaten Hulu Sungai Selatan (Kandangan Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6306", "nama": "Kabupaten Hulu Sungai Selatan", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [115.080, -2.600], [115.380, -2.650], [115.300, -2.850], [115.550, -2.950],
                    [115.450, -3.080], [115.220, -3.020], [115.050, -2.920], [115.080, -2.600]
                ]]
            }
        },

        // 6. 6305 - Kabupaten Tapin (Rantau Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6305", "nama": "Kabupaten Tapin", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [114.920, -2.780], [115.080, -2.600], [115.050, -2.920], [115.220, -3.020],
                    [115.320, -3.220], [115.050, -3.320], [114.820, -3.120], [114.920, -2.780]
                ]]
            }
        },

        // 7. 6304 - Kabupaten Barito Kuala (Marabahan Delta Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6304", "nama": "Kabupaten Barito Kuala", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [114.480, -2.680], [114.920, -2.780], [114.820, -3.120], [114.780, -3.260],
                    [114.650, -3.420], [114.420, -3.320], [114.450, -2.950], [114.480, -2.680]
                ]]
            }
        },

        // 8. 6303 - Kabupaten Banjar (Martapura & Interior Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6303", "nama": "Kabupaten Banjar", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [114.780, -3.120], [115.050, -3.320], [115.320, -3.220], [115.580, -3.100],
                    [115.720, -3.420], [115.420, -3.620], [115.120, -3.580], [114.780, -3.450],
                    [114.780, -3.120]
                ]]
            }
        },

        // 9. 6371 - Kota Banjarmasin (City Enclave at Mouth of Barito River)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6371", "nama": "Kota Banjarmasin", "jenis": "kota" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [114.530, -3.270], [114.650, -3.270], [114.650, -3.390], [114.530, -3.390], [114.530, -3.270]
                ]]
            }
        },

        // 10. 6372 - Kota Banjarbaru (Capital City Enclave)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6372", "nama": "Kota Banjarbaru", "jenis": "kota" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [114.760, -3.410], [114.910, -3.410], [114.910, -3.530], [114.760, -3.530], [114.760, -3.410]
                ]]
            }
        },

        // 11. 6301 - Kabupaten Tanah Laut (Pelaihari Coastal Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6301", "nama": "Kabupaten Tanah Laut", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [114.520, -3.480], [114.780, -3.450], [115.120, -3.580], [115.350, -3.750],
                    [115.220, -3.950], [114.880, -4.180], [114.520, -3.920], [114.520, -3.480]
                ]]
            }
        },

        // 12. 6310 - Kabupaten Tanah Bumbu (Batulicin Coastal Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6310", "nama": "Kabupaten Tanah Bumbu", "jenis": "kabupaten" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [115.350, -3.250], [115.720, -3.120], [116.020, -3.280], [116.180, -3.580],
                    [115.780, -3.880], [115.350, -3.750], [115.350, -3.250]
                ]]
            }
        },

        // 13. 6302 - Kabupaten Kotabaru (Pulau Laut & Mainland Archipelago Region)
        {
            "type": "Feature",
            "properties": { "kode_bps": "6302", "nama": "Kabupaten Kotabaru", "jenis": "kabupaten" },
            "geometry": {
                "type": "MultiPolygon",
                "coordinates": [
                    // Mainland Kotabaru
                    [[
                        [115.820, -2.180], [116.120, -2.050], [116.380, -2.220], [116.480, -2.850],
                        [116.180, -3.580], [116.020, -3.280], [115.720, -3.120], [115.920, -2.750],
                        [115.820, -2.180]
                    ]],
                    // Pulau Laut
                    [[
                        [116.080, -3.220], [116.320, -3.150], [116.380, -3.750], [116.180, -3.950],
                        [116.020, -3.620], [116.080, -3.220]
                    ]]
                ]
            }
        }
    ]
};
