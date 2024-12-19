<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Clock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .loading-container {
            text-align: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(0, 0, 0, 0.2);
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .message {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        .app-content {
            display: none;
            text-align: center;
        }
    </style>
        @vite('resources/css/app.css')

</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-container" id="loading-screen">
        <div class="spinner"></div>
        <div class="message">Menunggu waktu dari server...</div>
    </div>

    <!-- Main App -->
    <div class="app-content" id="app">
        <h1>Waktu Saat Ini:</h1>
        <p id="current-time"></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loadingScreen = document.getElementById('loading-screen');
            const appContent = document.getElementById('app');
            const currentTimeElement = document.getElementById('current-time');
    
            // Dengarkan event WebSocket
            Echo.channel('waktureal-channel')
                .listen('WaktuReal', (e) => {
                    console.log("Waktu diterima:", e.data);
    
                    // Simpan waktu ke elemen
                    currentTimeElement.textContent = e.data;
    
                    // Arahkan ke route 'displayutama' setelah menerima waktu
                    window.location.href = "{{ route('displayutama.index') }}";
                });
        });
    </script>
    
        @vite('resources/js/app.js')

</body>
</html>
