<template>
	<container class="pt-10 pb-4">
		<div class="m-auto w-fit max-w-full">
			<h1 class="mb-6 text-center text-xl sm:text-2xl font-bold">
				New password
			</h1>

			<card>
				<div class="py-6 m-auto w-sm max-w-full">
					<div v-if="showMessage" class="text-red-500 text-xl mb-6">
						{{ message }}
					</div>

					<form @submit.prevent="submit">
						<div class="mb-6">
							<app-label for="email">Email</app-label>
							<app-input id="email" type="text" v-model="form.email"></app-input>

							<div class="text-xs text-red-500 mt-1" v-if="form.errors.email">
								{{ form.errors.email }}
							</div>
						</div>

						<div class="mb-6">
							<app-label for="password">Password</app-label>
							<app-input id="password" type="password" v-model="form.password"></app-input>

							<div class="text-xs text-red-500 mt-1" v-if="form.errors.password">
								{{ form.errors.password }}
							</div>
						</div>

						<div class="mb-6">
							<app-label for="password_confirmation">Confirm password</app-label>
							<app-input id="password_confirmation" type="password" v-model="form.password_confirmation"></app-input>

							<div class="text-xs text-red-500 mt-1" v-if="form.errors.password_confirmation">
								{{ form.errors.password_confirmation }}
							</div>
						</div>

						<div class="flex justify-end">
							<app-button type="submit" :disabled="form.processing">
								Submit
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
			urlEmail: null,
			resetToken: null,
			message: null
		},

		data() {
			return {
				form: useForm({
					email: null,
					password: null,
					password_confirmation: null,
					token: null
				})
			}
		},

		created() {
			this.form.email = this.urlEmail;
			this.form.token = this.resetToken;
		},

		mounted() {

		},

		methods: {
			submit() {
				if (this.form.processing) {
					return;
				}

				this.form.clearErrors();
				this.form.post('/new-password', { preserveScroll: true, replace: true });
			}
		},

		computed: {
			showMessage() {
				return !!this.message;
			}
		}
	}
</script>
