<template>
	<container class="pt-10 pb-4">
		<div class="m-auto w-fit max-w-full">
			<h1 class="mb-6 text-center text-xl sm:text-2xl font-bold">
				Forgot password
			</h1>

			<card>
				<div class="py-6 m-auto w-sm max-w-full">
					<div v-if="showMessage" :class="{ 'text-red-500 mb-6': !success }" class="text-lg text-center">
						{{ message }}
					</div>

					<form v-if="!success" @submit.prevent="submit">
						<div class="mb-6">
							<app-label for="email">Email</app-label>
							<app-input id="email" type="text" v-model="form.email"></app-input>

							<div class="text-xs text-red-500 mt-1 -mb-3" v-if="form.errors.email">
								{{ form.errors.email }}
							</div>
						</div>

						<div class="flex justify-end">
							<app-button type="submit" :disabled="form.processing">
								Send reset link
							</app-button>
						</div>
					</form>
				</div>
			</card>
		</div>
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import AppButton from "@/js/components/AppButton.vue";
	import AppInput from "@/js/components/AppInput.vue";
	import AppLabel from "@/js/components/AppLabel.vue";
	import Card from "@/js/components/Card.vue";
	import { useForm } from "@inertiajs/vue3";

	export default {
		components: {
			AppButton, AppInput, AppLabel, Card, Container
		},

		props: {
			message: null,
			success: null
		},

		data() {
			return {
				form: useForm({
					email: null
				})
			}
		},

		mounted() {

		},

		methods: {
			submit() {
				if (this.form.processing) {
					return;
				}

				this.form.clearErrors();
				this.form.post('/forgot-password', { preserveScroll: true, replace: true });
			}
		},

		computed: {
			showMessage() {
				return !!this.message;
			}
		}
	}
</script>
