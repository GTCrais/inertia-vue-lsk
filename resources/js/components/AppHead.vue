<template>
	<Head>
		<title>{{ metadata.title }}</title>

		<meta name="twitter:title" :content="metadata.title" />
		<meta name="twitter:description" :content="metadata.description" />
		<meta name="twitter:image" :content="metadata.twitterImage" />

		<meta name="description" :content="metadata.description" />
		<meta name="keywords" :content="metadata.keywords" />
		<link rel="canonical" :href="metadata.canonicalUrl" />

		<meta property="og:url" :content="fullUrl" />
		<meta property="og:type" :content="metadata.ogType" />
		<meta property="og:title" :content="metadata.title" />
		<meta property="og:description" :content="metadata.description" />
		<meta property="og:image" :content="metadata.ogImage" />
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

		data() {
			return {
				fullUrl: (this.$isBrowser ? window.location.href : '')
			}
		},
	}
</script>