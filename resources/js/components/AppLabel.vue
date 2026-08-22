<template>
	<label :class="cn('block font-semibold mb-1 text-sm', receivedClass)">
		<slot></slot>
	</label>
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
