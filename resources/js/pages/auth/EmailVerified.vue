<template>
	<container class="pt-10 pb-4">
		<div class="m-auto w-3xl max-w-full">
			<h1 class="mb-6 text-center text-xl sm:text-2xl font-bold">
				Email verification
			</h1>

			<card>
				<div class="py-6">
					<div class="text-md sm:text-lg text-center mb-6">
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
	import Card from "@/js/components/Card.vue";

	export default {
		components: {
			Card, AppButton, Container
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