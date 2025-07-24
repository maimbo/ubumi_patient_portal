// Dexie will be loaded via script tag in HTML
class PatientPortalDB {
    constructor() {
        this.db = new Dexie('PatientPortalDB');
        this._initializeSchema();
    }

    _initializeSchema() {
        this.db.version(1).stores({
            users: '++user_id, username, password, email, role, created_at, last_login',
            insuranceProviders: '++insurance_provider_id, name, contact_info',
            patients: '++patient_id, user_id, first_name, last_name, date_of_birth, gender, phone_number, address, city, state, zip_code, insurance_provider_id, policy_number',
            providers: '++provider_id, user_id, first_name, last_name, specialty, phone_number, email, address',
            services: '++service_id, service_name, description, duration_minutes, price',
            appointments: '++appointment_id, patient_id, provider_id, service_id, appointment_date, appointment_time, status, notes',
            medicalRecords: '++record_id, patient_id, record_type, record_date, description, provider_id',
            medications: '++medication_id, record_id, name, dosage, frequency, start_date, end_date',
            allergies: '++allergy_id, record_id, allergen, reaction, severity',
            procedures: '++procedure_id, record_id, name, date_performed, outcome',
            vitals: '++vital_id, record_id, blood_pressure, heart_rate, temperature, weight, height',
            labResults: '++lab_result_id, record_id, test_name, result_value, units, reference_range, result_date',
            conditions: '++condition_id, record_id, name, diagnosis_date, status',
            billing: '++bill_id, patient_id, appointment_id, service_id, bill_date, amount, status, due_date',
            applist: '++id, ListType, ListValue, ListOrder, ListCode, ListText, ListActionText, ListDescription, SysOptionOnly, IsDefaultOption, Active, SubListType, DateCreated, CreatedBy, DateModified, ModifiedBy'
        });

        // Add indexes for common queries
        this.db.version(2).stores({
            users: '++user_id, username, email, role',
            patients: '++patient_id, user_id, [first_name+last_name], insurance_provider_id',
            providers: '++provider_id, user_id, specialty',
            appointments: '++appointment_id, patient_id, provider_id, service_id, appointment_date, status, [patient_id+appointment_date]',
             medicalRecords: '++record_id, patient_id, record_type, record_date, provider_id, [patient_id+record_type]'
        });
    }

    async initialize() {
        try {
            await this.db.open();
            console.log('PatientPortalDB initialized successfully');
            
            // Check if users already exist
            const existingUsers = await this.db.users.toArray();
            if (existingUsers.length === 0) {
                // Load basic users data from embedded JSON
                const usersData = {
                    "clients": [
                        {
                            "username": "bwalya.chisanga@client.com",
                            "password": "ubumi",
                            "contact": {"email": "bwalya.chisanga@client.com"}
                        }
                    ],
                    "practitioners": [
                        {
                            "username": "dr.sikatana@medical.com",
                            "password": "ubumi",
                            "contact": {"email": "dr.sikatana@medical.com"}
                        }
                    ]
                    
                };
                
                // Prepare basic user records
                const users = [
                    ...usersData.clients.map(c => ({
                        username: c.username,
                        password: c.password,
                        email: c.contact.email,
                        role: 'client',
                        created_at: new Date().toISOString()
                    })),
                    ...usersData.practitioners.map(p => ({
                        username: p.username,
                        password: p.password,
                        email: p.contact.email,
                        role: 'practitioner',
                        created_at: new Date().toISOString()
                    }))
                ];
                
                // Add unique constraint
                await this.db.users.bulkAdd(users, { allKeys: true });
                console.log('Initialized with default users');
            } else {
                console.log('Using existing users data');
            }
            
            return this;
        } catch (error) {
            console.error('Failed to initialize PatientPortalDB:', error);
            throw error;
        }
    }

    // User management
    async addUser(userData) {
        return this.db.users.add(userData);
    }

    async getUserById(userId) {
        return this.db.users.get(userId);
    }

    // Patient management
    async addPatient(patientData) {
        return this.db.patients.add(patientData);
    }

    async getPatientByUserId(userId) {
        return this.db.patients.where('user_id').equals(userId).first();
    }

    // Appointment management
    async addAppointment(appointmentData) {
        return this.db.appointments.add(appointmentData);
    }

    async getAppointmentsByPatient(patientId, options = {}) {
        let query = this.db.appointments.where('patient_id').equals(patientId);
        
        if (options.startDate && options.endDate) {
            query = query.and(appt => 
                new Date(appt.date) >= new Date(options.startDate) && 
                new Date(appt.date) <= new Date(options.endDate)
            );
        }
        
        if (options.status) {
            query = query.and(appt => appt.status === options.status);
        }

        return query.toArray();
    }

    // Medical records
    async addMedicalRecord(recordData) {
        return this.db.medicalRecords.add(recordData);
    }

    async getPatientMedicalRecords(patientId, recordType) {
        return this.db.medicalRecords
            .where('[patient_id+record_type]')
            .equals([patientId, recordType])
            .toArray();
    }

    // Transaction examples
    async transferPatientRecords(oldProviderId, newProviderId, patientId) {
        return this.db.transaction('rw', this.db.medicalRecords, this.db.appointments, async () => {
            await this.db.medicalRecords
                .where('provider_id')
                .equals(oldProviderId)
                .and(record => record.patient_id === patientId)
                .modify({ provider_id: newProviderId });

            await this.db.appointments
                .where('provider_id')
                .equals(oldProviderId)
                .and(appt => appt.patient_id === patientId)
                .modify({ provider_id: newProviderId });
        });
    }

    // Close database
    close() {
        this.db.close();
    }
}

// Immediately initialize and expose PatientPortalDB
(function() {
    const dbService = new PatientPortalDB();
    
    // Initialize and expose via window
    dbService.initialize().then(() => {
        window.PatientPortalDB = dbService;
    }).catch(error => {
        console.error('Failed to initialize PatientPortalDB:', error);
    });

    // Also expose constructor for debugging
    window.PatientPortalDBConstructor = PatientPortalDB;
})();
