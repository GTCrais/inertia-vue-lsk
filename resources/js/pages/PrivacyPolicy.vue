<template>
	<container class="pt-10 pb-4">
		<div class="m-auto w-5xl max-w-full">
			<h1 class="mb-3 text-center text-3xl font-bold">
				Privacy policy
			</h1>

			<div class="text-center mb-10">
				Last updated on January 1, 2026.
			</div>

			<card class="p-6 sm:p-12">
				<p class="mb-6">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur corporis expedita fugiat id
					illum itaque libero magnam minima minus placeat provident quasi quis recusandae rem, repudiandae,
					rerum, sint tenetur unde.
				</p>

				<h4 class="text-2xl font-headings mb-2">LOREM IPSUM</h4>

				<p class="mb-6">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aut beatae cupiditate debitis
					deserunt earum eligendi excepturi expedita, harum impedit iste minima nam officiis provident
					reiciendis, sapiente suscipit voluptas voluptate.
				</p>
			</card>
		</div>
	</container>
</template>

<script>
	import Container from "@/js/components/Container.vue";
	import Card from "@/js/components/Card.vue";

	export default {
		components: {
			Card, Container
		},

		props: {

		},

		data() {
			return {}
		},

		mounted() {

		},

		methods: {},

		computed: {
			ma() {
				return ['info', '@', 'yourapp.com'].join('');
			}
		}
	}
</script>