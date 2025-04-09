<template>
	<container class="py-4 flex-grow flex justify-center items-center">
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
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import { useForm } from "@inertiajs/vue3";

	export default {
		components: { Container },
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