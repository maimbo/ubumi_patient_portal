<?php
require_once 'views/includes/header.php';
require_once 'mock/MockDataService.php';

$mockDataService = new MockDataService();
$data['user'] = $mockDataService->getCurrentUser();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment = [
        'provider_name' => $_POST['provider_name'],
        'date' => $_POST['date'],
        'time' => $_POST['time'],
        'reason' => $_POST['reason'],
        'location' => $_POST['location'],
        'status' => 'upcoming'
    ];
    
    $mockDataService->addAppointment($appointment);
    header('Location: /views/dashboard/index.php');
    exit;
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once 'views/includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Book New Appointment</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo APP_URL; ?>/appointments" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Appointments
                    </a>
                </div>
            </div>

            <?php if(isset($data['error'])) : ?>
                <div class="alert alert-danger">
                    <?php echo $data['error']; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($data['success'])) : ?>
                <div class="alert alert-success">
                    <?php echo $data['success']; ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="<?php echo APP_URL; ?>/appointments/book" method="post" id="appointmentForm">
                                <!-- Step 1: Appointment Type -->
                                <div class="appointment-step" id="step1">
                                    <h4 class="mb-4">Step 1: Select Appointment Type</h4>
                                    
                                    <div class="mb-4">
                                        <label class="form-label">What type of appointment do you need?</label>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="card h-100">
                                                    <div class="card-body text-center p-4">
                                                        <input type="radio" class="btn-check" name="appointment_type" id="type_general" value="general" checked>
                                                        <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center" for="type_general">
                                                            <i class="bi bi-clipboard2-pulse mb-3" style="font-size: 2rem;"></i>
                                                            <span>General Check-up</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card h-100">
                                                    <div class="card-body text-center p-4">
                                                        <input type="radio" class="btn-check" name="appointment_type" id="type_specialist" value="specialist">
                                                        <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center" for="type_specialist">
                                                            <i class="bi bi-person-badge mb-3" style="font-size: 2rem;"></i>
                                                            <span>Specialist Consultation</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card h-100">
                                                    <div class="card-body text-center p-4">
                                                        <input type="radio" class="btn-check" name="appointment_type" id="type_followup" value="followup">
                                                        <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center" for="type_followup">
                                                            <i class="bi bi-arrow-repeat mb-3" style="font-size: 2rem;"></i>
                                                            <span>Follow-up Visit</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">How would you like to meet?</label>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-body text-center p-4">
                                                        <input type="radio" class="btn-check" name="visit_type" id="visit_inperson" value="inperson" checked>
                                                        <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center" for="visit_inperson">
                                                            <i class="bi bi-hospital mb-3" style="font-size: 2rem;"></i>
                                                            <span>In-person Visit</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-body text-center p-4">
                                                        <input type="radio" class="btn-check" name="visit_type" id="visit_video" value="video">
                                                        <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center" for="visit_video">
                                                            <i class="bi bi-camera-video mb-3" style="font-size: 2rem;"></i>
                                                            <span>Video Consultation</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="reason" class="form-label">Reason for Visit</label>
                                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Please describe your symptoms or reason for the appointment" required></textarea>
                                        <div class="form-text">This information helps your healthcare provider prepare for your visit.</div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" onclick="nextStep(1, 2)">Next: Select Provider</button>
                                    </div>
                                </div>

                                <!-- Step 2: Provider Selection -->
                                <div class="appointment-step" id="step2" style="display: none;">
                                    <h4 class="mb-4">Step 2: Select Healthcare Provider</h4>

                                    <div class="mb-4">
                                        <label for="specialty" class="form-label">Specialty</label>
                                        <select class="form-select" id="specialty" name="specialty">
                                            <option value="" selected disabled>Select a specialty</option>
                                            <option value="general_practice">General Practice</option>
                                            <option value="cardiology">Cardiology</option>
                                            <option value="dermatology">Dermatology</option>
                                            <option value="endocrinology">Endocrinology</option>
                                            <option value="gastroenterology">Gastroenterology</option>
                                            <option value="neurology">Neurology</option>
                                            <option value="obstetrics_gynecology">Obstetrics & Gynecology</option>
                                            <option value="ophthalmology">Ophthalmology</option>
                                            <option value="orthopedics">Orthopedics</option>
                                            <option value="pediatrics">Pediatrics</option>
                                            <option value="psychiatry">Psychiatry</option>
                                            <option value="urology">Urology</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Select a Provider</label>
                                        <div class="row g-3" id="providerList">
                                            <!-- Provider cards will be dynamically loaded here -->
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="provider_id" id="provider1" value="1" checked>
                                                            <label class="form-check-label w-100" for="provider1">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Provider">
                                                                    <div>
                                                                        <h6 class="mb-0">Dr. Samuel Entrelikis</h6>
                                                                        <span class="text-muted">General Practice</span>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-2">
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star-half text-warning"></i>
                                                                        </div>
                                                                        <span>4.5 (120 reviews)</span>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-0 small">10+ years experience, specializes in preventive care and chronic disease management.</p>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-body p-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="provider_id" id="provider2" value="2">
                                                            <label class="form-check-label w-100" for="provider2">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Provider">
                                                                    <div>
                                                                        <h6 class="mb-0">Dr. Bennet Omidyar</h6>
                                                                        <span class="text-muted">General Practice</span>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-2">
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                            <i class="bi bi-star text-warning"></i>
                                                                        </div>
                                                                        <span>4.0 (98 reviews)</span>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-0 small">8 years experience, focuses on family medicine and pediatric care.</p>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4" id="locationSection">
                                        <label for="location" class="form-label">Select Location</label>
                                        <select class="form-select" id="location" name="location_id">
                                            <option value="" selected disabled>Select a location</option>
                                            <option value="1">Main Street Medical Center - 123 Main St, Sydney</option>
                                            <option value="2">Westfield Health Clinic - 456 Park Ave, Sydney</option>
                                            <option value="3">Eastside Medical Group - 789 Harbor Blvd, Sydney</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep(2, 1)">Previous: Appointment Type</button>
                                        <button type="button" class="btn btn-primary" onclick="nextStep(2, 3)">Next: Select Date & Time</button>
                                    </div>
                                </div>

                                <!-- Step 3: Date & Time Selection -->
                                <div class="appointment-step" id="step3" style="display: none;">
                                    <h4 class="mb-4">Step 3: Select Date & Time</h4>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="appointment_date" class="form-label">Select Date</label>
                                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Available Time Slots</label>
                                        <div class="row g-2" id="timeSlots">
                                            <!-- Time slots will be dynamically loaded here -->
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time1" value="09:00:00" checked>
                                                <label class="btn btn-outline-primary w-100" for="time1">9:00 AM</label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time2" value="09:30:00">
                                                <label class="btn btn-outline-primary w-100" for="time2">9:30 AM</label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time3" value="10:00:00">
                                                <label class="btn btn-outline-primary w-100" for="time3">10:00 AM</label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time4" value="10:30:00">
                                                <label class="btn btn-outline-primary w-100" for="time4">10:30 AM</label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time5" value="11:00:00">
                                                <label class="btn btn-outline-primary w-100" for="time5">11:00 AM</label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time6" value="11:30:00">
                                                <label class="btn btn-outline-primary w-100" for="time6">11:30 AM</label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time7" value="13:00:00">
                                                <label class="btn btn-outline-primary w-100" for="time7">1:00 PM</label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" class="btn-check" name="appointment_time" id="time8" value="13:30:00">
                                                <label class="btn btn-outline-primary w-100" for="time8">1:30 PM</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep(3, 2)">Previous: Select Provider</button>
                                        <button type="button" class="btn btn-primary" onclick="nextStep(3, 4)">Next: Review & Confirm</button>
                                    </div>
                                </div>

                                <!-- Step 4: Review & Confirm -->
                                <div class="appointment-step" id="step4" style="display: none;">
                                    <h4 class="mb-4">Step 4: Review & Confirm</h4>

                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Appointment Summary</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-4 fw-bold">Appointment Type:</div>
                                                <div class="col-md-8" id="summary_type">General Check-up</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 fw-bold">Visit Type:</div>
                                                <div class="col-md-8" id="summary_visit_type">In-person Visit</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 fw-bold">Provider:</div>
                                                <div class="col-md-8" id="summary_provider">Dr. Samuel Entrelikis</div>
                                            </div>
                                            <div class="row mb-3" id="summary_location_row">
                                                <div class="col-md-4 fw-bold">Location:</div>
                                                <div class="col-md-8" id="summary_location">Main Street Medical Center - 123 Main St, Sydney</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 fw-bold">Date & Time:</div>
                                                <div class="col-md-8" id="summary_datetime">Not selected</div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4 fw-bold">Reason for Visit:</div>
                                                <div class="col-md-8" id="summary_reason"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms_agree" name="terms_agree" required>
                                            <label class="form-check-label" for="terms_agree">
                                                I understand that I may be charged a fee for missed appointments without 24-hour notice.
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="prevStep(4, 3)">Previous: Select Date & Time</button>
                                        <button type="submit" class="btn btn-success">Confirm Appointment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Booking Progress</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center" id="progress_step1">
                                    <span><i class="bi bi-1-circle-fill me-2 text-primary"></i> Appointment Type</span>
                                    <span class="badge bg-primary rounded-pill">Current</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center" id="progress_step2">
                                    <span><i class="bi bi-2-circle me-2"></i> Select Provider</span>
                                    <span class="badge bg-secondary rounded-pill">Pending</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center" id="progress_step3">
                                    <span><i class="bi bi-3-circle me-2"></i> Select Date & Time</span>
                                    <span class="badge bg-secondary rounded-pill">Pending</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center" id="progress_step4">
                                    <span><i class="bi bi-4-circle me-2"></i> Review & Confirm</span>
                                    <span class="badge bg-secondary rounded-pill">Pending</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Need Help?</h5>
                        </div>
                        <div class="card-body">
                            <p>If you need assistance with booking your appointment, please contact our support team:</p>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-telephone me-2"></i> 1-800-HEALTH</li>
                                <li class="mb-2"><i class="bi bi-envelope me-2"></i> support@healthportal.gov</li>
                                <li><i class="bi bi-chat-dots me-2"></i> <a href="#">Live Chat</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>

