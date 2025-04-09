import Bootstrap from "@/js/bootstrap/bootstrap";
import { createApp, createSSRApp, h } from "vue";
import { createInertiaApp } from '@inertiajs/vue3';
import DefaultLayout from "@/js/layouts/DefaultLayout.vue";
import { Link } from '@inertiajs/vue3';

Bootstrap.setupAxios();

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
		const page = pages[`./pages/${name}.vue`];

		page.default.layout = page.default.layout || DefaultLayout;

		return page;
	},

	setup({ el, App, props, plugin }) {
		const appOptions = { render: () => h(App, props) };
		const app = import.meta.env.VITE_SSR ?
			createSSRApp(appOptions) :
			createApp(appOptions);

		app.use(plugin)
			.component('AppLink', Link)
			.mount(el);

		Bootstrap.setupLibraries(app);
	}
});