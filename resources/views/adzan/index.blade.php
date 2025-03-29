<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Adzan Display - FathTronik</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
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
            background-color: black
        }

    .progress-container {
        width: 75%; /* Set the width of the progress bar container */
        height: 30px; /* Height of the progress bar */
        background: #ddd;
        border-radius: 5px;
        overflow: hidden;
        margin: 10px auto;
        position: relative;
    }

    .progress-bar {
        height: 100%;
        width: 0; /* Start at 0% width */
        background: linear-gradient(90deg, red, orange, yellow, green, blue, indigo, violet);
        transition: width 0.1s ease; /* Smooth transition for width changes */
        position: absolute;
        top: 0;
        left: 0;
    }
    </style>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container-fluid">
        <div class="row text-center" style="font-size: 88px; color:white; margin-top:9%">
            <div class="col">Saatnya Adzan</div>
        </div>
        <div class="row text-center mt-2" style="font-size: 88px; color:#e4c40f">
            <div class="col">{{$sholat}}</div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-auto">
                <div id="waktu" class="p-2 text-white" style="background-color: red; font-size: 56px; border-radius: 12px; border: 2px solid white;">
                    --:--:--
                </div>                
            </div>
        </div>
        <div class="row text-center mt-4">
            <audio id="custom-audio" autoplay>
                <source src="{{ asset('upload/audio/' . $audio) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        
            <!-- Progress Bar Container -->
            <div class="progress-container" style="width: 75%; margin: 0 auto;">
                <div class="progress-bar" id="progress-bar"></div>
            </div>
        </div>
        
    </div>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const realtime = document.querySelector("#waktu");

            Echo.channel('waktureal-channel')
                .listen('WaktuReal', (e) => {
                    console.log('Data JSON real-time:', e.data);
                    const time = e.data; // Ambil nilai waktu dari JSON
                    realtime.textContent = time;
                });
        });

        const audio = document.getElementById('custom-audio');
        const progressBar = document.getElementById('progress-bar');
    
        audio.addEventListener('timeupdate', () => {
            // Calculate the progress of the audio and update the width of the progress bar
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = progress + '%'; // Set width of progress bar
        });
    
        audio.addEventListener('ended', () => {
            var jedaIqomah = @json($iqomah);  // Data $sholat
            var buzzerIqomah = @json($buzzer);  // Data $sholat
            progressBar.style.width = '0%'; // Reset progress bar after the audio ends
            setTimeout(() => {
                const url = `http://192.168.37.1:8000/displayiqomah?menitIqomah=${encodeURIComponent(jedaIqomah)}&buzzer=${encodeURIComponent(buzzerIqomah)}`;
                window.location.href = url;
            }, 2000); // 2000 ms = 2 detik
        });
    </script>
    @vite('resources/js/app.js')
</body>
</html>