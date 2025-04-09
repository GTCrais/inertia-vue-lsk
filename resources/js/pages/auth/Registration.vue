<template>
	<container class="py-4 flex-grow flex justify-center items-center">
		<div>
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

			<form class="w-sm" @submit.prevent="register">
				<div v-if="form.errors.general" class="mb-6 text-red-500 text-center">
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

				<div class="w-full flex flex-col mb-6">
					<label for="password_confirmation">Confirm password</label>
					<input id="password_confirmation" type="password" class="rounded border border-gray-200 px-4 py-2" v-model="form.password_confirmation">

					<div class="text-red-500 mt-1" v-if="form.errors.password_confirmation">
						{{ form.errors.password_confirmation }}
					</div>
				</div>

				<div class="flex justify-end">
					<button
						type="submit"
						class="cursor-pointer rounded border border-gray-200 px-4 py-2 hover:border-gray-300 transition-colors"
					>
						Register
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

		},

		data: function() {
			return {
				form: useForm({
					email: null,
					password: null,
					password_confirmation: null
				})
			}
		},

		mounted() {

		},

		methods: {
			register() {
				if (this.form.processing) {
					return;
				}

				this.form.clearErrors();
				this.form.post('/register', { preserveScroll: true, replace: true });
			}
		},

		computed: {

		}
	}
</script>