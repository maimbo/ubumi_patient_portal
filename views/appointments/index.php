<?php require_once 'views/includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once 'views/includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Appointments</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo APP_URL; ?>/appointments/book" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Book New Appointment
                    </a>
                </div>
            </div>

            <!-- Appointment Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="<?php echo APP_URL; ?>/appointments" method="get" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all" <?php echo (!isset($_GET['status']) || $_GET['status'] == 'all') ? 'selected' : ''; ?>>All Appointments</option>
                                <option value="upcoming" <?php echo (isset($_GET['status']) && $_GET['status'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                                <option value="past" <?php echo (isset($_GET['status']) && $_GET['status'] == 'past') ? 'selected' : ''; ?>>Past</option>
                                <option value="cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="provider" class="form-label">Healthcare Provider</label>
                            <select class="form-select" id="provider" name="provider">
                                <option value="all">All Providers</option>
                                <?php if(isset($data['providers'])) : ?>
                                    <?php foreach($data['providers'] as $provider) : ?>
                                        <option value="<?php echo $provider['id']; ?>" <?php echo (isset($_GET['provider']) && $_GET['provider'] == $provider['id']) ? 'selected' : ''; ?>>
                                            Dr. <?php echo $provider['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>">
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="<?php echo APP_URL; ?>/appointments" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Calendar View Toggle -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link <?php echo (!isset($_GET['view']) || $_GET['view'] != 'calendar') ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/appointments?view=list">List View</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($_GET['view']) && $_GET['view'] == 'calendar') ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/appointments?view=calendar">Calendar View</a>
                </li>
            </ul>

            <?php if(isset($_GET['view']) && $_GET['view'] == 'calendar') : ?>
                <!-- Calendar View -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            <?php else : ?>
                <!-- List View -->
                <?php if(!empty($data['appointments'])) : ?>
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Provider</th>
                                            <th>Location</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data['appointments'] as $appointment) : ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold"><?php echo date('d M Y', strtotime($appointment['date'])); ?></div>
                                                    <div class="text-muted"><?php echo date('h:i A', strtotime($appointment['time'])); ?></div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://via.placeholder.com/30" class="rounded-circle me-2" alt="Provider">
                                                        <div>
                                                            <div class="fw-bold">Dr. <?php echo $appointment['provider_name']; ?></div>
                                                            <div class="text-muted"><?php echo $appointment['specialization']; ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><?php echo $appointment['location_name']; ?></div>
                                                    <div class="text-muted"><?php echo $appointment['location_address']; ?></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        echo ($appointment['type'] == 'In-person') ? 'primary' : 
                                                            (($appointment['type'] == 'Video') ? 'success' : 'info'); 
                                                    ?>">
                                                        <?php echo $appointment['type']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        echo ($appointment['status'] == 'Confirmed') ? 'success' : 
                                                            (($appointment['status'] == 'Pending') ? 'warning' : 
                                                                (($appointment['status'] == 'Cancelled') ? 'danger' : 'secondary')); 
                                                    ?>">
                                                        <?php echo $appointment['status']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?php echo APP_URL; ?>/appointments/view/<?php echo $appointment['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <?php if($appointment['status'] != 'Cancelled' && strtotime($appointment['date']) > time()) : ?>
                                                            <a href="<?php echo APP_URL; ?>/appointments/reschedule/<?php echo $appointment['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                                                <i class="bi bi-calendar"></i>
                                                            </a>
                                                            <a href="<?php echo APP_URL; ?>/appointments/cancel/<?php echo $appointment['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                                                <i class="bi bi-x-circle"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <?php if(isset($data['pagination']) && $data['pagination']['total_pages'] > 1) : ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo ($data['pagination']['current_page'] <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?php echo APP_URL; ?>/appointments?page=<?php echo $data['pagination']['current_page'] - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($i = 1; $i <= $data['pagination']['total_pages']; $i++) : ?>
                                    <li class="page-item <?php echo ($data['pagination']['current_page'] == $i) ? 'active' : ''; ?>">
                                        <a class="page-link" href="<?php echo APP_URL; ?>/appointments?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo ($data['pagination']['current_page'] >= $data['pagination']['total_pages']) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?php echo APP_URL; ?>/appointments?page=<?php echo $data['pagination']['current_page'] + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="card mb-4">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                            <h3 class="mt-3">No Appointments Found</h3>
                            <p class="text-muted">You don't have any appointments matching your search criteria.</p>
                            <a href="<?php echo APP_URL; ?>/appointments/book" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-circle me-1"></i> Book New Appointment
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Appointment Reminders -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Appointment Reminders</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo APP_URL; ?>/appointments/update-reminders" method="post">
                        <div class="mb-3">
                            <label class="form-label">How would you like to receive appointment reminders?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="email" id="reminder_email" name="reminders[]" checked>
                                <label class="form-check-label" for="reminder_email">
                                    Email
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="sms" id="reminder_sms" name="reminders[]" checked>
                                <label class="form-check-label" for="reminder_sms">
                                    SMS
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="push" id="reminder_push" name="reminders[]">
                                <label class="form-check-label" for="reminder_push">
                                    Push Notification
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">When would you like to receive reminders?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1_day" id="reminder_1_day" name="reminder_time[]" checked>
                                <label class="form-check-label" for="reminder_1_day">
                                    1 day before appointment
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="3_hours" id="reminder_3_hours" name="reminder_time[]" checked>
                                <label class="form-check-label" for="reminder_3_hours">
                                    3 hours before appointment
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Preferences</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>

<?php if(isset($_GET['view']) && $_GET['view'] == 'calendar') : ?>
<!-- FullCalendar JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                <?php if(!empty($data['appointments'])) : ?>
                    <?php foreach($data['appointments'] as $appointment) : ?>
                        {
                            title: 'Dr. <?php echo $appointment['provider_name']; ?>',
                            start: '<?php echo $appointment['date']; ?>T<?php echo $appointment['time']; ?>',
                            url: '<?php echo APP_URL; ?>/appointments/view/<?php echo $appointment['id']; ?>',
                            backgroundColor: '<?php 
                                echo ($appointment['status'] == 'Confirmed') ? '#198754' : 
                                    (($appointment['status'] == 'Pending') ? '#ffc107' : 
                                        (($appointment['status'] == 'Cancelled') ? '#dc3545' : '#6c757d')); 
                            ?>',
                            borderColor: '<?php 
                                echo ($appointment['status'] == 'Confirmed') ? '#198754' : 
                                    (($appointment['status'] == 'Pending') ? '#ffc107' : 
                                        (($appointment['status'] == 'Cancelled') ? '#dc3545' : '#6c757d')); 
                            ?>'
                        },
                    <?php endforeach; ?>
                <?php endif; ?>
            ],
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    return false;
                }
            }
        });
        calendar.render();
    });
</script>
<?php endif; ?>