<template>
	<container class="py-4 flex-grow flex justify-center items-center">
		<div>
			<div v-if="authenticationExpired" class="mb-6 text-xl">
				Your session has expired. Please log in again.
			</div>

			<div v-if="showMessage" class="text-xl mb-6">
				{{ message }}
			</div>

			<div>
				<a href="#"
				   class="flex mb-6 w-full items-center justify-center gap-3 rounded-full px-3 py-2.5
				   		text-white bg-blue-900 hover:bg-blue-950 transition-colors"
				   @click.prevent="logInWithFacebook"
				>
					<span class="text-17px font-medium leading-6">Facebook</span>
				</a>

				<a href="#"
				   class="flex mb-6 w-full items-center justify-center gap-3 rounded-full px-3 py-2.5
				   		text-white bg-red-800 hover:bg-red-900 transition-colors"
				   @click.prevent="logInWithGoogle"
				>
					<span class="text-17px font-medium leading-6">Google</span>
				</a>
			</div>

			<form class="w-sm" @submit.prevent="login">
				<div v-if="form.errors.general" class="mb-6 text-red-500 text-center text-xl">
					{{ form.errors.general }}
				</div>

				<div class="w-full flex flex-col mb-6">
					<label for="email">Email</label>
					<input id="email" type="text" class="rounded border border-gray-200 px-4 py-2" v-model="form.email">

					<div class="text-red-500 mt-1" v-if="form.errors.email">
						{{ form.errors.email }}
					</div>
				</div>

				<div class="w-full flex flex-col mb-6">
					<label for="password">Password</label>
					<input id="password" type="password" class="rounded border border-gray-200 px-4 py-2" v-model="form.password">

					<div class="text-red-500 mt-1" v-if="form.errors.password">
						{{ form.errors.password }}
					</div>
				</div>

				<div class="flex justify-between items-center">
					<app-link href="/forgot-password">
						Forgot password?
					</app-link>

					<button
						type="submit"
						class="cursor-pointer rounded border border-gray-200 px-4 py-2 hover:border-gray-300 transition-colors"
					>
						Login
					</button>
				</div>
			</form>
		</div>
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import SocialAuth from "@/js/mixins/socialAuth.js";
	import { useForm } from "@inertiajs/vue3";

	export default {
		mixins: [
			SocialAuth
		],

		components: {
			Container
		},

		props: {
			authenticationExpired: {
				default: null
			},
			message: null
		},

		data: function() {
			return {
				form: useForm({
					email: null,
					password: null
				}),
				showMessage: !!this.message
			}
		},

		mounted() {

		},

		watch: {
			message: function() {
				this.showMessage = !!this.message;
			}
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

		}
	}
</script>