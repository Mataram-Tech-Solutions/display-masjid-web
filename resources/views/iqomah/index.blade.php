<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Countdown Iqomah</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link id="pagestyle" rel="stylesheet" href="{{asset('flipdown-master/dist/flipdown.css')}}">
    <link id="pagestyle" rel="stylesheet" href="{{asset('flipdown-master/dist/flipdown.min.css')}}">
    <link>
    <style>
        @font-face {
            font-family: 'CustomFont';
            src: url('/fonts/roboto/Roboto-Bold.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            margin: 0;
            height: 100vh; /* Mengatur tinggi ke 100% dari viewport height */
            width: 100vw; /* Mengatur lebar ke 100% dari viewport width */
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ asset('images/background2.jpg') }}');
            background-size: cover; /* Memastikan gambar menutupi seluruh latar */
            background-position: center; /* Memusatkan gambar */
            background-repeat: no-repeat; /* Mencegah pengulangan gambar */
            background-attachment: fixed; /* Membuat gambar tetap saat scroll */
            color: white;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
    <div style="padding-bottom: 13%">
        <div class="text-center mb-4" style="font-size: 5rem; color: rgb(255, 255, 255); font-family: 'CustomFont', sans-serif;">Iqomah</div>
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
                    console.log('Countdown selesai!');

                    // Kirim request POST ke ESP8266 untuk menyalakan buzzer
                    fetch('http://192.168.37.111/buzzer', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            buzzer: {{ $buzzer ?? 1 }} // Pastikan variabel ini ada
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Buzzer Response:', data);
                    })
                    .catch(error => console.error('Gagal mengirim data ke buzzer:', error));

                    // Redirect ke halaman utama setelah countdown selesai
                    setTimeout(() => {
                        window.location.href = 'http://192.168.37.1:8000/displayutama';
                    }, 5000); // Delay 2 detik sebelum redirect
                });


            
                document.body.classList.toggle('light-theme');
                document.querySelector('#flipdown').classList.toggle('flipdown__theme-light');
        });
    </script>
</body>

</html>
