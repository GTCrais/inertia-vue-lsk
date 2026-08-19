<template>
	<header class="py-4 border-b border-b-gray-200">
		<container>
			<nav class="flex items-center justify-between">
				<app-link href="/" prefetch>
					YourApp
				</app-link>

				<div v-if="user">
					<app-link href="/account" class="mr-4" prefetch>
						Account
					</app-link>

					<a href="#" @click.prevent="logout">
						Logout
					</a>
				</div>

				<div v-else>
					<app-link href="/login" class="mr-4" prefetch>
						Login
					</app-link>

					<app-link href="/register" prefetch>
						Register
					</app-link>
				</div>
			</nav>
		</container>
	</header>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import { router } from "@inertiajs/vue3";

	export default {
		components: {
			Container
		},

		props: {
			user: Object
		},

		data() {
			return {

			}
		},

		mounted() {

		},

		methods: {
			logout() {
				router.post('/logout');
			}
		},

		computed: {

		}
	}
</script>