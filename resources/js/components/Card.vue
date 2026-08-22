<template>
	<div :class="cn('bg-white p-4 sm:p-6 rounded-2xl border border-gray-100 shadow-md/5', receivedClass)">
		<slot></slot>
	</div>
</template>

<script>
	import Helper from "@/js/mixins/helper.js";

	export default {
		mixins: [
			Helper
		],

		props: {
			class: {
				default: ''
			}
		},

		data() {
			return {}
		},

		mounted() {

		},

		methods: {

		},

		computed: {
			receivedClass() {
				return this.class;
			}
		}
	}
</script>