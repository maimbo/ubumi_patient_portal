document.addEventListener('DOMContentLoaded', async () => {
    const loggedInProviderName = document.getElementById('loggedInProviderName');
    const logoutLink = document.getElementById('logoutLink');
    const upcomingAppointmentsDiv = document.getElementById('upcomingAppointments');
    const patientStatsDiv = document.getElementById('patientStats');

    // Initialize IndexedDbDataService
    const dbService = IndexedDbDataService.getInstance();
    await dbService.open();

    // Dummy data for demonstration
    const dummyAppointments = [
        { id: 1, patientName: 'Alice Smith', time: '10:00 AM', date: '2024-07-20', type: 'Consultation' },
        { id: 2, patientName: 'Bob Johnson', time: '11:30 AM', date: '2024-07-20', type: 'Follow-up' },
        { id: 3, patientName: 'Charlie Brown', time: '02:00 PM', date: '2024-07-21', type: 'Check-up' }
    ];

    const dummyPatientStats = {
        totalPatients: 150,
        newPatientsToday: 5,
        activePatients: 120,
        appointmentsToday: 10
    };

    // Function to display upcoming appointments
    function displayUpcomingAppointments(appointments) {
        if (appointments.length === 0) {
            upcomingAppointmentsDiv.innerHTML = '<p>No upcoming appointments.</p>';
            return;
        }
        let html = '<ul class="list-group list-group-flush">';
        appointments.forEach(app => {
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${app.patientName}</strong>
                        <br><small class="text-muted">${app.date} at ${app.time} - ${app.type}</small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary">View</button>
                </li>
            `;
        });
        html += '</ul>';
        upcomingAppointmentsDiv.innerHTML = html;
    }

    // Function to display patient statistics
    function displayPatientStatistics(stats) {
        patientStatsDiv.innerHTML = `
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Patients
                    <span class="badge bg-primary rounded-pill">${stats.totalPatients}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    New Patients Today
                    <span class="badge bg-success rounded-pill">${stats.newPatientsToday}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Active Patients
                    <span class="badge bg-info rounded-pill">${stats.activePatients}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Appointments Today
                    <span class="badge bg-warning rounded-pill">${stats.appointmentsToday}</span>
                </li>
            </ul>
        `;
    }

    // Populate data
    displayUpcomingAppointments(dummyAppointments);
    displayPatientStatistics(dummyPatientStats);

    // Handle logout
    logoutLink.addEventListener('click', (e) => {
        e.preventDefault();
        // Clear any session data if necessary
        localStorage.removeItem('loggedInUser'); // Example: clear user from local storage
        window.location.href = 'login.html'; // Redirect to login page
    });

    // Display logged-in provider name (dummy for now)
    loggedInProviderName.textContent = 'Dr. Jane Doe';
});