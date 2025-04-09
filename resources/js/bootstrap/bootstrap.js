import axios from 'axios';

class Bootstrap
{
	static setupAxios()
	{
		window.axios = axios;
		window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		window.axios.defaults.withCredentials = true;
		window.axios.defaults.withXSRFToken = true;
	}

	static setupLibraries(app)
	{

	}
}

export default Bootstrap;

