<template>
	<container class="py-4 flex-grow flex justify-center items-center">
		<div>
			<div class="mb-6 text-xl">
				Email successfully verified.
			</div>

			<div v-if="requestType === 'stateless'" class="mb-6 text-xl">
				Please refresh the page in your mobile app.
			</div>

			<app-link href="/login"
			   class="cursor-pointer rounded border border-gray-200 px-4 py-2 hover:border-gray-300 transition-colors"
			>
				Login
			</app-link>
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
		    requestType: {
				default: 'stateful'
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

		}
	}
</script>