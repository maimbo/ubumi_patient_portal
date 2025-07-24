class LoginService {
    constructor() {
        this.db = null;
    }

    async initialize() {
        // Wait for PatientPortalDB to be ready
        if (!window.PatientPortalDB) {
            await new Promise(resolve => {
                const checkInterval = setInterval(() => {
                    if (window.PatientPortalDB) {
                        clearInterval(checkInterval);
                        resolve();
                    }
                }, 100);
            });
        }
        this.db = window.PatientPortalDB.db;
        
        // Load initial users if database is empty
        const userCount = await this.db.users.count();
        if (userCount === 0) {
            /// await this._loadInitialUsers(); // @disabled @since :: @seeding of users is handled in index.html
        }
        
        return this;
    }

    async _loadInitialUsers() {
        try {
            const response = await fetch('../data/users.json');
            const users = await response.json();
            
            // Add users to IndexedDB
            await this.db.users.bulkAdd(users);
            console.log('Initial users loaded from JSON');
        } catch (error) {
            console.error('Failed to load initial users:', error);
        }
    }

    async authenticate(username, password) {
        try {
            // Find user by username
            const user = await this.db.users
                .where('email')
                .equals(username)
                .first();

            if (!user) {
                return {
                    success: false,
                    message: 'User not found'
                };
            }

            // @debug
            console.log('login.js::authenticate::>user', user);

            // Verify password
            if (user.password !== password) {
                return {
                    success: false,
                    message: 'Invalid password'
                };
            }

            // save loggedInUser in sessionStorage
            sessionStorage.setItem('loggedInUser', JSON.stringify(user));

            // Return minimal user info
            return {
                success: true,
                user: {
                    username: user.username,
                    role: user.role
                }
            };

        } catch (error) {
            console.error('Login error:', error);
            return {
                success: false,
                message: 'Login failed'
            };
        }
    }
}

// Immediately initialize and expose LoginService
(function() {
    const loginService = new LoginService();
    
    // Initialize and expose via window
    loginService.initialize().then(() => {
        window.LoginService = loginService;
    }).catch(error => {
        console.error('Failed to initialize LoginService:', error);
    });
})();
