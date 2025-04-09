<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title inertia>{{ $metadataProvider->getTitle() }}</title>

		<meta name="twitter:card" content="summary">
		<meta name="twitter:title" content="{{ $metadataProvider->getTitle() }}" inertia />
		<meta name="twitter:description" content="{{ $metadataProvider->getDescription() }}" inertia />
		<meta name="twitter:image" content="{{ $metadataProvider->getTwitterImage() }}" inertia />

		<meta name="description" content="{{ $metadataProvider->getDescription() }}" inertia />
		<meta name="keywords" content="{{ $metadataProvider->getKeywords() }}" inertia />
		<meta property="og:url" content="{{ url()->full() }}" inertia />
		<meta property="og:type" content="{{ $metadataProvider->getOgType() }}" inertia />
		<meta property="og:title" content="{{ $metadataProvider->getTitle() }}" inertia />
		<meta property="og:description" content="{{ $metadataProvider->getDescription() }}" inertia />
		<meta property="og:image" content="{{ $metadataProvider->getOgImage() }}" inertia />
		<meta property="og:image:width" content="1200" />
		<meta property="og:image:height" content="800" />
		<meta property="fb:app_id" content="{{ $facebookAppId }}" />

		@vite(['resources/css/app.css', 'resources/js/app.js'])
		@inertiaHead
	</head>

	<body>
		<script>
			window.googleClientId = '<?php echo(config('services.google.client_id')) ?>';

			window.fbAsyncInit = function() {
				FB.init({
					appId: '<?php echo config('services.facebook.client_id')?>',
					cookie: false,
					xfbml: false,
					version: 'v18.0'
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

		@inertia

		<script src="https://accounts.google.com/gsi/client?language=en" async defer></script>
	</body>
</html>