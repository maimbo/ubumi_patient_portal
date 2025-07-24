// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', async function() {
    try {
        // Initialize database connection
        const db = await window.PatientPortalDB.initialize();
        
        // Get logged in user
        const username = localStorage.getItem('loggedInUser');
        if (!username) {
            window.location.href = 'login.html';
            return;
        }

        // Load user data
        const user = await db.users.where('username').equals(username).first();
        if (!user) {
            window.location.href = 'login.html';
            return;
        }

        // Set user name in header
        document.getElementById('loggedInUserName').textContent = user.username;

        // Route user based on role
        switch(user.role) {
            case 'patient':
                await loadPatientData(db, user);
                break;
            case 'provider':
                window.location.href = 'provider_dashboard.html';
                break;
            case 'practitioner':
                window.location.href = 'practitioner_dashboard.html';
                break;
            default:
                console.error('Unknown user role:', user.role);
                window.location.href = 'login.html';
        }

        // Set up logout link
        document.getElementById('logoutLink').addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('loggedInUser');
            window.location.href = 'login.html';
        });

    } catch (error) {
        console.error('Dashboard initialization failed:', error);
    }
});

// Load patient-specific data
async function loadPatientData(db, user) {
    try {
        // Get patient record
        const patient = await db.patients.where('user_id').equals(user.user_id).first();
        
        // Load upcoming appointments
        const today = new Date().toISOString().split('T')[0];
        const appointments = await db.appointments
            .where('patient_id').equals(patient.patient_id)
            .and(appt => appt.appointment_date >= today)
            .sortBy('appointment_date');
        
        // Display appointments
        const appointmentsContainer = document.querySelector('#upcomingAppointments');
        if (appointments.length > 0) {
            appointmentsContainer.innerHTML = appointments.map(appt => `
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <h6>${appt.provider_name || 'Appointment'}</h6>
                        <small>${new Date(appt.appointment_date).toLocaleDateString()}</small>
                    </div>
                    <p>${appt.appointment_time} - ${appt.status}</p>
                </div>
            `).join('');
        } else {
            appointmentsContainer.innerHTML = '<p>No upcoming appointments</p>';
        }

        // Load medications
        const medications = await db.medications
            .where('patient_id').equals(patient.patient_id)
            .toArray();
        
        // Display medications
        const medsContainer = document.querySelector('#currentMedications');
        if (medications.length > 0) {
            medsContainer.innerHTML = medications.map(med => `
                <div class="list-group-item">
                    <h6>${med.name}</h6>
                    <p>${med.dosage} - ${med.frequency}</p>
                </div>
            `).join('');
        } else {
            medsContainer.innerHTML = '<p>No current medications</p>';
        }

    } catch (error) {
        console.error('Failed to load patient data:', error);
    }
}
