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
            /* 56px tinggi navbar default */
        }

        .leaflet-control-zoom {
            display: none;
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

    <!-- Content Layout -->
    <div class="container-fluid map-container">
        <div class="row h-100">
            <!-- Sidebar -->


            <div class="col-md-3 bg-light p-3 border-end">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Data Geo</h5>
                        <select id="dataSelect" class="form-select">
                            <option value="">-- Pilih Data --</option>
                        </select>
                    </div>
                </div>
                <div class="card shadow-sm mb-3">
                    <div class="card-body ">
                        <h5 class="card-title mb-3">Data Kecamatan</h5>
                        <select id="kecamatanSelect" class="form-select">
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>
                </div>
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tahun</h5>
                        <select id="tahunSelect" class="form-select">
                            <option value="">-- Pilih Tahun --</option>
                        </select>
                    </div>
                </div>
            </div>


            <!-- Map -->
            <div class="col-md-9 p-0">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="app.js"></script>
</body>

</html>