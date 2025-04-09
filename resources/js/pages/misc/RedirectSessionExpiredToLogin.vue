<template>
	<container class="py-4 flex-grow flex justify-center items-center">
		<strong class="text-2xl">Just a second...</strong>
	</container>
</template>

<script>
	/*
	* See App\Bootstrappers\ExceptionsHandler::class for an explanation for this component.
	*/

	import Container from "@/js/components/Container.vue";

	export default {
		components: {
			Container
		},

		props: {

		},

		data: function() {
			return {

			}
		},

		created() {
			this.$inertia.get('/login?authenticationExpired')
		},

		mounted() {

		},

		methods: {

		},

		computed: {

		}
	}
</script>