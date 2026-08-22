<template>
	<container class="pt-10 pb-4">
		<div class="m-auto w-fit max-w-full">
			<h1 class="mb-6 text-center text-xl sm:text-2xl font-bold">
				Login
			</h1>

			<card>
				<div class="py-6 m-auto w-sm max-w-full">
					<div v-if="authenticationExpired" class="mb-6 text-xl">
						Your session has expired. Please log in again.
					</div>

					<div>
						<a href="#"
						   class="flex mb-6 w-full items-center justify-center gap-3 rounded-full px-3 py-2
						   		text-facebook border border-gray-200 hover:border-gray-300 transition-colors"
						   @click.prevent="logInWithFacebook"
						>
							<img src="/img/logos/facebook_logo.svg" class="h-[30px]" alt="">
							<span class="text-17px font-medium">Sign in with Facebook</span>
						</a>

						<a href="#"
						   class="flex mb-6 w-full items-center justify-center gap-3 rounded-full px-3 py-2
						   		border border-gray-200 hover:border-gray-300 transition-colors"
						   @click.prevent="logInWithGoogle"
						>
							<img src="/img/logos/google_logo.svg" class="h-[30px]" alt="">
							<span class="text-17px font-medium leading-6">Sign in with Google</span>
						</a>
					</div>

					<form @submit.prevent="login">
						<div v-if="form.errors.general" class="mb-6 text-red-500 text-center text-xl">
							{{ form.errors.general }}
						</div>

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

						<div class="flex justify-between items-center">
							<app-link href="/forgot-password" class="text-sm">
								Forgot password?
							</app-link>

							<app-button type="submit" :disabled="form.processing">
								Login
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
	import SocialAuth from "@/js/mixins/socialAuth.js";
	import { useForm } from "@inertiajs/vue3";

	export default {
		mixins: [
			SocialAuth
		],

		components: {
			AppButton, AppInput, AppLabel, Card, Container
		},

		props: {

		},

		data() {
			return {
				form: useForm({
					email: null,
					password: null
				})
			}
		},

		mounted() {

		},

		methods: {
			login() {
				if (this.form.processing) {
					return;
				}

				this.form.clearErrors();
				this.form.post('/login', { preserveScroll: true, replace: true });
			}
		},

		computed: {
			authenticationExpired() {
				return this.$page.flash?.authenticationExpired;
			}
		}
	}
</script>
