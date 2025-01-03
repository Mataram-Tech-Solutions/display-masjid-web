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
            src: url('/fonts/roboto/Roboto-Bold.ttf') format('truetype');
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
        .custom-p .fs-2,
        .custom-p .fs-1,
        .custom-p {
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

        .height-col {
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .prayer-name {
            font-size: 32px;
            margin-bottom: 5px;
        }

        .prayer-time {
            font-size: 40px;
            font-weight: bold;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Transparent background */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            border: none;
            position: relative;
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
        }

        .countdown-labels {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .timer-text {
            font-size: 1.5em;
            font-weight: bold;
            color: #ffffff;
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
                    <span class="fs-3  text-white" id="firstText">Loading...</span> <!-- Tanggal Biasa -->
                    <span class="fs-3" id="secondText" style="color: #44da2a">Loading...</span>
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
                    <span class="text-white" id="realtime-clock" style="font-size: 70px"></span> <!-- Tanggal Biasa -->
                </div>
            </div>
            <div class="row text-center custom-p" style="margin-top: 50px">
                <div class="col-10 mx-auto">
                    <span class="fs-2 text-white text-wrap" id="hadist" style="word-wrap: break-word;">
                        Additional Content 1 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut aliquam.
                    </span>
                </div>
            </div>


        </div>
        <div class="container-fluid fixed-bottom custom-brightnees">
            <div class="row custom-p">
                <div class="col mb-2" id="countdown-sholat" style="color: #e4c40f; font-size: 35px"></div>
            </div>
            <div class="row row-cols-12 d-flex justify-content-center align-items-center text-center fs-5 custom-p"
                id="dynamic-cols">
                <!-- Kolom-kolom akan dimasukkan di sini oleh JavaScript -->
            </div>

            <div class="row row-cols-7 d-flex justify-content-center align-items-center text-center text-white fs-5">
                <div class="col p-2 custom-p height-col" id="imsak" style="background-color: rgba(0, 31, 63, 0.8);">
                    <!-- Biru tua transparan -->
                    <span class="prayer-name">Imsak</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2 custom-p height-col" id="subuh"
                    style="background-color: rgba(0, 116, 217, 0.8);"> <!-- Biru langit transparan -->
                    <span class="prayer-name">Subuh</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2 custom-p height-col" id="syuruq"
                    style="background-color: rgba(127, 219, 255, 0.8);"> <!-- Biru muda transparan -->
                    <span class="prayer-name">Syuruq</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2 custom-p height-col" id="dzuhur"
                    style="background-color: rgba(46, 204, 64, 0.8);"> <!-- Hijau transparan -->
                    <span class="prayer-name">Dzuhur</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2 custom-p height-col" id="ashar"
                    style="background-color: rgba(255, 220, 0, 0.8);"> <!-- Kuning transparan -->
                    <span class="prayer-name">Ashar</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2 custom-p height-col" id="maghrib"
                    style="background-color: rgba(255, 133, 27, 0.8);"> <!-- Oranye transparan -->
                    <span class="prayer-name">Maghrib</span>
                    <div class="prayer-time">--:--</div>
                </div>
                <div class="col p-2 custom-p height-col" id="isya"
                    style="background-color: rgba(133, 20, 75, 0.8);"> <!-- Merah tua transparan -->
                    <span class="prayer-name">Isya</span>
                    <div class="prayer-time">--:--</div>
                </div>
            </div>


            <div class="row d-flex justify-content-center align-items-center text-center custom-p">
                <marquee id="running-text" behavior="scroll" direction="left" scrollamount="5" class="fs-5">
                    <!-- Teks akan dimasukkan secara dinamis -->
                </marquee>
            </div>
        </div>

    </div>
    <div id="modal" class="modal">
        <div class="modal-content">
            <canvas id="doughnut-timer" width="250" height="250"></canvas>
            <div class="row row-cols-1 d-flex justify-content-center align-items-center text-center mt-2">
                <div id="namaSho" class="col custom-p"
                    style="color: #fff; font-size: 48px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    WAKTU ISYA</div>
            </div>
            <div class="countdown-labels">
                <div id="adzan-text" class="custom-p text-center"
                    style="color: #fff; font-size: 24px; margin-bottom: 5px;">ADZAN</div>
                <div id="timer" class="custom-p text-center" style="color: #fff; font-size: 56px;">10</div>
            </div>
        </div>
    </div>






    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        document.addEventListener("DOMContentLoaded", function() {
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
                            // Ambil hanya jam dan menit (hh:mm)
                            const timeParts = item.waktu_adzan.split(":");
                            const timeFormatted = timeParts[0] + ":" + timeParts[1];

                            // Update waktu adzan pada elemen
                            element.querySelector(".prayer-time").textContent = timeFormatted;
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mendengarkan data dari WebSocket melalui Laravel Echo
            Echo.channel('kajian-channel')
                .listen('Jdwlkaj', (e) => {
                    console.log("Data Waktu kajian:", e.data);

                    // Pastikan data valid dan berformat yang sesuai (array)
                    if (Array.isArray(e.data)) {
                        // Menambahkan kolom-kolom ke dalam div #dynamic-cols
                        updateDynamicColumns(e.data);
                    } else {
                        console.warn("Format data WebSocket tidak valid:", e.data);
                    }
                });

            // Fungsi untuk memperbarui kolom berdasarkan seluruh data
            function updateDynamicColumns(data) {
                // Ambil elemen container untuk kolom-kolom
                const container = document.getElementById('dynamic-cols');
                container.innerHTML = ''; // Kosongkan kontainer sebelum menambah data baru

                // Iterasi data dan buat kolom untuk setiap item
                data.forEach(item => {
                    const col = document.createElement('div');
                    col.classList.add('col', 'mb-2'); // Tambahkan kelas col dan margin-bottom

                    // Format waktu ke HH:mm
                    const jamMulai = formatTime(item.jam_mulai);
                    const jamSelesai = formatTime(item.jam_selesai);

                    // Struktur kolom (3 baris teks/spans)
                    col.innerHTML = `
                <div class="text-primary"><strong>${item.ulamaName || 'N/A'}</strong></div>
                <div class="text-white">${item.judul || 'No Title'}</div>
                <div class="text-white">${item.tgl_pelaksanaan} ${jamMulai}-${jamSelesai}</div>
            `;

                    // Tambahkan kolom ke dalam container
                    container.appendChild(col);
                });
            }

            // Fungsi untuk memformat waktu ke HH:mm
            function formatTime(timeString) {
                if (!timeString) return 'Invalid Time'; // Jika tidak ada waktu, kembalikan default

                // Pastikan format timeString adalah "HH:MM:SS"
                const [hours, minutes] = timeString.split(':');
                return `${hours}:${minutes}`;
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let doughnutChart; // Variabel global untuk menyimpan referensi chart

            function showModal(duration, hitungmundur, sholat, audioadzan, audioadzstat, iqomah, buzzer) {
                const modal = document.getElementById("modal");
                const timerElement = document.getElementById("timer");
                const namesho = document.getElementById("namaSho");
                const ctx = document.getElementById("doughnut-timer").getContext("2d");

                let countdown = hitungmundur;  // Gunakan hitungmundur sebagai waktu yang tersisa
                let shalat_name = sholat;
                let adzanstatus = audioadzstat;
                let adzanaudio = audioadzan;
                let jedaIqomah = iqomah;
                let buzzerIqomah = buzzer;

                timerElement.textContent = countdown;  // Tampilkan countdown pada elemen timer
                namesho.textContent = shalat_name;  // Tampilkan nama sholat

                // Tampilkan modal
                modal.style.display = "flex";

                // Jika doughnutChart belum ada, buat chart baru
                if (!doughnutChart) {
                    // Konfigurasi data awal Chart.js
                    const data = {
                        datasets: [{
                            data: [countdown, 0], // Waktu tersisa dan waktu berlalu
                            backgroundColor: ["#ee1e1e", "#dbfbff"], // Merah dan putih solid (tidak transparan)
                            borderWidth: 0,
                        }],
                    };

                    const options = {
                        responsive: false,
                        cutout: "75%", // Membuat lingkaran lebih tipis
                        rotation: -20, // Mulai dari atas (-90 derajat)
                        circumference: 380, // Lingkaran penuh (380 derajat untuk efek rotasi)
                        animation: {
                            animateRotate: true, // Aktifkan animasi rotasi
                            duration: 1000, // Durasi animasi setiap pembaruan
                        },
                    };

                    // Inisialisasi Chart.js
                    doughnutChart = new Chart(ctx, {
                        type: "doughnut",
                        data: data,
                        options: options,
                    });
                }

                // Perbarui data chart tanpa merusak animasi
                const elapsed = duration - countdown;  // Waktu berlalu berdasarkan perhitungan manual
                doughnutChart.data.datasets[0].data = [countdown, elapsed];
                doughnutChart.update();

                // Perbarui tampilan countdown
                timerElement.textContent = countdown;

                // Jika countdown sudah habis, sembunyikan modal dan jalankan audio
                if (countdown <= 1) {
                    modal.style.display = "none"; // Sembunyikan modal setelah selesai
                    if (audioadzstat == 1) {
                        displayadzan(shalat_name, adzanaudio, jedaIqomah, buzzerIqomah);  // Jalankan audio adzan
                        console.log('kosongtes:', audioadzstat);
                    } else {
                        displayiqomah(jedaIqomah, buzzerIqomah)
                        console.log('kosongtes:', audioadzstat);
                    }
                }
            }



            function displayadzan(shalat_name, adzanaudio, jedaIqomah, buzzer) {
                // Buat URL dengan query string
                const url = `http://127.0.0.1:8000/displayadzan?shalat_name=${encodeURIComponent(shalat_name)}&adzanaudio=${encodeURIComponent(adzanaudio)}&menitIqomah=${encodeURIComponent(jedaIqomah)}&buzzer=${encodeURIComponent(buzzer)}`;
                
                // Redirect ke URL tersebut
                window.location.href = url;
            }

            function displayiqomah(jedaIqomah, buzzer) {
                // Buat URL dengan query string
                const url = `http://127.0.0.1:8000/displayiqomah?menitIqomah=${encodeURIComponent(jedaIqomah)}&buzzer=${encodeURIComponent(buzzer)}`;
                
                // Redirect ke URL tersebut
                window.location.href = url;
            }

            // Fungsi untuk mengonversi waktu dalam format HH:MM:SS ke detik
            function konversiKeDetik(waktu) {
                const [jam, menit, detik] = waktu.split(":").map(Number);
                return (jam * 3600) + (menit * 60) + detik;
            }

            // Fungsi untuk menghitung selisih detik dan menyertakan nama shalat
            function hitungSelisihDetik(waktuReal, arrayWaktuAdzan) {
                const waktuRealDalamDetik = konversiKeDetik(waktuReal);
                return arrayWaktuAdzan.map(item => {
                    const selisihDetik = item.waktu_adzan_detik < waktuRealDalamDetik ?
                        Math.abs((item.waktu_adzan_detik + 86400) - waktuRealDalamDetik) :
                        Math.abs(item.waktu_adzan_detik - waktuRealDalamDetik);

                    // Kembalikan objek dengan nama shalat dan selisih detik
                    return {
                        shalat: item.shalat,
                        selisihDetik: selisihDetik
                    };
                });
            }

            function hitungSelisihDetik2(waktuReal, dataWaktuAdzan, shalat) {
                const waktuRealDalamDetik = konversiKeDetik(waktuReal);
                const selisihDetik = dataWaktuAdzan < waktuRealDalamDetik ?
                    Math.abs((dataWaktuAdzan + 86400) - waktuRealDalamDetik) :
                    Math.abs(dataWaktuAdzan - waktuRealDalamDetik);

                // Kembalikan objek dengan nama shalat dan selisih detik
                return {
                    shalat: shalat,
                    selisihDetik: selisihDetik
                };
            }


            // Fungsi untuk mengonversi detik ke format HH:MM:SS
            function konversiKeFormatWaktu(detik) {
                const jam = Math.floor(detik / 3600);
                const menit = Math.floor((detik % 3600) / 60);
                const detikSisa = detik % 60;

                // Pastikan formatnya selalu 2 digit
                return `${jam.toString().padStart(2, '0')}:${menit.toString().padStart(2, '0')}:${detikSisa.toString().padStart(2, '0')}`;
            }

            // Channel pertama: Mendapatkan data waktu adzan dan mengonversi ke detik
            Echo.channel('sholat-channel')
                .listen('Jdwlsho', (e) => {
                    const hasilKonversi = e.data.map(item => ({
                        shalat: item.shalat, // Ambil nama shalat
                        waktu_adzan_detik: konversiKeDetik(item
                            .waktu_adzan),
                        imam: item.imam_name,
                        unique_name: item.audio,
                        audstat: item.audstat,
                        iqomah: item.jeda_iqomah,
                        buzzer: item.buzzeriqomah
                    }));
                    console.log("Hasil Konversi Waktu Adzan ke Detik:", hasilKonversi);

                    // Channel kedua: Menghitung selisih dengan waktu real-time
                    Echo.channel('waktureal-channel')
                        .listen('WaktuReal', (e) => {
                            const currentTime = e.data;
                            console.log("Waktu Real-time:", currentTime);

                            // Hitung selisih detik dengan menyertakan nama shalat
                            const selisihDetik = hitungSelisihDetik(currentTime, hasilKonversi);
                            console.log("Selisih Detik:", selisihDetik);

                            // Konversi selisih detik ke format HH:MM:SS
                            const hasilKonversiFormatWaktu = selisihDetik.map(item => ({
                                shalat: item.shalat, // Nama shalat
                                waktuSelisih: konversiKeFormatWaktu(item
                                    .selisihDetik) // Selisih dalam format HH:MM:SS
                            }));
                            console.log("Selisih dalam Format HH:MM:SS:", hasilKonversiFormatWaktu);
                            const shalatBerikutnya = hasilKonversi.find(item => konversiKeDetik(
                                currentTime) < item.waktu_adzan_detik);

                            if (shalatBerikutnya) {
                                // Hitung selisih detik dan konversi ke format HH:MM:SS
                                const selisihDetik = hitungSelisihDetik2(currentTime, shalatBerikutnya
                                    .waktu_adzan_detik, shalatBerikutnya.shalat);
                                const waktuSelisih = konversiKeFormatWaktu(selisihDetik.selisihDetik);

                                if (selisihDetik.selisihDetik <= 10) {
                                    showModal(10, selisihDetik.selisihDetik, shalatBerikutnya.shalat,
                                        shalatBerikutnya.unique_name,
                                        shalatBerikutnya.audstat, shalatBerikutnya.iqomah, shalatBerikutnya.buzzer); // Tampilkan modal selama 5 detik
                                }

                                document.getElementById("countdown-sholat").innerHTML = `
                                >> ${shalatBerikutnya.shalat} - ${waktuSelisih}${shalatBerikutnya.imam ? ` - Ust.${shalatBerikutnya.imam}` : ""}
                                 `;
                            } else {
                                // Jika sudah melewati semua waktu adzan, reset ke Imsak
                                const pertama = hasilKonversi[0];
                                const selisihDetik = hitungSelisihDetik2(currentTime, hasilKonversi[0]
                                    .waktu_adzan_detik, pertama.shalat);
                                const waktuSelisih = konversiKeFormatWaktu(selisihDetik.selisihDetik);
                                if (selisihDetik.selisihDetik <= 10) {
                                    showModal(10, selisihDetik.selisihDetik, pertama.shalat, pertama
                                        .unique_name, pertama
                                        .audstat, pertama.iqomah, pertama.buzzer); // Tampilkan modal selama 5 detik
                                }
                                document.getElementById("countdown-sholat").innerHTML = `
                                >> ${pertama.shalat} - ${waktuSelisih}${pertama.imam ? ` - Ust.${pertama.imam}` : ""}
                            `;
                            }
                        });
                });
        });
    </script>
    @vite('resources/js/app.js')
</body>

</html>
