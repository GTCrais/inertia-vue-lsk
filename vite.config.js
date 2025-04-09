import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

export default defineConfig(({ mode }) => {
	const env = loadEnv(mode, process.cwd());
	const laravelConfig = {
		input: ['resources/css/app.css', 'resources/js/app.js'],
		refresh: true,
	};

	if (env.VITE_SSR) {
		const viteSsr = env.VITE_SSR.toLowerCase();

		if (!['false', 'null'].includes(viteSsr)) {
			laravelConfig.ssr = 'resources/js/ssr.js';
		}
	}

	return {
		resolve: {
			alias: {
				'@': path.resolve(__dirname, './resources')
			}
		},
		plugins: [
			laravel(laravelConfig),
			vue({
				template: {
					transformAssetUrls: {
						// The Vue plugin will re-write asset URLs, when referenced
						// in Single File Components, to point to the Laravel web
						// server. Setting this to `null` allows the Laravel plugin
						// to instead re-write asset URLs to point to the Vite
						// server instead.
						base: null,

						// The Vue plugin will parse absolute URLs and treat them
						// as absolute paths to files on disk. Setting this to
						// `false` will leave absolute URLs un-touched so they can
						// reference assets in the public directory as expected.
						includeAbsolute: false,
					},
				},
			}),
			tailwindcss()
		]
	}
});
