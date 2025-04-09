<template>
	<container class="py-4 flex-grow flex justify-center items-center">
		<div>
			<div v-if="showEmailVerified" class="mb-6 text-xl">
				Email verified
			</div>

			<div>
				<strong>Email:</strong> {{ user.email }}
			</div>

			<div>
				<strong>Email verified:</strong> {{ user.email_verified_at || 'No' }}
			</div>
		</div>
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";

	export default {
		components: {
			Container
		},

		props: {
			user: Object,
			emailVerified: {
				default: false
			}
		},

		data: function() {
			return {
				showEmailVerified: false
			}
		},

		mounted() {
			if (this.emailVerified) {
				this.showEmailVerified = true;

				setTimeout(() => {
					this.showEmailVerified = false;
				}, 5000);
			}
		},

		methods: {

		},

		computed: {

		}
	}
</script>