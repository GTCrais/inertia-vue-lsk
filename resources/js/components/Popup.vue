<template>
	<div class="relative" ref="dropdown">
		<slot :toggleDropdown="toggleDropdown"></slot>

		<div v-show="popupOpen"
			 :class="cn('absolute right-0 mt-2 flex w-[250px] sm:w-[295px] flex-col rounded-2xl border border-gray-100 bg-white p-3 shadow-lg z-15', receivedPopupClass)"
		>
			<slot name="popup" :close="closeDropdown"></slot>
		</div>
	</div>
</template>

<script>
	import Helper from "@/js/mixins/helper.js";

	export default {
		mixins: [
			Helper
		],

		props: {
			popupClass: {
				default: ''
			}
		},

		data() {
			return {
				popupOpen: false
			}
		},

		mounted() {
			document.addEventListener('click', this.handleClickOutside);
		},

		beforeUnmount() {
			document.removeEventListener('click', this.handleClickOutside);
		},

		methods: {
			toggleDropdown() {
				this.popupOpen = !this.popupOpen;
			},

			closeDropdown() {
				this.popupOpen = false;
			},

			handleClickOutside(event) {
				if (this.$refs.dropdown && !this.$refs.dropdown.contains(event.target)) {
					this.closeDropdown();
				}
			}
		},

		computed: {
			receivedPopupClass() {
				return this.popupClass;
			}
		}
	}
</script>