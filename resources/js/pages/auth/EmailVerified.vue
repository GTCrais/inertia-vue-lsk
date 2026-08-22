<template>
	<container class="pt-10 pb-4">
		<div class="m-auto w-3xl max-w-full">
			<h1 class="mb-6 text-center text-2xl sm:text-3xl font-bold">
				Email verification
			</h1>

			<card>
				<div class="py-6">
					<div class="text-lg sm:text-xl text-center mb-6">
						Email successfully verified.
					</div>

					<div class="flex justify-center">
						<app-button href="/login">
							Login
						</app-button>
					</div>
				</div>
			</card>
		</div>
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import AppButton from "@/js/components/AppButton.vue";

	export default {
		components: {
			AppButton, Container
		},

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

		}
	}
</script>