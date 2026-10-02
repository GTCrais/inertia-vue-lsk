<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<meta name="twitter:card" content="summary">
		<meta property="og:image:width" content="1200" />
		<meta property="og:image:height" content="630" />
		<meta property="fb:app_id" content="{{ $facebookAppId }}" />

		<link rel="icon" type="image/x-icon" href="/img/logos/favicon.png">

		@vite(['resources/css/app.css', 'resources/js/app.js'])

		<x-inertia::head>
			<title data-inertia>{{ $metadataProvider->getTitle() }}</title>

			<meta name="twitter:title" content="{{ $metadataProvider->getTitle() }}" data-inertia />
			<meta name="twitter:description" content="{{ $metadataProvider->getDescription() }}" data-inertia />
			<meta name="twitter:image" content="{{ $metadataProvider->getTwitterImage() }}" data-inertia />

			<meta name="description" content="{{ $metadataProvider->getDescription() }}" data-inertia />
			<meta name="keywords" content="{{ $metadataProvider->getKeywords() }}" data-inertia />
			<link rel="canonical" href="{{ $metadataProvider->getCanonicalUrl() }}" data-inertia />

			<meta property="og:url" content="{{ $metadataProvider->getCanonicalUrl() }}" data-inertia />
			<meta property="og:type" content="{{ $metadataProvider->getOgType() }}" data-inertia />
			<meta property="og:title" content="{{ $metadataProvider->getTitle() }}" data-inertia />
			<meta property="og:description" content="{{ $metadataProvider->getDescription() }}" data-inertia />
			<meta property="og:image" content="{{ $metadataProvider->getOgImage() }}" data-inertia />
		</x-inertia::head>
	</head>

	<body>
		<script>
			window.googleClientId = '<?php echo(config('services.google.client_id')) ?>';

			window.fbAsyncInit = function() {
				FB.init({
					appId: '<?php echo config('services.facebook.client_id')?>',
					cookie: false,
					xfbml: false,
					version: 'v22.0'
				});
			};

			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "https://connect.facebook.net/en_EN/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

		<x-inertia::app />

		<script src="https://accounts.google.com/gsi/client?language=en" async defer></script>
	</body>
</html>