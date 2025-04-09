
const SocialAuth = {
	data: function() {
		return {
			authenticating: false,
			googleAuth: null
		}
	},

	created() {
		setTimeout(() => {
			this.initGoogleClient();
		}, 200);
	},

	methods: {
		logInWithFacebook() {
			if (this.authenticating) {
				return;
			}

			this.authenticating = true;

			this.getFacebookAccessToken()
				.then((token) => {
					this.$inertia.post(
						'/login/facebook',
						{ token: token },
						{ onFinish: () => this.authenticating = false }
					);
				})
				.catch((error) => {
					console.error((error));
					this.authenticating = false;
				});
		},

		getFacebookAccessToken() {
			return new Promise((resolve, reject) => {
				let token = FB.getAccessToken();

				if (token) {
					resolve(token);
				} else {
					FB.login(function(response) {
						if (response.authResponse?.accessToken) {
							resolve(response.authResponse?.accessToken);
						} else {
							reject('Request canceled.');
						}
					}, {scope: 'email'});
				}
			});
		},

		initGoogleClient() {
			if (this.$isBrowser) {
				const _google = window.google || null;

				if (window.googleClientId) {
					this.googleAuth = _google?.accounts?.oauth2?.initTokenClient({
						client_id: window.googleClientId,
						scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
						callback: this.handleGoogleAccessTokenResponse
					});
				}
			}
		},

		logInWithGoogle() {
			if (this.authenticating) {
				return;
			}

			this.getGoogleAccessToken();
		},

		handleGoogleAccessTokenResponse(tokenResponse) {
			this.$inertia.post(
				'/login/google',
				{ token: tokenResponse.access_token },
				{ onFinish: () => this.authenticating = false }
			);
		},

		getGoogleAccessToken() {
			this.googleAuth?.requestAccessToken();
		}
	}
}

export default SocialAuth;