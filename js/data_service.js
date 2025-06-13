class DataService {
    constructor() {
        this.baseUrl = '/data';
    }

    async get(endpoint) {
        try {
            const response = await fetch(`${this.baseUrl}/${endpoint}.json`);
            if (!response.ok) throw new Error('Network response was not ok');
            return await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
            throw error;
        }
    }

    async update(endpoint, data) {
        try {
            const response = await fetch(`${this.baseUrl}/${endpoint}.json`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) throw new Error('Network response was not ok');
            return await response.json();
        } catch (error) {
            console.error('Error updating data:', error);
            throw error;
        }
    }

    async create(endpoint, data) {
        try {
            const response = await fetch(`${this.baseUrl}/${endpoint}.json`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) throw new Error('Network response was not ok');
            return await response.json();
        } catch (error) {
            console.error('Error creating data:', error);
            throw error;
        }
    }

    async delete(endpoint, id) {
        try {
            const response = await fetch(`${this.baseUrl}/${endpoint}.json/${id}`, {
                method: 'DELETE'
            });
            if (!response.ok) throw new Error('Network response was not ok');
            return await response.json();
        } catch (error) {
            console.error('Error deleting data:', error);
            throw error;
        }
    }

    // Authentication methods
    async login(credentials, isProvider = false) {
        const endpoint = isProvider ? 'provider_login' : 'login';
        try {
            const users = await this.get('users');
            const userType = isProvider ? 'providers' : 'patients';
            const user = users[userType].find(u => 
                u.email === credentials.email && 
                u.password === credentials.password
            );
            
            if (user) {
                // Store user session
                sessionStorage.setItem('currentUser', JSON.stringify({
                    id: user.id,
                    username: user.username,
                    email: user.email,
                    type: userType
                }));
                return user;
            }
            throw new Error('Invalid credentials');
        } catch (error) {
            console.error('Login error:', error);
            throw error;
        }
    }

    async register(userData) {
        try {
            const users = await this.get('users');
            const newUser = {
                id: `patient${users.patients.length + 1}`.padStart(3, '0'),
                ...userData
            };
            users.patients.push(newUser);
            await this.update('users', users);
            return newUser;
        } catch (error) {
            console.error('Registration error:', error);
            throw error;
        }
    }

    // Helper methods
    getCurrentUser() {
        const userStr = sessionStorage.getItem('currentUser');
        return userStr ? JSON.parse(userStr) : null;
    }

    logout() {
        sessionStorage.removeItem('currentUser');
    }
}

// Create a single instance to be used throughout the application
const dataService = new DataService();