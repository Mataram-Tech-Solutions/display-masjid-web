<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Countdown Iqomah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link id="pagestyle" rel="stylesheet" href="{{asset('flipdown-master/dist/flipdown.css')}}">
    <link id="pagestyle" rel="stylesheet" href="{{asset('flipdown-master/dist/flipdown.min.css')}}">
    <link>
    <style>
        body {
            margin: 0;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
    <div>
        <h1 class="text-center mb-4">Iqomah</h1>
        <div id="flipdown" class="flipdown"></div>
    </div>

    <script src="{{ asset('flipdown-master/dist/flipdown.min.js') }}"></script>
    <script src="{{ asset('flipdown-master/dist/flipdown.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dataInMinutes = {{ $iqomah}}

            // Konversi menit ke detik
            const countdownSeconds = dataInMinutes * 60;

            // Timer untuk countdown
            const countdownTime = Math.floor(new Date().getTime() / 1000) + countdownSeconds;

            // Initialize FlipDown
            const flipdown = new FlipDown(countdownTime)
                .start()
                .ifEnded(() => {
                    console.log('The countdown has ended!');
                    const url = `http://127.0.0.1:8000/displayutama`;
                    window.location.href = url;
                });

            
                document.body.classList.toggle('light-theme');
                document.querySelector('#flipdown').classList.toggle('flipdown__theme-light');
        });
    </script>
</body>

</html>
