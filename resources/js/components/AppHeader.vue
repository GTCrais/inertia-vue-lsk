<template>
	<header class="py-4 border-b border-b-gray-200">
		<container>
			<nav class="flex items-center justify-between">
				<app-link href="/" class="mr-6" prefetch>
					<img src="/img/logos/app_logo.png" alt="" class="transition-[height] subpixel-antialiased" :class="scrolled ? ['h-[28px]'] : ['h-[28px] sm:h-[35px]']">
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
				scrolled: false
			}
		},

		mounted() {
			window.addEventListener("scroll", this.handleScroll, { passive: true });
		},

		beforeUnmount() {
			window.removeEventListener("scroll", this.handleScroll);
		},

		methods: {
			logout() {
				router.post('/logout');
			},

			handleScroll() {
				if (window.scrollY > 90 && !this.scrolled) {
					this.scrolled = true;
				} else if (window.scrollY < 55 && this.scrolled) {
					this.scrolled = false;
				}
			}
		},

		computed: {

		}
	}
</script>