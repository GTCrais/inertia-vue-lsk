<template>
	<footer class="py-4 border-t border-t-gray-200">
		<container class="text-center">
			<div class="flex flex-col sm:flex-row justify-between gap-y-0.5">
				<div>&copy; Copyright YourApp {{ year }}</div>

				<div class="sm:flex gap-x-2">
					<app-link class="block" href="/terms-of-service">Terms of service</app-link>
					<span class="hidden sm:block text-gray-300">•</span>
					<app-link class="block" href="/privacy-policy">Privacy policy</app-link>
				</div>
			</div>
		</container>
	</footer>
</template>

<script>
	import Container from "@/js/components/Container.vue";

	export default {
		components: { Container },
		props: {

		},

		data() {
			return {

			}
		},

		mounted() {

		},

		methods: {

		},

		computed: {
			year() {
				return new Date().getFullYear();
			}
		}
	}
</script>