<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continue in the app</title>
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
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 0.9rem;
            margin-top: 20px;
        }

        .app-button {
            display: inline-block;
            background: #0ea5e9;
            color: #fff;
            font-weight: 600;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
        }

        .fallback-link {
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
    <div id="spinner" class="spinner"></div>
    <h1 id="title" class="hidden">Continue in the app</h1>
    <a id="open-app" href="{{ $appUrl }}" class="app-button hidden">Open app</a>
    <p id="message" class="hidden">If the app doesn't open, <a href="{{ $fallbackUrl }}" class="fallback-link">continue in browser</a></p>

    <script>
        (function() {
            const appLink = @json($appUrl);

            let hidden = false;

            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    hidden = true;
                }
            });

            // Try opening the app automatically. Browsers may silently ignore
            // this or ask the user for confirmation first, and their dialogs
            // don't affect page visibility — so never navigate away on a timer;
            // the button below retries with a user gesture instead.
            window.location.href = appLink;

            setTimeout(function() {
                if (!hidden) {
                    document.getElementById('spinner').classList.add('hidden');
                    document.getElementById('title').classList.remove('hidden');
                    document.getElementById('open-app').classList.remove('hidden');
                    document.getElementById('message').classList.remove('hidden');
                }
            }, 3000);
        })();
    </script>
</body>
</html>
