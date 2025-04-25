class ApiClient {
    constructor() {
        this.baseUrl = 'http://localhost:8000/api';
        this.token = localStorage.getItem('api_token');
    }

    setToken(token) {
        this.token = token;
        localStorage.setItem('api_token', token);
    }

    getToken() {
        return this.token;
    }

    async request(method, endpoint, data = null) {
        const url = this.baseUrl + endpoint;
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };

        if (this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }

        const options = {
            method,
            headers,
            credentials: 'include',
            mode: 'cors'
        };

        if (data) {
            options.body = JSON.stringify(data);
        }

        try {
            console.log(`API Request: ${method} ${url}`);
            if (data) {
                console.log('Request Data:', data);
            }

            const response = await fetch(url, options);
            const responseData = await response.json();

            console.log(`API Response Code: ${response.status}`);
            console.log('API Response:', responseData);

            if (!response.ok) {
                throw new Error(responseData.message || 'API request failed');
            }

            return responseData;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    async get(endpoint, data = null) {
        return this.request('GET', endpoint, data);
    }

    async post(endpoint, data = null) {
        return this.request('POST', endpoint, data);
    }

    async put(endpoint, data = null) {
        return this.request('PUT', endpoint, data);
    }

    async delete(endpoint) {
        return this.request('DELETE', endpoint);
    }
}

// Create a global instance
window.apiClient = new ApiClient(); 