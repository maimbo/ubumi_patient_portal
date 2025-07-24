document.addEventListener('DOMContentLoaded', function() {
    const practitionerNameElement = document.getElementById('practitionerName');
    const totalPatientsStat = document.getElementById('totalPatientsStat');
    const upcomingAppointmentsStat = document.getElementById('upcomingAppointmentsStat');
    const newPatientsMonthStat = document.getElementById('newPatientsMonthStat');
    const upcomingAppointmentsTableBody = document.getElementById('upcomingAppointmentsTableBody');
    const recentActivitiesList = document.getElementById('recentActivitiesList');
    const logoutButton = document.getElementById('logoutButton');

    // Dummy data for demonstration
    const dummyPractitionerName = 'Dr. Jane Doe';
    const dummyStats = {
        totalPatients: 150,
        upcomingAppointments: 5,
        newPatientsThisMonth: 15
    };

    const dummyAppointments = [
        { id: 1, patient: 'Alice Smith', date: '2024-07-20', time: '10:00 AM', type: 'Check-up' },
        { id: 2, patient: 'Bob Johnson', date: '2024-07-20', time: '11:30 AM', type: 'Follow-up' },
        { id: 3, patient: 'Charlie Brown', date: '2024-07-21', time: '02:00 PM', type: 'Consultation' },
        { id: 4, patient: 'Diana Prince', date: '2024-07-21', time: '03:00 PM', type: 'Vaccination' },
        { id: 5, patient: 'Clark Kent', date: '2024-07-22', time: '09:00 AM', type: 'Emergency' }
    ];

    const dummyActivities = [
        { id: 1, description: 'New patient registered: John Doe', time: '2 hours ago' },
        { id: 2, description: 'Appointment confirmed for Jane Smith on 2024-07-20', time: '1 day ago' },
        { id: 3, description: 'Updated medical record for Peter Pan', time: '3 days ago' }
    ];

    if (practitionerNameElement) {
        practitionerNameElement.textContent = dummyPractitionerName;
    }

    if (totalPatientsStat) {
        totalPatientsStat.textContent = dummyStats.totalPatients;
    }
    if (upcomingAppointmentsStat) {
        upcomingAppointmentsStat.textContent = dummyStats.upcomingAppointments;
    }
    if (newPatientsMonthStat) {
        newPatientsMonthStat.textContent = dummyStats.newPatientsThisMonth;
    }

    if (upcomingAppointmentsTableBody) {
        if (dummyAppointments.length === 0) {
            upcomingAppointmentsTableBody.innerHTML = '<tr><td colspan="5">No upcoming appointments.</td></tr>';
        } else {
            upcomingAppointmentsTableBody.innerHTML = dummyAppointments.map(app => `
                <tr>
                    <td>${app.patient}</td>
                    <td>${app.date}</td>
                    <td>${app.time}</td>
                    <td>${app.type}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-1">View</button>
                        <button class="btn btn-sm btn-outline-secondary">Reschedule</button>
                    </td>
                </tr>
            `).join('');
        }
    }

    if (recentActivitiesList) {
        if (dummyActivities.length === 0) {
            recentActivitiesList.innerHTML = '<li class="list-group-item">No recent activities.</li>';
        } else {
            recentActivitiesList.innerHTML = dummyActivities.map(activity => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>${activity.description}</div>
                    <small class="text-muted">${activity.time}</small>
                </li>
            `).join('');
        }
    }

    if (logoutButton) {
        logoutButton.addEventListener('click', (event) => {
            event.preventDefault();
            // In a real application, you would clear session data here
            alert('Logged out successfully!');
            window.location.href = 'login.html'; // Redirect to login page
        });
    }

    // Initialize IndexedDbDataService if needed for future dynamic data
    // const dataService = IndexedDbDataService.getInstance();
    // dataService.open().then(() => {
    //     console.log('IndexedDB opened for practitioner dashboard.');
    // }).catch(error => {
    //     console.error('Error opening IndexedDB:', error);
    // });
});