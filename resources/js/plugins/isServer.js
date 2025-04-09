
export default {
	install: (app, options) => {
		app.config.globalProperties.$isServer = (typeof window === 'undefined');
		app.config.globalProperties.$isBrowser = (typeof window !== 'undefined');
	}
}