<template>
	<input
		:value="modelValue"
		@input="$emit('update:modelValue', $event.target.value)"
		:class="cn('block w-full rounded-lg text-sm border-0 py-2.5 px-3 placeholder:text-gray-400 outline-none ring-2 ring-inset ring-gray-100 focus:ring-3 focus:ring-gray-100', receivedClass)"
	/>
</template>

<script>
	import Helper from "@/js/mixins/helper.js";

	export default {
		mixins: [
			Helper
		],

		props: {
			modelValue: {
				default: null
			},

			class: {
				default: ''
			}
		},

		emits: ['update:modelValue'],

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
