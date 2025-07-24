const practitionerNameElement = document.getElementById('practitionerName');
    const logoutButton = document.getElementById('logoutButton');
    const addAppointmentForm = document.getElementById('addAppointmentForm');
    const viewEditAppointmentForm = document.getElementById('viewEditAppointmentForm');
    const deleteAppointmentBtn = document.getElementById('deleteAppointmentBtn');

    // Dummy data for demonstration
    const dummyPractitionerName = 'Dr. Jane Doe';
    let appointments = [
        { id: '1', title: 'Alice Smith - Check-up', start: '2024-07-20T10:00:00', extendedProps: { patient: 'Alice Smith', type: 'Check-up', notes: 'Annual physical examination.' } },
        { id: '2', title: 'Bob Johnson - Follow-up', start: '2024-07-20T11:30:00', extendedProps: { patient: 'Bob Johnson', type: 'Follow-up', notes: 'Review of recent lab results.' } },
        { id: '3', title: 'Charlie Brown - Consultation', start: '2024-07-21T14:00:00', extendedProps: { patient: 'Charlie Brown', type: 'Consultation', notes: 'Discuss new medication.' } },
        { id: '4', title: 'Diana Prince - Vaccination', start: '2024-07-22T09:00:00', extendedProps: { patient: 'Diana Prince', type: 'Vaccination', notes: 'Flu shot.' } },
        { id: '5', title: 'Clark Kent - Emergency', start: '2024-07-22T16:00:00', extendedProps: { patient: 'Clark Kent', type: 'Emergency', notes: 'Sudden onset of fever.' } },
        { id: '6', title: 'Bruce Wayne - Check-up', start: '2024-07-23T10:30:00', extendedProps: { patient: 'Bruce Wayne', type: 'Check-up', notes: 'Routine check-up.' } }
    ];

    // Display practitioner name
    if (practitionerNameElement) {
        practitionerNameElement.textContent = dummyPractitionerName;
    }

    // Handle logout
    if (logoutButton) {
        logoutButton.addEventListener('click', (e) => {
            e.preventDefault();
            alert('Logged out successfully!');
            window.location.href = 'login.html'; // Redirect to login page
        });
    }

    // Initialize FullCalendar
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: appointments,
        dateClick: function(info) {
            // Open add appointment modal with clicked date
            document.getElementById('appointmentDate').value = info.dateStr;
            document.getElementById('addAppointmentModal').dataset.date = info.dateStr; // Store date for later use
            var addModal = new bootstrap.Modal(document.getElementById('addAppointmentModal'));
            addModal.show();
        },
        eventClick: function(info) {
            // Open view/edit appointment modal with event details
            document.getElementById('editAppointmentId').value = info.event.id;
            document.getElementById('editPatientName').value = info.event.extendedProps.patient;
            document.getElementById('editAppointmentDate').value = info.event.startStr.substring(0, 10);
            document.getElementById('editAppointmentTime').value = info.event.startStr.substring(11, 16);
            document.getElementById('editAppointmentType').value = info.event.extendedProps.type;
            document.getElementById('editAppointmentNotes').value = info.event.extendedProps.notes;
            var editModal = new bootstrap.Modal(document.getElementById('viewEditAppointmentModal'));
            editModal.show();
        }
    });
    calendar.render();

    // Handle Add Appointment Form Submission
    if (addAppointmentForm) {
        addAppointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const patientName = document.getElementById('patientName').value;
            const appointmentDate = document.getElementById('appointmentDate').value;
            const appointmentTime = document.getElementById('appointmentTime').value;
            const appointmentType = document.getElementById('appointmentType').value;
            const appointmentNotes = document.getElementById('appointmentNotes').value;

            const newAppointment = {
                id: String(appointments.length + 1), // Simple ID generation
                title: `${patientName} - ${appointmentType}`,
                start: `${appointmentDate}T${appointmentTime}:00`,
                extendedProps: { patient: patientName, type: appointmentType, notes: appointmentNotes }
            };

            appointments.push(newAppointment);
            calendar.addEvent(newAppointment);
            alert('Appointment added successfully!');
            bootstrap.Modal.getInstance(document.getElementById('addAppointmentModal')).hide();
            addAppointmentForm.reset();
        });
    }

    // Handle View/Edit Appointment Form Submission
    if (viewEditAppointmentForm) {
        viewEditAppointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editAppointmentId').value;
            const patientName = document.getElementById('editPatientName').value;
            const appointmentDate = document.getElementById('editAppointmentDate').value;
            const appointmentTime = document.getElementById('editAppointmentTime').value;
            const appointmentType = document.getElementById('editAppointmentType').value;
            const appointmentNotes = document.getElementById('editAppointmentNotes').value;

            const event = calendar.getEventById(id);
            if (event) {
                event.setProp('title', `${patientName} - ${appointmentType}`);
                event.setStart(`${appointmentDate}T${appointmentTime}:00`);
                event.setExtendedProp('patient', patientName);
                event.setExtendedProp('type', appointmentType);
                event.setExtendedProp('notes', appointmentNotes);
                alert('Appointment updated successfully!');
                bootstrap.Modal.getInstance(document.getElementById('viewEditAppointmentModal')).hide();
            }
        });
    }

    // Handle Delete Appointment
    if (deleteAppointmentBtn) {
        deleteAppointmentBtn.addEventListener('click', function() {
            const id = document.getElementById('editAppointmentId').value;
            if (confirm('Are you sure you want to delete this appointment?')) {
                const event = calendar.getEventById(id);
                if (event) {
                    event.remove();
                    appointments = appointments.filter(app => app.id !== id);
                    alert('Appointment deleted successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('viewEditAppointmentModal')).hide();
                }
            }
        });
    }