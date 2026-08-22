<template>
	<app-modal :is-open="isOpen" @close="close">
		<DialogTitle as="h3" class="text-xl font-semibold mb-3">
			Delete account
		</DialogTitle>

		<DialogDescription class="block pt-2 mb-6">
			Are you sure you want to delete your account?
		</DialogDescription>

		<div class="flex gap-x-2 justify-end">
			<app-button variant="secondary" @click="close" ref="cancelButton">
				Cancel
			</app-button>

			<app-button variant="danger" @click="deleteAccount">
				Delete
			</app-button>
		</div>
	</app-modal>
</template>

<script>
	import AppButton from "@/js/components/AppButton.vue";
	import AppModal from "@/js/components/modals/AppModal.vue";
	import { DialogDescription, DialogTitle } from "@headlessui/vue";
	import { nextTick } from "vue";
	import { router } from "@inertiajs/vue3";
	import { toast } from "vue-sonner";

	export default {
		components: {
			AppModal, AppButton, DialogDescription, DialogTitle
		},

		props: {

		},

		data() {
			return {
				isOpen: false,
				submitting: false
			}
		},

		mounted() {

		},

		methods: {
			open() {
				this.isOpen = true;
				nextTick(() => {
					this.$refs.cancelButton.$el.focus();
				});
			},

			close() {
				if (this.submitting) {
					return;
				}

				this.$emit('closed');
				this.isOpen = false;
			},

			deleteAccount() {
				if (this.submitting) {
					return;
				}

				this.submitting = true;

				router.delete('/user', {
					onSuccess: () => {
						this.submitting = false;
						toast.warning('Account deleted.');
						this.close();
					},
					onError: (error) => {
						console.error(error);
						this.submitting = false;
						this.close();
					}
				})
			}
		},

		computed: {

		}
	}
</script>