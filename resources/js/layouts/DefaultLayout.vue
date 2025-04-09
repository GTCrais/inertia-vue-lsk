<template>
	<app-head :metadata="metadata"></app-head>

	<div class="main-container relative overflow-hidden flex flex-col min-h-screen text-17px text-gray-900">
		<app-header :user="user"></app-header>

		<div class="flex-grow flex flex-col">
			<slot></slot>
		</div>

		<app-footer></app-footer>

		<div v-if="toastMessage"
			 class="absolute py-4 px-6 right-2 top-16 rounded border-2 border-gray-200 w-[300px] bg-white"
		>
			{{ toastMessage }}
		</div>
	</div>
</template>

<script>
	import AppHead from "@/js/components/AppHead.vue";
	import AppHeader from "@/js/components/AppHeader.vue";
	import AppFooter from "@/js/components/AppFooter.vue";

	export default {
		components: {
			AppFooter, AppHeader, AppHead
		},

		props: {
			user: Object,
			metadata: Object,
			sessionExpired: {
				default: false
			},
			tooManyRequests: {
				default: false
			}
		},

		data: function () {
			return {
				toastTimeout: null,
				toastMessage: false
			}
		},

		mounted() {

		},

		watch: {
			sessionExpired: function(val) {
				if (val) {
					this.toast('Your session has expired. Please try again.');
				}
			},
			tooManyRequests: function(val) {
				if (val) {
					this.toast(this.tooManyRequestsMessage);
				}
			}
		},

		methods: {
			toast(message) {
				clearTimeout(this.toastTimeout);

				this.toastMessage = message;
				this.toastTimeout = setTimeout(() => {
					this.toastMessage = null;
				}, 5000);
			}
		},

		computed: {
			tooManyRequestsMessage() {
				return 'Too many attempts. Please try again in a few minutes.';
			}
		}
	}
</script>