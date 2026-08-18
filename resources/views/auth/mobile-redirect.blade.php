<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background-image: url('/img/misc/bgpattern.jpg'); */
            background-repeat: repeat;
            background-position-y: -1px;
            opacity: 0.04;
            z-index: -1;
        }

        .spinner {
            width: 2.5rem;
            height: 2.5rem;
            border: 2px solid #d1d5db;
            border-top-color: #0ea5e9;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        h1 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 8px;
        }

        p {
            color: #666;
            font-size: 0.9rem;
        }

        .fallback-link {
            margin-top: 30px;
            color: #0ea5e9;
            text-decoration: none;
        }

        .fallback-link:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="spinner"></div>
    <h1 id="title" class="hidden">Redirecting...</h1>
    <p id="message" class="hidden">If the mobile app doesn't open, <a href="{{ $fallbackUrl }}" class="fallback-link">continue in browser</a></p>

    <script>
        (function() {
            const appLink = @json($appUrl);
            const fallback = @json($fallbackUrl);

            let hidden = false;

            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    hidden = true;
                }
            });

            // Try opening the app
            window.location.href = appLink;

            // After 1s, show message if still here
            setTimeout(function() {
                if (!hidden) {
                    document.getElementById('title').classList.remove('hidden');
                    document.getElementById('message').classList.remove('hidden');

                    // After 1 more second, redirect to fallback
                    setTimeout(function() {
                        if (!hidden) {
                            window.location.href = fallback;
                        }
                    }, 1000);
                }
            }, 1000);
        })();
    </script>
</body>
</html>
