<template>
	<footer class="py-4 border-t border-t-gray-200">
		<container class="text-center">
			&copy; Copyright YourApp {{ year }}
		</container>
	</footer>
</template>

<script>
	import Container from "@/js/components/Container.vue";

	export default {
		components: { Container },
		props: {

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
			year() {
				return new Date().getFullYear();
			}
		}
	}
</script>