<script>
    // Function to navigate between steps
    function nextStep(currentStep, nextStep) {
        // Validate current step
        if (currentStep === 1) {
            const reason = document.getElementById('reason').value;
            if (!reason) {
                alert('Please enter a reason for your visit.');
                return;
            }
        } else if (currentStep === 2) {
            const specialty = document.getElementById('specialty').value;
            const provider = document.querySelector('input[name="provider_id"]:checked');
            const location = document.getElementById('location').value;
            const visitType = document.querySelector('input[name="visit_type"]:checked').value;
            
            if (!specialty) {
                alert('Please select a specialty.');
                return;
            }
            if (!provider) {
                alert('Please select a provider.');
                return;
            }
            if (visitType === 'inperson' && !location) {
                alert('Please select a location.');
                return;
            }
        } else if (currentStep === 3) {
            const date = document.getElementById('appointment_date').value;
            const time = document.querySelector('input[name="appointment_time"]:checked');
            
            if (!date) {
                alert('Please select a date.');
                return;
            }
            if (!time) {
                alert('Please select a time slot.');
                return;
            }
            
            // Update summary
            updateSummary();
        }
        
        // Hide current step and show next step
        document.getElementById(`step${currentStep}`).style.display = 'none';
        document.getElementById(`step${nextStep}`).style.display = 'block';
        
        // Update progress indicators
        document.getElementById(`progress_step${currentStep}`).innerHTML = 
            `<span><i class="bi bi-${currentStep}-circle-fill me-2 text-success"></i> ${getStepName(currentStep)}</span>
            <span class="badge bg-success rounded-pill">Completed</span>`;
            
        document.getElementById(`progress_step${nextStep}`).innerHTML = 
            `<span><i class="bi bi-${nextStep}-circle-fill me-2 text-primary"></i> ${getStepName(nextStep)}</span>
            <span class="badge bg-primary rounded-pill">Current</span>`;
    }
    
    function prevStep(currentStep, prevStep) {
        // Hide current step and show previous step
        document.getElementById(`step${currentStep}`).style.display = 'none';
        document.getElementById(`step${prevStep}`).style.display = 'block';
        
        // Update progress indicators
        document.getElementById(`progress_step${currentStep}`).innerHTML = 
            `<span><i class="bi bi-${currentStep}-circle me-2"></i> ${getStepName(currentStep)}</span>
            <span class="badge bg-secondary rounded-pill">Pending</span>`;
            
        document.getElementById(`progress_step${prevStep}`).innerHTML = 
            `<span><i class="bi bi-${prevStep}-circle-fill me-2 text-primary"></i> ${getStepName(prevStep)}</span>
            <span class="badge bg-primary rounded-pill">Current</span>`;
    }
    
    function getStepName(step) {
        switch(step) {
            case 1: return 'Appointment Type';
            case 2: return 'Select Provider';
            case 3: return 'Select Date & Time';
            case 4: return 'Review & Confirm';
            default: return '';
        }
    }
    
    // Function to update the summary
    function updateSummary() {
        // Get selected values
        const appointmentType = document.querySelector('input[name="appointment_type"]:checked').value;
        const visitType = document.querySelector('input[name="visit_type"]:checked').value;
        const providerId = document.querySelector('input[name="provider_id"]:checked').value;
        const providerName = document.querySelector(`label[for="provider${providerId}"] h6`).textContent;
        const date = document.getElementById('appointment_date').value;
        const timeId = document.querySelector('input[name="appointment_time"]:checked').id;
        const timeText = document.querySelector(`label[for="${timeId}"]`).textContent;
        const reason = document.getElementById('reason').value;
        
        // Format date
        const formattedDate = new Date(date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        // Update summary fields
        document.getElementById('summary_type').textContent = getAppointmentTypeText(appointmentType);
        document.getElementById('summary_visit_type').textContent = visitType === 'inperson' ? 'In-person Visit' : 'Video Consultation';
        document.getElementById('summary_provider').textContent = providerName;
        document.getElementById('summary_datetime').textContent = `${formattedDate} at ${timeText}`;
        document.getElementById('summary_reason').textContent = reason;
        
        // Handle location based on visit type
        if (visitType === 'inperson') {
            const locationId = document.getElementById('location').value;
            const locationText = document.getElementById('location').options[document.getElementById('location').selectedIndex].text;
            document.getElementById('summary_location').textContent = locationText;
            document.getElementById('summary_location_row').style.display = '';
        } else {
            document.getElementById('summary_location_row').style.display = 'none';
        }
    }
    
    function getAppointmentTypeText(type) {
        switch(type) {
            case 'general': return 'General Check-up';
            case 'specialist': return 'Specialist Consultation';
            case 'followup': return 'Follow-up Visit';
            default: return type;
        }
    }
    
    // Event listener for visit type change
    document.addEventListener('DOMContentLoaded', function() {
        const visitTypeRadios = document.querySelectorAll('input[name="visit_type"]');
        visitTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const locationSection = document.getElementById('locationSection');
                if (this.value === 'inperson') {
                    locationSection.style.display = 'block';
                } else {
                    locationSection.style.display = 'none';
                }
            });
        });
        
        // Set min date for appointment date picker to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('appointment_date').min = today;
    });
</script>