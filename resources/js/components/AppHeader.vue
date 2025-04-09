<template>
	<header class="py-4 border-b border-b-gray-200">
		<container>
			<nav class="flex items-center justify-between">
				<app-link href="/">
					YourApp
				</app-link>

				<div v-if="user">
					<app-link href="/account" class="mr-4">
						Account
					</app-link>

					<a href="#" @click.prevent="logout">
						Logout
					</a>
				</div>

				<div v-else>
					<app-link href="/login" class="mr-4">
						Login
					</app-link>

					<app-link href="/register">
						Register
					</app-link>
				</div>
			</nav>
		</container>
	</header>
</template>

<script>
	import Container from "@/js/components/Container.vue";

	export default {
		components: {
			Container
		},

		props: {
			user: Object
		},

		data: function() {
			return {

			}
		},

		mounted() {

		},

		methods: {
			logout() {
				this.$inertia.post('/logout');
			}
		},

		computed: {

		}
	}
</script>