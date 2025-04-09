<template>
	<container class="py-4 flex-grow flex justify-center items-center">
		<div>
			<strong class="text-2xl">Error {{ statusCode }}</strong>

			<div>
				{{ message }}
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
		    statusCode: {
				default: ''
			}
		},

		data: function() {
			return {

			}
		},

		mounted() {

		},

		methods: {

		},

		computed: {
			message() {
				if (this.statusCode === 500) {
					return 'Something\'s wrong! We\'re working on it!';
				}

				if (this.statusCode === 503) {
					return 'Service unavailable. We\'re working on it!';
				}

				if (this.statusCode === 404) {
					return 'You might be lost.';
				}

				if (this.statusCode === 403) {
					return 'Sorry, you\'re not allowed to be here ;)';
				}

				return 'Something\'s wrong! We\'re working on it!';
			}
		}
	}
</script>