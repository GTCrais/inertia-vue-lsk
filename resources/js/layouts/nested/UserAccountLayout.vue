<template>
	<container class="md:pt-10 pb-4">
		<div class="flex flex-col md:gap-6 md:flex-row w-4xl max-w-full mx-auto">
			<div class="overflow-x-auto pt-6 pb-2 md:w-[200px]">
				<nav class="flex flex-col w-full">
					<app-link
						v-for="tab in tabs"
					   	:href="tab.href"
					   	:key="'tab-' + tab.href"
					   	class="retain-text-color inline-flex items-center gap-x-3 px-3 py-2 text-sm transition-[background,font-weight] duration-200 ease-in-out rounded-lg sm:p-3"
					   	:class="[
							tabIsActive(tab) ?
							'text-sky-500 bg-sky-100 font-semibold'
							: 'bg-transparent text-gray-700 border-transparent hover:text-gray-900',
					   	]"
					>
						<div class="flex items-center justify-center w-4">
							<component
								:is="tab.icon"
								class="w-4"
								:stroke-width="tabIsActive(tab) ? 3 : 2"
							></component>
						</div>

						<span>
							{{ tab.label }}
						</span>
					</app-link>
				</nav>
			</div>

			<div class="flex-1 pt-2">
				<slot></slot>
			</div>
		</div>
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import { UserRound, LockKeyhole } from "@lucide/vue";
	import { markRaw } from "vue";

	export default {
		components: {
			Container
		},

		props: {

		},

		data() {
			return {
				tabs: [
					{
						label: 'Account',
						href: '/user/profile',
						icon: markRaw(UserRound)
					},
					{
						label: 'Password',
						href: '/user/password',
						icon: markRaw(LockKeyhole)
					}
				]
			}
		},

		mounted() {

		},

		methods: {
			tabIsActive(tab) {
				return (tab.href === this.$page.url);
			}
		},

		computed: {

		}
	}
</script>