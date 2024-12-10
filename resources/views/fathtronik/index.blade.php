<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Primary Display - FathTronik</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'CustomFont';
            src: url('/fonts/BoldenVan.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            /* Menghilangkan scrollbar */
            font-family: 'CustomFont', sans-serif;
        }

        .background-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .background-item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Memastikan background memenuhi layar */
            opacity: 0;
            transition: opacity 2s ease-in-out;
            /* Animasi transisi */
        }

        .background-item.active {
            opacity: 1;
            /* Aset aktif terlihat jelas */
        }

        .custom-brightnees {
            background: rgba(0, 0, 0, 0.4);
            /* Transparansi lebih gelap */
            backdrop-filter: brightness(1.2);
            /* Menurunkan kecerahan untuk efek lebih gelap */
            -webkit-backdrop-filter: brightness(0.8) blur(10px);
            /* Untuk Safari */
        }


        .navbar-text {
            padding: 10px 15px;
            color: #fff;
        }

        .text-primary {
            color: rgb(5, 5, 227);
            /* Warna biru */
        }

        .custom-p .fs-5,
        .custom-p .fs-4,
        .custom-p .fs-3,
        .custom-p .fs-6,
        .custom-p .fs-2 {
            line-height: 1.1;
            margin: 0;
            text-shadow: 5px 5px 16px rgba(0, 0, 0, 1.0);
        }


        #firstText {
            margin-bottom: -5px;
        }

        #secondText {
            margin-top: 1px;
        }

        #alamat-masjid {
            word-wrap: break-word;
            white-space: normal;
        }

        #alamat-masjid {
            max-width: 500px;
            overflow-wrap: break-word;
            word-wrap: break-word;
            white-space: normal;
            text-overflow: ellipsis;
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="background-container">
            <div class="container-fluid fixed-top">
                <div class="row row-cols-3 d-flex justify-content-center align-items-center text-center custom-brightnees">
                    <!-- Column 1 -->
                    <div class="col custom-p d-flex flex-column align-items-center"
                        style="font-family: 'CustomFont', sans-serif;">
                        <span class="fs-5 fw-bold text-white" id="firstText">Loading...</span> <!-- Tanggal Biasa -->
                        <span class="fs-5 fw-bold" id="secondText" style="color: #44da2a">Loading...</span>
                    </div>


                    <!-- Column 2 -->
                    <div class="col custom-p d-flex flex-column align-items-center"
                        style="font-family: 'CustomFont', sans-serif;">
                        <span class="fs-2 fw-bold text-primary" id="masjid">Loading...</span> <!-- Tanggal Biasa -->
                        <span class="fs-5 fw-bold text-white" id="alamat-masjid">Loading...</span>
                    </div>

                    <!-- Column 3 -->
                    <div class="col custom-p d-flex flex-column align-items-center"
                        style="font-family: 'CustomFont', sans-serif;">
                        <span class="fs-2 fw-bold text-white" id="realtime-clock"></span> <!-- Tanggal Biasa -->
                    </div>
                </div>
                <div class="row text-center" style="margin-top: 50px">
                    <div class="col-7 mx-auto">
                        <span class="fs-2 fw-bold text-white text-wrap" id="hadist" style="word-wrap: break-word;">
                            Additional Content 1 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut aliquam.
                        </span>
                    </div>
                </div>
                
            </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const assetsContainer = document.querySelector('.background-container');
            let currentIndex = 0;

            Echo.channel('primarydis-channel')
                .listen('PrimarydisUpdated', (e) => {
                    console.log('Data JSON terbaru:', e.data);
                    const items = e.data;

                    let shouldUpdateRotation = false;

                    // Menambah atau menghapus elemen berdasarkan data yang diterima
                    items.forEach(item => {
                        const existingElement = document.getElementById(`asset-${item.unique}`);
                        if (!existingElement) {
                            shouldUpdateRotation = true;

                            let element;
                            if (item.mime.startsWith('image')) {
                                element = document.createElement('img');
                                element.src = `/upload/image/${item.unique}_${item.name}`;
                                element.alt = `Image ${item.name}`;
                            } else if (item.mime.startsWith('video')) {
                                element = document.createElement('video');
                                element.src = `/upload/video/${item.unique}_${item.name}`;
                                element.autoplay = true;
                                element.muted = true;
                                element.loop = true;
                            }

                            if (element) {
                                element.id = `asset-${item.unique}`;
                                element.className = 'background-item';
                                assetsContainer.appendChild(element);
                            }
                        }
                    });

                    // Hapus elemen yang tidak ada di data baru
                    const currentElements = document.querySelectorAll('.background-item');
                    currentElements.forEach(element => {
                        const unique = element.id.replace('asset-', '');
                        const isStillValid = items.some(item => item.unique === parseInt(unique));
                        if (!isStillValid) {
                            element.remove();
                            shouldUpdateRotation = true;
                        }
                    });

                    // Set ulang rotasi background jika ada perubahan
                    if (shouldUpdateRotation) {
                        setupRotation();
                    }
                });

            // Fungsi rotasi background
            function setupRotation() {
                const assets = document.querySelectorAll('.background-item');
                currentIndex = 0;

                function switchBackground() {
                    assets.forEach((asset, index) => {
                        asset.classList.remove('active');
                        if (index === currentIndex) {
                            asset.classList.add('active');
                        }
                    });

                    currentIndex = (currentIndex + 1) % assets.length;
                }

                if (assets.length > 0) {
                    if (window.rotationInterval) {
                        clearInterval(window.rotationInterval); // Pastikan tidak ada interval ganda
                    }
                    window.rotationInterval = setInterval(switchBackground, 5000);
                    switchBackground(); // Segera panggil untuk memulai
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const firstText = document.querySelector("#firstText");
            const secondText = document.querySelector("#secondText");

            Echo.channel('tglislam-channel')
                .listen('TanggalIslam', (e) => {
                    console.log('Data JSON terbaru:', e.data);

                    // Format tanggal biasa dengan penambahan warna biru pada hari dan tanggal
                    const tglBiasa = e.data.tglBiasa; // 'Senin, 9 Desember 2024'

                    // Mengganti nama hari dengan warna biru, hanya untuk nama hari, koma tetap putih
                    const formattedTglBiasa = tglBiasa.replace(
                            /(Senin|Selasa|Rabu|Kamis|Jumat|Sabtu|Minggu)(?=,)/g, '<span class="">$1</span>')
                        .replace(/(\d{1,2})( [A-Za-z]+ \d{4})/, '<span class="text-primary">$1$2</span>');

                    // Perbarui teks dengan data yang diformat
                    firstText.innerHTML = formattedTglBiasa; // Tanggal Biasa

                    // Update tanggal hijriah
                    secondText.textContent = e.data.tglHijriah; // Tanggal Hijriah
                });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const masjid = document.querySelector("#masjid");
            const alamat_masjid = document.querySelector("#alamat-masjid");

            Echo.channel('masjidprofile-channel')
                .listen('ProfileMasjid', (e) => {
                    console.log('Data JSON masjid:', e.data);
                    masjid.textContent = "MASJID " + e.data[0].name;
                    alamat_masjid.textContent = e.data[0].alamat;
                });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const realtime = document.querySelector("#realtime-clock");

            Echo.channel('waktureal-channel')
                .listen('WaktuReal', (e) => {
                    console.log('Data JSON real-time:', e.data);
                    const time = e.data; // Ambil nilai waktu dari JSON
                    realtime.textContent = time; 
                });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const realtime = document.querySelector("#hadist");

            Echo.channel('whadist-channel')
                .listen('Hadist', (e) => {
                    console.log('Data JSON real-time:', e.data);
                    const time = e.data; // Ambil nilai waktu dari JSON
                    realtime.textContent = time; 
                });
        });
    </script>





    @vite('resources/js/app.js')

</body>

</html>
