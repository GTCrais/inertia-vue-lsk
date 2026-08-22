<template>
	<component
		:is="tag"
		:type="href ? null : type"
		:href="href"
		class="rounded-full transition-colors outline-0 focus:outline-2"
		:class="classes"
		:disabled="href ? null : disabled"
	>
		<slot></slot>
	</component>
</template>

<script>
	import { Link } from "@inertiajs/vue3";

	export default {
		props: {
			href: {
				default: null
			},

			type: {
				default: 'button'
			},
			variant: {
				default: 'primary'
			},
			size: {
				default: 'sm'
			},
			disabled: {
				default: false
			}
		},

		data() {
			return {

			}
		},

		mounted() {

		},

		methods: {

		},

		computed: {
			tag() {
				return this.href ? Link : 'button';
			},

			classes() {
				const classes = [];

				if (this.href) {
					classes.push(...['inline-flex', 'items-center', 'justify-center']);
				}

				if (this.disabled) {
					classes.push(...['opacity-50', 'outline-none']);
				} else {
					classes.push('focus:outline-solid');
				}

				if (this.variant === 'primary') {
					classes.push(...['text-white', 'bg-sky-500'])

					if (!this.disabled) {
						classes.push(...['cursor-pointer', 'hover:bg-sky-400', 'outline-sky-300']);
					}
				} else if (this.variant === 'secondary') {
					classes.push(...['border', 'border-gray-100'])

					if (!this.disabled) {
						classes.push(...['cursor-pointer', 'hover:bg-gray-100', 'outline-gray-200']);
					}
				} else if (this.variant === 'secondaryAlt') {
					classes.push(...['bg-gray-100'])

					if (!this.disabled) {
						classes.push(...['cursor-pointer', 'hover:bg-gray-200', 'outline-gray-200']);
					}
				} else if (this.variant === 'danger') {
					classes.push(...['text-white', 'bg-red-500'])

					if (!this.disabled) {
						classes.push(...['cursor-pointer', 'hover:bg-red-400', 'outline-red-300']);
					}
				}

				if (this.size === 'xs') {
					classes.push(...['text-xs', 'px-4', 'h-[32px]']);
				} else if (this.size === 'sm') {
					classes.push(...['text-sm', 'px-4', 'h-[36px]']);
				} else if (this.size === 'md') {
					classes.push(...['text-base', 'px-4', 'h-[38px]']);
				} else if (this.size === 'lg') {
					classes.push(...['text-lg', 'px-6', 'h-[54px]']);
				}

				return classes;
			}
		}
	}
</script>