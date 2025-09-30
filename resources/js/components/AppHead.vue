<template>
	<Head>
		<title inertia >{{ metadata.title }}</title>

		<meta name="twitter:title" :content="metadata.title" inertia />
		<meta name="twitter:description" :content="metadata.description" inertia />
		<meta name="twitter:image" :content="metadata.twitterImage" inertia />

		<meta name="description" :content="metadata.description" inertia />
		<meta name="keywords" :content="metadata.keywords" inertia />
		<meta property="og:url" :content="fullUrl" inertia />
		<meta property="og:type" :content="metadata.ogType" inertia />
		<meta property="og:title" :content="metadata.title" inertia />
		<meta property="og:description" :content="metadata.description" inertia />
		<meta property="og:image" :content="metadata.ogImage" inertia />
	</Head>
</template>

<script>
	import { Head } from "@inertiajs/vue3";

	export default {
		components: {
			Head
		},

		props: {
			metadata: Object,
		},

		data: function () {
			return {
				fullUrl: (this.$isBrowser ? window.location.href : '')
			}
		},
	}
</script>