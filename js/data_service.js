class DataService {
    static instance = null;

    constructor() {
        if (DataService.instance) {
            return DataService.instance;
        }
        DataService.instance = this;
        this.baseUrl = '/data';
        this.useSqlite = true; // Set to true to use SQLite, false for JSON files
        this.db = null; // SQLite database instance
    }

    async initSqlite() {
        if (this.db) return; // Already initialized

        try {
            const SQL = await initSqlJs({
                locateFile: file => `js/lib/${file}`
            });
            this.db = new SQL.Database();
            console.log('SQLite database initialized.');

            // Create tables if they don't exist and populate with seed data
            // This is a simplified example. In a real app, you'd load from a .sqlite file or more robustly manage schema/migrations.
            this.db.run(`
                CREATE TABLE IF NOT EXISTS users (
                    id TEXT PRIMARY KEY,
                    username TEXT,
                    email TEXT UNIQUE,
                    password TEXT,
                    type TEXT
                );
                CREATE TABLE IF NOT EXISTS patients (
                    id TEXT PRIMARY KEY,
                    username TEXT,
                    email TEXT UNIQUE,
                    password TEXT,
                    nhimaId TEXT
                );
                CREATE TABLE IF NOT EXISTS providers (
                    id TEXT PRIMARY KEY,
                    username TEXT,
                    email TEXT UNIQUE,
                    password TEXT,
                    providerId TEXT
                );
                CREATE TABLE IF NOT EXISTS past_visits (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    date TEXT,
                    doctor TEXT,
                    reason TEXT,
                    notes TEXT
                );
            `);
            console.log('SQLite tables created/checked.');

            // Load initial data from users.json into SQLite if not already present
            const usersJson = await this._getJson('users');
            if (usersJson && usersJson.patients && usersJson.providers) {
                // Check if users table is empty before inserting
                const {values} = this.db.exec("SELECT COUNT(*) FROM users")[0];
                if (values[0][0] === 0) {
                    usersJson.patients.forEach(p => {
                        this.db.run(`INSERT INTO users (id, username, email, password, type) VALUES (?, ?, ?, ?, ?)`, [p.id, p.username, p.email, p.password, 'patient']);
                        this.db.run(`INSERT INTO patients (id, username, email, password, nhimaId) VALUES (?, ?, ?, ?, ?)`, [p.id, p.username, p.email, p.password, p.nhimaId]);
                    });
                    usersJson.providers.forEach(pr => {
                        this.db.run(`INSERT INTO users (id, username, email, password, type) VALUES (?, ?, ?, ?, ?)`, [pr.id, pr.username, pr.email, pr.password, 'provider']);
                        this.db.run(`INSERT INTO providers (id, username, email, password, providerId) VALUES (?, ?, ?, ?, ?)`, [pr.id, pr.username, pr.email, pr.password, pr.providerId]);
                    });
                    console.log('Initial data loaded into SQLite from users.json.');
                }
            }

            // Load initial data for past_visits if not already present
            const pastVisitsJson = await this._getJson('history'); // Assuming history.json contains past visits
            if (pastVisitsJson && pastVisitsJson.pastVisits) {
                const {values} = this.db.exec("SELECT COUNT(*) FROM past_visits")[0];
                if (values[0][0] === 0) {
                    pastVisitsJson.pastVisits.forEach(visit => {
                        this.db.run(`INSERT INTO past_visits (date, doctor, reason, notes) VALUES (?, ?, ?, ?)`, [visit.date, visit.doctor, visit.reason, visit.notes]);
                    });
                    console.log('Initial data loaded into SQLite from history.json for past visits.');
                }
            }

        } catch (error) {
            console.error('Failed to initialize SQLite:', error);
            this.useSqlite = false; // Fallback to JSON if SQLite fails
        }
    }

    static async fetchData(filePath) {
        try {
            const response = await axios.get(filePath);
            return response.data;
        } catch (error) {
            console.error(`Error fetching data from ${filePath}:`, error);
            throw new Error(`Could not fetch data from ${filePath}: ${error.message}`);
        }
    }

    async _getJson(endpoint) {
        try {
            const response = await axios.get(`${this.baseUrl}/${endpoint}.json`);
            return response.data;
        } catch (error) {
            console.error(`Error fetching JSON from ${endpoint}.json:`, error);
            throw new Error(`Could not fetch JSON from ${endpoint}.json: ${error.message}`);
        }
    }

    async get(endpoint) {
        if (this.useSqlite) {
            await this.initSqlite();
            try {
                let queryResult;
                if (endpoint === 'users') {
                    const patients = this.db.exec("SELECT id, username, email, password, nhimaId FROM patients");
                    const providers = this.db.exec("SELECT id, username, email, password, providerId FROM providers");
                    queryResult = {
                        patients: patients.length > 0 ? patients[0].values.map(row => ({id: row[0], username: row[1], email: row[2], password: row[3], nhimaId: row[4]})) : [],
                        providers: providers.length > 0 ? providers[0].values.map(row => ({id: row[0], username: row[1], email: row[2], password: row[3], providerId: row[4]})) : []
                    };
                } else if (endpoint === 'history') {
                    const pastVisits = this.db.exec("SELECT date, doctor, reason, notes FROM past_visits");
                    queryResult = pastVisits.length > 0 ? pastVisits[0].values.map(row => ({date: row[0], doctor: row[1], reason: row[2], notes: row[3]})) : [];
                } else {
                    // For other endpoints, you'd need corresponding tables and queries
                    console.warn(`SQLite 'get' not implemented for endpoint: ${endpoint}. Falling back to JSON.`);
                    return this._getJson(endpoint);
                }
                return queryResult;
            } catch (error) {
                console.error('SQLite GET error:', error);
                throw error;
            }
        } else {
            return this._getJson(endpoint);
        }
    }

    async update(endpoint, data) {
        if (this.useSqlite) {
            await this.initSqlite();
            try {
                if (endpoint === 'users') {
                    // This is a simplified update for users. In a real app, you'd update specific user fields.
                    // For now, it assumes 'data' contains the full users object to replace.
                    // This is not a typical SQL update, but rather a re-insertion for demonstration.
                    this.db.run("DELETE FROM users");
                    this.db.run("DELETE FROM patients");
                    this.db.run("DELETE FROM providers");

                    data.patients.forEach(p => {
                        this.db.run(`INSERT INTO users (id, username, email, password, type) VALUES (?, ?, ?, ?, ?)`, [p.id, p.username, p.email, p.password, 'patient']);
                        this.db.run(`INSERT INTO patients (id, username, email, password, nhimaId) VALUES (?, ?, ?, ?, ?)`, [p.id, p.username, p.email, p.password, p.nhimaId]);
                    });
                    data.providers.forEach(pr => {
                        this.db.run(`INSERT INTO users (id, username, email, password, type) VALUES (?, ?, ?, ?, ?)`, [pr.id, pr.username, pr.email, pr.password, 'provider']);
                        this.db.run(`INSERT INTO providers (id, username, email, password, providerId) VALUES (?, ?, ?, ?, ?)`, [pr.id, pr.username, pr.email, pr.password, pr.providerId]);
                    });
                    return { success: true };
                } else {
                    console.warn(`SQLite 'update' not implemented for endpoint: ${endpoint}. Falling back to JSON.`);
                    try {
                        const response = await axios.put(`${this.baseUrl}/${endpoint}.json`, data);
                        return response.data;
                    } catch (error) {
                        console.error(`Error updating JSON for ${endpoint}.json:`, error);
                        throw new Error(`Could not update JSON for ${endpoint}.json: ${error.message}`);
                    }
                }
            } catch (error) {
                console.error('SQLite UPDATE error:', error);
                throw error;
            }
        } else {
            try {
                const response = await axios.put(`${this.baseUrl}/${endpoint}.json`, data);
                return response.data;
            } catch (error) {
                console.error(`Error updating JSON for ${endpoint}.json:`, error);
                throw new Error(`Could not update JSON for ${endpoint}.json: ${error.message}`);
            }
        }
    }

    async create(endpoint, data) {
        if (this.useSqlite) {
            await this.initSqlite();
            try {
                if (endpoint === 'users') {
                    const userType = data.type;
                    const newId = `${userType}${this.db.exec(`SELECT COUNT(*) FROM ${userType}s`)[0].values[0][0] + 1}`.padStart(3, '0');
                    this.db.run(`INSERT INTO users (id, username, email, password, type) VALUES (?, ?, ?, ?, ?)`, [newId, data.username, data.email, data.password, userType]);
                    if (userType === 'patient') {
                        this.db.run(`INSERT INTO patients (id, username, email, password, nhimaId) VALUES (?, ?, ?, ?, ?)`, [newId, data.username, data.email, data.password, data.nhimaId]);
                    } else if (userType === 'provider') {
                        this.db.run(`INSERT INTO providers (id, username, email, password, providerId) VALUES (?, ?, ?, ?, ?)`, [newId, data.username, data.email, data.password, data.providerId]);
                    }
                    return { id: newId, ...data };
                } else {
                    console.warn(`SQLite 'create' not implemented for endpoint: ${endpoint}. Falling back to JSON.`);
                    try {
                        const response = await axios.post(`${this.baseUrl}/${endpoint}.json`, data);
                        return response.data;
                    } catch (error) {
                        console.error(`Error creating JSON for ${endpoint}.json:`, error);
                        throw new Error(`Could not create JSON for ${endpoint}.json: ${error.message}`);
                    }
                }
            } catch (error) {
                console.error('SQLite CREATE error:', error);
                throw error;
            }
        } else {
            return await fetch(`${this.baseUrl}/${endpoint}.json`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            }).then(res => res.json());
        }
    }

    async getPastVisits() {
        if (this.useSqlite) {
            await this.initSqlite();
            try {
                const pastVisits = this.db.exec("SELECT date, doctor, reason, notes FROM past_visits");
                return pastVisits.length > 0 ? pastVisits[0].values.map(row => ({date: row[0], doctor: row[1], reason: row[2], notes: row[3]})) : [];
            } catch (error) {
                console.error('SQLite getPastVisits error:', error);
                throw error;
            }
        } else {
            const historyJson = await this._getJson('history');
            return historyJson.pastVisits || [];
        }
    }

    async delete(endpoint, id) {
        if (this.useSqlite) {
            await this.initSqlite();
            try {
                if (endpoint === 'users') {
                    this.db.run(`DELETE FROM users WHERE id = ?`, [id]);
                    this.db.run(`DELETE FROM patients WHERE id = ?`, [id]);
                    this.db.run(`DELETE FROM providers WHERE id = ?`, [id]);
                    return { success: true };
                } else {
                    console.warn(`SQLite 'delete' not implemented for endpoint: ${endpoint}. Falling back to JSON.`);
                    return await fetch(`${this.baseUrl}/${endpoint}.json/${id}`, {
                        method: 'DELETE'
                    }).then(res => res.json());
                }
            } catch (error) {
                console.error('SQLite DELETE error:', error);
                throw error;
            }
        } else {
            return await fetch(`${this.baseUrl}/${endpoint}.json/${id}`, {
                method: 'DELETE'
            }).then(res => res.json());
        }
    }

    // Authentication methods
    async login(credentials, isProvider = false) {
        if (this.useSqlite) {
            await this.initSqlite();
            try {
                const userType = isProvider ? 'provider' : 'patient';
                const query = `SELECT id, username, email, password, type FROM users WHERE email = ? AND password = ? AND type = ?`;
                const result = this.db.exec(query, [credentials.email, credentials.password, userType]);

                if (result.length > 0 && result[0].values.length > 0) {
                    const userRow = result[0].values[0];
                    const user = {
                        id: userRow[0],
                        username: userRow[1],
                        email: userRow[2],
                        type: userRow[4]
                    };
                    sessionStorage.setItem('currentUser', JSON.stringify(user));
                    return user;
                }
                throw new Error('Invalid credentials');
            } catch (error) {
                console.error('SQLite Login error:', error);
                throw error;
            }
        } else {
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
    }

    async register(userData) {
        if (this.useSqlite) {
            await this.initSqlite();
            try {
                const userType = userData.type || 'patient'; // Default to patient if not specified
                const newId = `${userType}${this.db.exec(`SELECT COUNT(*) FROM ${userType}s`)[0].values[0][0] + 1}`.padStart(3, '0');
                this.db.run(`INSERT INTO users (id, username, email, password, type) VALUES (?, ?, ?, ?, ?)`, [newId, userData.username, userData.email, userData.password, userType]);
                if (userType === 'patient') {
                    this.db.run(`INSERT INTO patients (id, username, email, password, nhimaId) VALUES (?, ?, ?, ?, ?)`, [newId, userData.username, userData.email, userData.password, userData.nhimaId]);
                } else if (userType === 'provider') {
                    this.db.run(`INSERT INTO providers (id, username, email, password, providerId) VALUES (?, ?, ?, ?, ?)`, [newId, userData.username, userData.email, userData.password, userData.providerId]);
                }
                return { id: newId, ...userData };
            } catch (error) {
                console.error('SQLite Registration error:', error);
                throw error;
            }
        } else {
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

// Load sql.js library
const loadSqlJs = async () => {
    // Check if initSqlJs is already defined (e.g., if loaded via CDN in HTML)
    if (typeof initSqlJs === 'undefined') {
        const script = document.createElement('script');
        script.src = 'js/lib/sql-wasm.js';
        document.head.appendChild(script);
        return new Promise((resolve) => {
            script.onload = () => resolve(window.initSqlJs);
        });
    } else {
        return window.initSqlJs;
    }
};

// Initialize DataService and potentially SQLite
const dataService = new DataService();

// Automatically initialize SQLite if useSqlite is true
if (dataService.useSqlite) {
    loadSqlJs().then(initSqlJs => {
        window.initSqlJs = initSqlJs; // Make it globally available if not already
        dataService.initSqlite();
    }).catch(error => {
        console.error('Failed to load sql.js:', error);
        dataService.useSqlite = false; // Fallback to JSON if loading fails
    });
}