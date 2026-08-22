<template>
	<div>
		<card class="mb-4">
			<h2 class="font-semibold text-xl">
				Account
			</h2>

			<div class="mb-6 text-gray-500 text-sm">
				Update your name and/or avatar
			</div>

			<div>
				<form @submit.prevent="updateProfile">
					<div class="mb-6">
						<app-label class="mb-2">Avatar</app-label>
						<div class="flex flex-wrap items-start gap-4">
							<div class="w-12 h-12 sm:w-20 sm:h-20 rounded-full overflow-hidden">
								<img v-if="avatarPreviewSrc" :src="avatarPreviewSrc" alt="Avatar preview" class="w-full h-full object-cover"/>
								<img v-else src="/img/misc/default_avatar.svg" alt="Avatar preview" class="w-full h-full object-cover"/>
							</div>

							<div class="flex-1">
								<div class="flex items-center gap-2">
									<label class="cursor-pointer inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs sm:text-sm
										font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors"
									>
										<input ref="avatarInput" type="file" accept="image/*" class="hidden" @change="onAvatarChange"/>
										<span class="text-nowrap">Choose image</span>
									</label>

									<button
										v-if="avatarPreviewSrc"
										type="button"
										@click="removeAvatar"
										class="cursor-pointer rounded-full bg-gray-100 px-3 py-1 text-xs sm:text-sm font-semibold text-gray-700
											hover:bg-gray-200 ring-1 ring-inset ring-gray-300 transition-colors"
									>
										Remove
									</button>
								</div>

								<p class="mt-2 pl-1 text-xs text-gray-500">Max. 5MB</p>

								<div class="text-xs text-red-500 mt-1" v-if="updateForm.errors.avatar_file">
									{{ updateForm.errors.avatar_file }}
								</div>
							</div>
						</div>
					</div>

					<div class="mb-6">
						<app-label for="name">Name</app-label>
						<app-input type="text" name="name" id="name" maxlength="150" v-model="updateForm.name"></app-input>

						<div class="text-xs text-red-500 -mb-4 pl-3 mt-1" v-if="updateForm.errors.name">
							{{ updateForm.errors.name }}
						</div>
					</div>

					<div class="mb-6">
						<app-label for="profile-email" class="flex justify-between">
							<span>Email</span>
							<verify-email-popup v-if="!user.email_verified_at"></verify-email-popup>
						</app-label>
						<app-input type="text" name="email" id="profile-email" maxlength="150"
								   class="bg-gray-50"
								   :class="user.email_verified_at ? 'ring-gray-100' : 'ring-red-300'"
								   disabled="disabled"
								   v-model="user.email"
						></app-input>
					</div>

					<div class="flex items-center gap-x-2">
						<app-button type="submit" :disabled="updateForm.processing">
							Save
						</app-button>
					</div>
				</form>
			</div>
		</card>

		<div v-if="!deleteCardVisible" class="px-6 flex justify-end">
			<a href="#" @click.prevent="showDeleteCard" class="retain-text-color text-red-500 hover:text-red-400 text-sm">
				Delete account
			</a>
		</div>

		<card v-if="deleteCardVisible">
			<h2 class="font-semibold text-xl">
				Delete account
			</h2>

			<div class="mb-6 text-sm text-gray-500">
				Permanently delete your user account
			</div>

			<div class="border border-red-100 bg-red-50 rounded-md px-4 py-3">
				<div>
					<div class="font-semibold text-red-600">
						Warning
					</div>

					<div class="text-sm text-red-500 mb-4">
						Deleting your account cannot be undone
					</div>

					<form class="flex items-center gap-x-3">
						<app-button
							variant="danger"
							@click="openDeleteAccountModal"
						>
							Delete
						</app-button>

						<a href="#" @click.prevent="hideDeleteCard" class="retain-text-color text-red-500 hover:text-red-400 text-sm">
							Cancel
						</a>
					</form>
				</div>

			</div>
		</card>

		<delete-account-modal ref="deleteAccountModal" @closed="hideDeleteCard"></delete-account-modal>
	</div>
</template>

<script>
	import DefaultLayout from "@/js/layouts/DefaultLayout.vue";
	import UserAccountLayout from "@/js/layouts/nested/UserAccountLayout.vue";
	import DeleteAccountModal from "@/js/components/modals/DeleteAccountModal.vue";
	import Card from "@/js/components/Card.vue";
	import AppButton from "@/js/components/AppButton.vue";
	import AppInput from "@/js/components/AppInput.vue";
	import AppLabel from "@/js/components/AppLabel.vue";
	import VerifyEmailPopup from "@/js/components/VerifyEmailPopup.vue";
	import { useForm } from "@inertiajs/vue3";
	import { toast } from "vue-sonner";

	export default {
		layout: [
			DefaultLayout, UserAccountLayout
		],

		components: {
			VerifyEmailPopup, AppButton, AppInput, AppLabel, Card, DeleteAccountModal
		},

		props: {
			user: Object
		},

		data() {
			return {
				updateForm: useForm({
					name: this.user.name,
					avatar_file: null,
					avatar_remove: false,
				}),
				avatarPreview: null,
				deleteCardVisible: false
			}
		},

		mounted() {

		},

		beforeUnmount() {
			if (this.avatarPreview) {
				URL.revokeObjectURL(this.avatarPreview);
			}
		},

		methods: {
			updateProfile() {
				if (this.updateForm.processing) {
					return;
				}

				this.updateForm.post('/user/profile', {
					preserveScroll: true,
					onSuccess: () => {
						this.refreshForm();
						toast.success('Profile updated.');
					}
				});
			},

			refreshForm() {
				this.updateForm.name = this.user.name;
				this.clearAvatar();
			},

			onAvatarChange(e) {
				const file = e.target.files && e.target.files[0] ? e.target.files[0] : null;
				if (!file) {
					return;
				}

				if (!file.type || !file.type.startsWith('image/')) {
					this.updateForm.setError('avatar_file', 'Please choose an image.');
					e.target.value = '';
					return;
				}

				const max = 5 * 1024 * 1024;
				if (file.size > max) {
					this.updateForm.setError('avatar_file', 'The image can be at most 5MB.');
					e.target.value = '';
					return;
				}

				this.updateForm.clearErrors('avatar_file');

				if (this.avatarPreview) {
					URL.revokeObjectURL(this.avatarPreview);
				}

				this.updateForm.avatar_file = file;
				this.updateForm.avatar_remove = false;
				this.avatarPreview = URL.createObjectURL(file);
			},

			removeAvatar() {
				this.updateForm.avatar_remove = true;
				this.clearAvatar();
			},

			clearAvatar() {
				this.updateForm.avatar_file = null;

				if (this.avatarPreview) {
					URL.revokeObjectURL(this.avatarPreview);
				}

				this.avatarPreview = null;

				if (this.$refs.avatarInput) {
					this.$refs.avatarInput.value = '';
				}
			},

			showDeleteCard() {
				this.deleteCardVisible = true;
			},

			hideDeleteCard() {
				this.deleteCardVisible = false;
			},

			openDeleteAccountModal() {
				this.$refs.deleteAccountModal.open();
			}
		},

		computed: {
			avatarPreviewSrc() {
				if (this.updateForm.avatar_remove) {
					return null;
				}

				return (this.avatarPreview || this.user.avatar_url);
			}
		}
	}
</script>