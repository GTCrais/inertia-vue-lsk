import axios from 'axios';

const http = axios.create({
	headers: {
		'X-Requested-With': 'XMLHttpRequest'
	},
	withCredentials: true,
	withXSRFToken: true
});

export default http;
