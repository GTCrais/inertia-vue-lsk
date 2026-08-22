<template>
	<app-head :metadata="metadata"></app-head>

	<div class="main-container relative overflow-hidden flex flex-col min-h-screen text-17px text-gray-900">
		<app-header :user="user"></app-header>

		<div class="flex-grow flex flex-col">
			<slot></slot>
		</div>

		<app-footer></app-footer>
	</div>

	<Toaster position="top-right" rich-colors />
</template>

<script>
	import AppHead from "@/js/components/AppHead.vue";
	import AppHeader from "@/js/components/AppHeader.vue";
	import AppFooter from "@/js/components/AppFooter.vue";
	import { router } from "@inertiajs/vue3";
	import { Toaster, toast } from "vue-sonner";

	export default {
		components: {
			AppFooter, AppHeader, AppHead, Toaster
		},

		props: {
			user: Object,
			metadata: Object
		},

		data() {
			return {
				removeFlashListener: null
			}
		},

		mounted() {
			// Fires on every response that carries flash data, including the initial page load
			this.removeFlashListener = router.on('flash', (event) => {
				const flash = event.detail.flash;

				if (flash.sessionExpired) {
					toast.warning('Your session has expired. Please try again.');
				}

				if (flash.tooManyRequests) {
					toast.warning('Too many attempts. Please try again in a few minutes.');
				}

				if (flash.verified) {
					toast.success('Email verified.');
				}

				if (flash.passwordReset) {
					toast.success('Your password has been reset.');
				}
			});
		},

		unmounted() {
			this.removeFlashListener?.();
		},

		methods: {

		},

		computed: {

		}
	}
</script>
