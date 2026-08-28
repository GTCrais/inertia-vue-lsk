import { http as inertiaHttp } from '@inertiajs/vue3';
import http from "@/js/lib/http";
/*import Echo from 'laravel-echo';
import Pusher from 'pusher-js';*/

class Bootstrap
{
	static setupLibraries(app)
	{
		// This is needed because of SSR
		if (this.librariesAreSetUp) {
			return;
		}

		if (typeof window !== 'undefined') {
			/*this.attachEchoSocketIdToRequests();

			window.Pusher = Pusher;
			window.Echo = new Echo({
				broadcaster: 'pusher',
				key: import.meta.env.VITE_PUSHER_APP_KEY,
				cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
				forceTLS: true,
				// wsHost: import.meta.env.VITE_PUSHER_HOST,
				// wsPort: import.meta.env.VITE_PUSHER_PORT,
				// wssPort: import.meta.env.VITE_PUSHER_PORT,
				// enabledTransports: ['ws', 'wss'],
			});*/
		}

		this.librariesAreSetUp = true;
	}

	/*
	* This is required for broadcast(...)->toOthers() to work
	* */
	static attachEchoSocketIdToRequests()
	{
		const withSocketId = (config) => {
			const socketId = window.Echo?.socketId();

			if (socketId) {
				config.headers['X-Socket-Id'] = socketId;
			}

			return config;
		};

		inertiaHttp.onRequest(withSocketId);
		http.interceptors.request.use(withSocketId);
	}
}

export default Bootstrap;
