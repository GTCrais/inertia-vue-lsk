import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from '@vue/server-renderer'
import { createSSRApp, h } from 'vue'
import DefaultLayout from "@/js/layouts/DefaultLayout.vue";
import { Link } from '@inertiajs/vue3';

createServer((page) =>
	createInertiaApp({
		page,
		render: renderToString,

		resolve: (name) => {
			const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
			const page = pages[`./pages/${name}.vue`];

			page.default.layout = page.default.layout || DefaultLayout;

			return page;
		},

		setup({ App, props, plugin }) {
			const app = createSSRApp({
				render: () => h(App, props),
			});

			app.use(plugin).component('AppLink', Link);

			return app;
		},
	}),
)