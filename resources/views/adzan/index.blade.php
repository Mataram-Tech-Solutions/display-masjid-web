<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Adzan Display - FathTronik</title>
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
        <div class="row text-center mt-2" style="font-size: 72px; color:white">
            <div class="col">Saatnya Adzan</div>
        </div>
        <div class="row text-center mt-2" style="font-size: 72px; color:#e4c40f">
            <div class="col">{{$sholat}}</div>
        </div>
        <div class="row text-center mt-2">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const audio = document.getElementById('custom-audio');
        const progressBar = document.getElementById('progress-bar');
    
        audio.addEventListener('timeupdate', () => {
            // Calculate the progress of the audio and update the width of the progress bar
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = progress + '%'; // Set width of progress bar
        });
    
        audio.addEventListener('ended', () => {
            progressBar.style.width = '0%'; // Reset progress bar after the audio ends
        });
    </script>
    @vite('resources/js/app.js')
</body>
</html>