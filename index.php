<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WebGIS Jalan Lingkungan</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #map {
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .map-container {
            height: calc(100vh - 56px);
        }

        .leaflet-control-zoom {
            display: none;
        }

        #tools_jalan {
            position: absolute;
            top: 70px;
            /* di bawah navbar */
            left: 20px;
            max-width: 300px;
            z-index: 999;
        }

        .accordion {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }


        .accordion-button {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand">WebGIS Indonesia</span>
        </div>
    </nav>

    <!-- Map -->
    <div class="map-container">

        <!-- Filter Tools -->
        <div id="tools_jalan">
            <div class="accordion" id="filterAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFilter">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                            Tools &nbsp;
                        </button>
                    </h2>
                    <div id="collapseFilter" class="accordion-collapse collapse show" aria-labelledby="headingFilter"
                        data-bs-parent="#filterAccordion">
                        <div class="accordion-body">

                            <div class="mb-3">
                                <label for="dataSelect" class="form-label">Data Geo</label>
                                <select id="dataSelect" class="form-select">
                                    <option value="">-- Pilih Data --</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="kecamatanSelect" class="form-label">Data Kecamatan</label>
                                <select id="kecamatanSelect" class="form-select" disabled>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tahunSelect" class="form-label">Tahun</label>
                                <select id="tahunSelect" class="form-select" disabled>
                                    <option value="">-- Pilih Tahun --</option>
                                </select>
                            </div>

                            <hr />

                            <strong>Kondisi Jalan</strong>
                            <div class="form-check">
                                <input class="form-check-input kondisi-check" type="checkbox" value="baik"
                                    id="filterBaik" checked>
                                <label class="form-check-label" for="filterBaik">Baik</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input kondisi-check" type="checkbox" value="sedang"
                                    id="filterSedang" checked>
                                <label class="form-check-label" for="filterSedang">Sedang</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input kondisi-check" type="checkbox" value="rusak ringan"
                                    id="filterRingan" checked>
                                <label class="form-check-label" for="filterRingan">Rusak Ringan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input kondisi-check" type="checkbox" value="rusak berat"
                                    id="filterBerat" checked>
                                <label class="form-check-label" for="filterBerat">Rusak Berat</label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="map"></div>

    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="app.js"></script>
</body>

</html>