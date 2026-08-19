import Bootstrap from "@/js/bootstrap/bootstrap";
import { createInertiaApp, Link } from '@inertiajs/vue3';
import DefaultLayout from "@/js/layouts/DefaultLayout.vue";
import isServer from "@/js/plugins/isServer.js";

createInertiaApp({
	pages: './pages',
	layout: () => DefaultLayout,

	withApp(app, { ssr }) {
		if (!ssr) {
			Bootstrap.setupAxios();
		}

		Bootstrap.setupLibraries(app);

		app.use(isServer)
			.component('AppLink', Link);
	}
});
