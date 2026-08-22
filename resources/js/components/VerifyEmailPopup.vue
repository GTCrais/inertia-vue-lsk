<template>
	<popup popup-class="sm:w-[220px] mt-0.5">
		<template #default="{ toggleDropdown }">
			<div>
				<a href="#" class="retain-text-color text-red-500 hover:text-red-400 text-xs font-normal" @click.prevent="toggleDropdown">
					Verify email
				</a>
			</div>
		</template>

		<template #popup>
			<div class="font-normal text-xs">
				<div v-if="!verificationMailSent">
					<div class="mb-0.5">Didn't receive the verification email?</div>
					<a href="#" @click.prevent="sendVerificationMail">Send it again!</a>
				</div>

				<div v-else class="flex items-center gap-x-2">
					<circle-check class="w-8 text-sky-500"></circle-check>
					<span>The email has been sent and should arrive within a few minutes.</span>
				</div>
			</div>
		</template>
	</popup>
</template>

<script>
	import Popup from "@/js/components/Popup.vue";
	import { CircleCheck } from "@lucide/vue";
	import { router } from "@inertiajs/vue3";
	import { toast } from "vue-sonner";

	export default {
		components: {
			Popup, CircleCheck
		},

		props: {

		},

		data() {
			return {
				sending: false,
				verificationMailSent: false
			}
		},

		mounted() {

		},

		methods: {
			sendVerificationMail() {
				if (this.sending) {
					return;
				}

				this.sending = true;

				router.post('/email-verification-notification', null, {
					onSuccess: () => {
						this.sending = false;
						this.verificationMailSent = true;
					},
					onError: (error) => {
						if (!error.tooManyRequests) {
							toast.error('Something went wrong');
						}

						this.sending = false;
					}
				});
			}
		},

		computed: {

		}
	}
</script>