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

        #hadist {
            transition: opacity 2.0s ease-in-out;
            /* Animasi transisi */
            opacity: 1;
            /* Default terlihat */
        }

        .fade-out {
            opacity: 0;
            /* Tidak terlihat */
        }

        .fade-in {
            opacity: 1;
            /* Terlihat */
        }

        marquee {
            font-size: 18px;
            /* Ukuran teks */
            color: #fff;
            /* Warna teks */

            padding: 10px;
            /* Padding di dalam marquee */
            /* Border */
            white-space: nowrap;
            /* Pastikan teks tidak membungkus */
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
                    <span class="fs-5  text-white" id="firstText">Loading...</span> <!-- Tanggal Biasa -->
                    <span class="fs-5 " id="secondText" style="color: #44da2a">Loading...</span>
                </div>


                <!-- Column 2 -->
                <div class="col custom-p d-flex flex-column align-items-center"
                    style="font-family: 'CustomFont', sans-serif;">
                    <span class="fs-2  text-primary" id="masjid">Loading...</span> <!-- Tanggal Biasa -->
                    <span class="fs-5  text-white" id="alamat-masjid">Loading...</span>
                </div>

                <!-- Column 3 -->
                <div class="col custom-p d-flex flex-column align-items-center"
                    style="font-family: 'CustomFont', sans-serif;">
                    <span class="fs-2  text-white" id="realtime-clock"></span> <!-- Tanggal Biasa -->
                </div>
            </div>
            <div class="row text-center" style="margin-top: 50px">
                <div class="col-10 mx-auto">
                    <span class="fs-2 text-white text-wrap" id="hadist" style="word-wrap: break-word;">
                        Additional Content 1 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut aliquam.
                    </span>
                </div>
            </div>


        </div>
        <div class="container-fluid fixed-bottom  custom-brightnees">
            <div class="row row-cols-8 d-flex justify-content-center align-items-center text-center text-white fs-5">
                <div class="col p-2" id="imsak" style="background-color: rgba(0, 31, 63, 0.8);"> <!-- Biru tua transparan -->
                    <span class="prayer-name">Imsak</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2" id="subuh" style="background-color: rgba(0, 116, 217, 0.8);"> <!-- Biru langit transparan -->
                    <span class="prayer-name">Subuh</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2" id="syuruq" style="background-color: rgba(127, 219, 255, 0.8);"> <!-- Biru muda transparan -->
                    <span class="prayer-name">Syuruq</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2" id="dzuhur" style="background-color: rgba(46, 204, 64, 0.8);"> <!-- Hijau transparan -->
                    <span class="prayer-name">Dzuhur</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2" id="ashar" style="background-color: rgba(255, 220, 0, 0.8);"> <!-- Kuning transparan -->
                    <span class="prayer-name">Ashar</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2" id="maghrib" style="background-color: rgba(255, 133, 27, 0.8);"> <!-- Oranye transparan -->
                    <span class="prayer-name">Maghrib</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2" id="isya" style="background-color: rgba(133, 20, 75, 0.8);"> <!-- Merah tua transparan -->
                    <span class="prayer-name">Isya</span>
                    <div class="prayer-time">--:--</div>
                </div>
            </div>
            
            
            <div class="row d-flex justify-content-center align-items-center text-center">
                <marquee id="running-text" behavior="scroll" direction="left" scrollamount="5" class="fs-5">
                    <!-- Teks akan dimasukkan secara dinamis -->
                </marquee>
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
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const textSpan = document.getElementById("hadist");
            let items = [];
            let currentIndex = 0;
            let intervalId = null; // Simpan ID interval untuk kontrol lebih lanjut

            Echo.channel('hadist-channel')
                .listen('Hadist', (e) => {
                    console.log('Data JSON terbaru:', e.data);
                    const dt = e.data;

                    if (Array.isArray(dt) && dt.length > 0) {
                        items = dt
                        currentIndex = 0; // Reset indeks
                        textSpan.textContent = items[currentIndex].txt; // Tampilkan teks pertama

                        if (!intervalId) {
                            // Mulai interval jika belum berjalan
                            intervalId = setInterval(updateText, 7000);
                        }
                    } else {
                        console.warn("Format data tidak valid atau kosong");
                    }
                });

            // Fungsi untuk memperbarui teks
            function updateText() {
                if (items.length > 0) { // Pastikan items tidak kosong
                    textSpan.classList.add("fade-out"); // Tambahkan kelas fade-out

                    // Setelah animasi fade-out selesai, ganti teks dan tampilkan dengan fade-in
                    setTimeout(() => {
                        currentIndex = (currentIndex + 1) % items.length; // Pindah ke indeks berikutnya
                        textSpan.textContent = items[currentIndex].txt; // Perbarui teks
                        textSpan.classList.remove("fade-out"); // Hapus kelas fade-out
                        textSpan.classList.add("fade-in"); // Tambahkan kelas fade-in

                        // Hapus kelas fade-in setelah animasi selesai
                        setTimeout(() => {
                            textSpan.classList.remove("fade-in");
                        }, 2000); // Durasi fade-in (sesuai CSS transition)
                    }, 2000); // Durasi fade-out (sesuai CSS transition)
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const marqueeElement = document.getElementById("running-text"); // Elemen marquee
            let textQueue = []; // Antrian teks dari WebSocket

            // Fungsi untuk memperbarui teks marquee
            function updateMarquee() {
                if (textQueue.length > 0) {
                    // Gabungkan semua teks dalam antrian menjadi satu string
                    marqueeElement.textContent = textQueue.join(" | ");
                }
            }

            // Mendengarkan data dari WebSocket melalui Laravel Echo
            Echo.channel('runtext-channel')
                .listen('Runtxt', (e) => {
                    console.log("Data JSON terbaru:", e.data);

                    if (Array.isArray(e.data) && e.data.length > 0) {
                        // Ambil properti `txt` dari data dan tambahkan ke antrian
                        textQueue = e.data.map(item => item.txt);
                        updateMarquee(); // Perbarui teks marquee
                    } else {
                        console.warn("Data tidak valid atau kosong:", e.data);
                    }
                });
        });
    </script>
   <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Objek untuk memetakan waktu sholat dengan ID kolom
        const prayerMapping = {
            Imsak: "imsak",
            Shubuh: "subuh",
            Syuruq: "syuruq",
            Dzuhur: "dzuhur",
            Ashr: "ashar",
            Maghrib: "maghrib",
            Isya: "isya",
        };

        // Fungsi untuk memperbarui waktu sholat di kolom
        function updatePrayerTimes(data) {
            // Iterasi melalui data API
            data.forEach((item) => {
                const prayerId = prayerMapping[item.shalat]; // Cocokkan nama shalat dengan ID kolom
                if (prayerId) {
                    const element = document.getElementById(prayerId); // Dapatkan elemen HTML
                    if (element && item.waktu_adzan) {
                        // Update waktu adzan pada elemen
                        element.querySelector(".prayer-time").textContent = item.waktu_adzan;
                    }
                }
            });
        }

        // Mendengarkan data dari WebSocket melalui Laravel Echo
        Echo.channel('sholat-channel')
            .listen('Jdwlsho', (e) => {
                console.log("Data Waktu Sholat:", e.data);

                // Pastikan data valid dan berformat yang sesuai
                if (Array.isArray(e.data)) {
                    updatePrayerTimes(e.data); // Update waktu sholat
                } else {
                    console.warn("Format data WebSocket tidak valid:", e.data);
                }
            });
    });
</script>

    



    @vite('resources/js/app.js')

</body>

</html>
