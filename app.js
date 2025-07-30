const map = L.map('map', {
    center: [-0.845, 109.75],
    zoom: 10,
    zoomControl: false
});

// Base Layers
const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
const googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], attribution: '© Google Satellite'
});
const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], attribution: '© Google Streets'
});

const baseLayers = {
    "OpenStreetMap": osm,
    "Google Satellite": googleSat,
    "Google Streets": googleStreets
};

L.control.layers(baseLayers).addTo(map);
L.control.zoom({ position: 'bottomright' }).addTo(map);

let geojsonLayers = [];

function clearGeoJsonLayers() {
    geojsonLayers.forEach(layer => map.removeLayer(layer));
    geojsonLayers = [];
} function loadGeoJsonFile(folder, file, selectedTahun = null) {
    const safeFolder = folder.trim();
    const safeFile = file.trim();
    const path = `data/${safeFolder}/${safeFile}`;

    console.log('🔍 Loading GeoJSON from:', path);

    $.getJSON(path, function (data) {
        const tahunFilter = selectedTahun || $('#tahunSelect').val();

        const layer = L.geoJSON(data, {
            filter: function (feature) {
                const tahun = feature.properties.Tahun || feature.properties.tahun;
                return !tahunFilter || tahun == tahunFilter;
            },
            style: function (feature) {
                const kondisi = (feature.properties.Keterangan || '').toLowerCase();

                let warna;
                switch (kondisi) {
                    case 'baik': warna = '#00cc44'; break;
                    case 'sedang': warna = '#ffcc00'; break;
                    case 'rusak ringan': warna = '#ff8800'; break;
                    case 'rusak berat': warna = '#990000'; break;
                    default: warna = '#666666';
                }

                return { color: warna, weight: 3 };
            },
            onEachFeature: function (feature, layer) {
                const props = feature.properties || {};
                const popup = `
                    <strong>${props.Nama_Jalan || '-'}</strong>
                    <br>Jenis: ${props.Kondisi || '-'}
                    <br>Kondisi: ${props.Keterangan || '-'}
                    <br>Lebar m: ${props.Lebar_m_ || '-'}
                    <br>Panjang m: ${props.Panjang_M || '-'}
                    <br>Tahun: ${props.Tahun || props.tahun || '-'}
                `;
                layer.bindPopup(popup);
            }
        }).addTo(map);

        geojsonLayers.push(layer);
    }).fail(function () {
        console.error('❌ Gagal load GeoJSON:', path);
    });
}





function loadAllGeoJson(folder, files) {
    clearGeoJsonLayers();
    const selectedTahun = $('#tahunSelect').val();
    files.forEach(file => loadGeoJsonFile(folder, file, selectedTahun));
}


// Ambil daftar folder data dari PHP
function populateDataDropdown() {
    $.getJSON('list_folder.php', function (folders) {
        const $dataSelect = $('#dataSelect');
        $dataSelect.empty().append('<option value="">-- Pilih Data --</option>');
        folders.forEach(folder => {
            $dataSelect.append(`<option value="${folder}">${folder.toUpperCase()}</option>`);
        });
    });
}

// Ambil daftar file di dalam folder terpilih
function populateKecamatanDropdown(folder) {
    $.getJSON(`list_files.php?folder=${folder}`, function (files) {
        const $select = $('#kecamatanSelect');
        $select.empty().append('<option value="">-- Semua Kecamatan --</option>');

        const tahunSet = new Set();

        files.forEach(file => {
            const name = file.replace('.geojson', '').replace('KECAMATAN ', '');
            $select.append(`<option value="${file}">${name}</option>`);
        });

        // Ambil semua tahun dari seluruh file untuk isi dropdown
        const promises = files.map(file =>
            $.getJSON(`data/${folder}/${file}`, function (data) {
                data.features.forEach(feature => {
                    const tahun = feature.properties.Tahun || feature.properties.tahun;
                    if (tahun) tahunSet.add(tahun);
                });
            })
        );

        Promise.all(promises).then(() => {
            const sortedTahun = Array.from(tahunSet).sort();
            const $tahunSelect = $('#tahunSelect');
            $tahunSelect.empty().append('<option value="">-- Pilih Tahun --</option>');
            sortedTahun.forEach(t => {
                $tahunSelect.append(`<option value="${t}">${t}</option>`);
            });

            // Setelah semua data dimuat, load layer-nya
            loadAllGeoJson(folder, files);
        });
    }).fail(function () {
        console.error('Gagal load isi folder:', folder);
    });
}


// Event saat dropdown data dipilih
$('#dataSelect').on('change', function () {
    const folder = $(this).val();
    if (folder) {
        console.log(folder)
        populateKecamatanDropdown(folder);
    } else {
        $('#kecamatanSelect').empty().append('<option value="">-- Pilih Kecamatan --</option>');
        clearGeoJsonLayers();
    }


});

// Event saat kecamatan dipilih
$('#kecamatanSelect').on('change', function () {
    const folder = $('#dataSelect').val();
    const file = $(this).val();
    clearGeoJsonLayers();
    if (file) {
        loadGeoJsonFile(folder, file);
    } else {
        // Kalau kosong, muat semua lagi
        populateKecamatanDropdown(folder);
    }
});

$('#tahunSelect').on('change', function () {
    const folder = $('#dataSelect').val();
    const file = $('#kecamatanSelect').val();
    clearGeoJsonLayers();
    if (file) {
        loadGeoJsonFile(folder, file); // satu kecamatan
    } else {
        $.getJSON(`list_files.php?folder=${folder}`, function (files) {
            loadAllGeoJson(folder, files); // semua kecamatan
        });
    }
});



$(document).ready(function () {
    populateDataDropdown();
});
