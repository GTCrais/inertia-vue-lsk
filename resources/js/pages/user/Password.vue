<template>
	<card>
		<h2 class="font-semibold text-xl">
			Update password
		</h2>

		<div class="mb-6 text-gray-500 text-sm">
			For security, choose a long, random password
		</div>

		<div>
			<form @submit.prevent="submit">
				<div class="mb-6">
					<app-label for="update_password">New password</app-label>
					<app-input id="update_password" type="password" name="password" maxlength="150" v-model="form.password"></app-input>

					<div class="text-xs text-red-500 -mb-4 pl-3 mt-1" v-if="form.errors.password">
						{{ form.errors.password }}
					</div>
				</div>

				<div class="mb-6">
					<app-label for="password_confirmation">Confirm password</app-label>
					<app-input type="password" name="password_confirmation" id="password_confirmation" maxlength="150" v-model="form.password_confirmation"></app-input>
				</div>

				<div class="flex items-center gap-x-2">
					<app-button type="submit" :disabled="form.processing">
						Save
					</app-button>
				</div>
			</form>
		</div>
	</card>
</template>

<script>
	import DefaultLayout from "@/js/layouts/DefaultLayout.vue";
	import UserAccountLayout from "@/js/layouts/nested/UserAccountLayout.vue";
	import Card from "@/js/components/Card.vue";
	import AppButton from "@/js/components/AppButton.vue";
	import AppInput from "@/js/components/AppInput.vue";
	import AppLabel from "@/js/components/AppLabel.vue";
	import { useForm } from "@inertiajs/vue3";
	import { toast } from "vue-sonner";

	export default {
		layout: [
			DefaultLayout, UserAccountLayout
		],

		components: {
			AppButton, AppInput, AppLabel, Card
		},

		props: {

		},

		data() {
			return {
				form: useForm({
					password: null,
					password_confirmation: null
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

				this.form.put('/user/password', {
					preserveScroll: true,
					onSuccess: () => {
						toast.success('Password updated.');
						this.form.reset();
					}
				});
			}
		},

		computed: {

		}
	}
</script>