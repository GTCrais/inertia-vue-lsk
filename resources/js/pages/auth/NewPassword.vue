<template>
	<container class="py-4 flex-grow flex justify-center items-center">
		<div>
			<div v-if="showMessage" class="text-red-500 text-xl mb-6">
				{{ message }}
			</div>

			<form class="w-sm" @submit.prevent="submit">
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
					<label for="password">Password</label>
					<input id="password" type="password" class="rounded border border-gray-200 px-4 py-2" v-model="form.password_confirmation">

					<div class="text-red-500 mt-1" v-if="form.errors.password_confirmation">
						{{ form.errors.password_confirmation }}
					</div>
				</div>

				<div class="flex justify-end">
					<button
						type="submit"
						class="cursor-pointer rounded border border-gray-200 px-4 py-2 hover:border-gray-300 transition-colors"
					>
						Submit
					</button>
				</div>
			</form>
		</div>
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import { useForm } from "@inertiajs/vue3";

	export default {
		components: {
			Container
		},

		props: {
			urlEmail: null,
			resetToken: null,
			message: null
		},

		data: function() {
			return {
				form: useForm({
					email: null,
					password: null,
					password_confirmation: null,
					token: null
				}),
				showMessage: false
			}
		},

		created() {
			this.form.email = this.urlEmail;
			this.form.token = this.resetToken;
		},

		mounted() {

		},

		watch: {
			message: function() {
				this.showMessage = !!this.message;
			}
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

		}
	}
</script>