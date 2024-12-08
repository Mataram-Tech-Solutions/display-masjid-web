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
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; /* Menghilangkan scrollbar */
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
            object-fit: cover; /* Memastikan background memenuhi layar */
            opacity: 0;
            transition: opacity 2s ease-in-out; /* Animasi transisi */
        }
        .background-item.active {
            opacity: 1; /* Aset aktif terlihat jelas */
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="background-container">
        <!-- Dynamic content will be appended here -->
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

@vite('resources/js/app.js')

</body>
</html>
