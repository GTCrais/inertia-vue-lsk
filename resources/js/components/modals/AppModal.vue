<template>
	<TransitionRoot as="template" :show="isOpen">
		<Dialog class="relative z-100" @close="close">
			<TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="" leave="ease-in duration-200" leave-from="" leave-to="opacity-0">
				<div class="fixed inset-0 bg-gray-500/40 transition-opacity backdrop-blur-sm" />
			</TransitionChild>

			<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
				<div class="flex min-h-full justify-center p-6 text-center sm:items-center sm:p-0"
					 :class="contentContainerClasses"
				>
					<TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to=" translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from=" translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
						<DialogPanel class="relative transform overflow-hidden rounded-2xl bg-white px-4 pt-5 pb-4 text-left shadow-lg transition-all sm:my-8 w-full max-w-md sm:p-6">
							<button
								v-if="showCloseButton"
								type="button"
								class="absolute top-[15px] right-[15px] cursor-pointer rounded-xs opacity-70 transition-opacity hover:opacity-100 focus:ring-2 focus:ring-offset-2 focus:outline-hidden [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4"
								@click="close"
							>
								<X />
								<span class="sr-only">Close</span>
							</button>

							<slot></slot>
						</DialogPanel>
					</TransitionChild>
				</div>
			</div>
		</Dialog>
	</TransitionRoot>
</template>

<script>
	import { X } from "@lucide/vue";
	import {
		Dialog, DialogPanel, TransitionChild, TransitionRoot
	} from "@headlessui/vue";

	export default {
		components: {
			DialogPanel, TransitionChild,
			Dialog, TransitionRoot, X
		},

		props: {
			isOpen: {
				default: false
			},

			showCloseButton: {
				default: true
			},

			position: {
				default: 'end'
			}
		},

		data() {
			return {

			}
		},

		mounted() {

		},

		methods: {
			close() {
				this.$emit('close')
			}
		},

		computed: {
			contentContainerClasses() {
				const classes = [];

				if (this.position === 'center') {
					classes.push('items-center');
				} else {
					classes.push('items-end');
				}

				return classes;
			}
		}
	}
</script>