import { twMerge } from "tailwind-merge";
import { clsx } from "clsx";

export default {
	data() {
		return {};
	},

	methods: {
		cn(...inputs) {
			return twMerge(clsx(inputs));
		}
	}
}