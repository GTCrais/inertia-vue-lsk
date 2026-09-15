<template>
	<container class="pt-10 pb-4">
		<div class="m-auto w-5xl max-w-full">
			<h1 class="mb-3 text-center text-3xl font-bold">
				Terms of service
			</h1>

			<div class="text-center mb-10">
				Last updated on January 1, 2026.
			</div>

			<card class="p-6 sm:p-12">
				<h4 class="text-2xl font-headings mb-2">OVERVIEW</h4>

				<p class="mb-6">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur corporis expedita fugiat id
					illum itaque libero magnam minima minus placeat provident quasi quis recusandae rem, repudiandae,
					rerum, sint tenetur unde.
				</p>
				<p class="mb-6">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, corporis culpa debitis ea
					esse est laboriosam nesciunt placeat quibusdam quisquam quo repellendus rerum sint voluptatem
					voluptatibus! Dolor facilis laborum necessitatibus.
				</p>

				<h4 class="text-2xl font-headings mb-2">LOREM IPSUM</h4>

				<p class="mb-6">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aut beatae cupiditate debitis
					deserunt earum eligendi excepturi expedita, harum impedit iste minima nam officiis provident
					reiciendis, sapiente suscipit voluptas voluptate.
				</p>
				<p class="mb-6">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum hic incidunt iste laudantium
					tempora? Deserunt incidunt, labore? Aliquam autem eligendi est eum, molestias nam necessitatibus,
					quibusdam quidem quod repellendus ullam.
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
			Container, Card
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