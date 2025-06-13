<?php 
require_once 'views/includes/header.php'; 
require_once 'mock/MockDataService.php';

$mockDataService = new MockDataService();
$data['user'] = $mockDataService->getCurrentUser();
$data['appointments'] = $mockDataService->getAppointments();
$data['recent_activity'] = $mockDataService->getRecentActivity();
$data['medications'] = $mockDataService->getMedications();
$data['conditions'] = $mockDataService->getConditions();
$data['recent_bills'] = $mockDataService->getRecentBills();
$data['notifications'] = $mockDataService->getNotifications();

?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once 'views/includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                </div>
            </div>

            <!-- COVID-19 Alert -->
                        <!-- COVID-19 Alert -->
            <?php if(!empty($data['notifications'])) : ?>
                <?php foreach($data['notifications'] as $notification) : ?>
                    <?php if($notification['type'] === 'covid_alert') : ?>
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>
                                <strong><?php echo $notification['title']; ?></strong>
                                <p class="mb-0"><?php echo $notification['message']; ?></p>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-info ms-auto">See Details</button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="row">
                <!-- Appointments Section -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Appointments</h5>
                            <div>
                                <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-calendar-plus"></i></button>
                                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($data['appointments'])) : ?>
                                <div class="list-group">
                                    <?php foreach($data['appointments'] as $appointment) : ?>
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">Dr. <?php echo htmlspecialchars($appointment['provider_name']); ?></h6>
                                                <small><?php echo date('d M, Y', strtotime($appointment['date'])); ?></small>
                                            </div>
                                            <p class="mb-1"><?php echo htmlspecialchars($appointment['time']); ?></p>
                                            <small><?php echo htmlspecialchars($appointment['reason']); ?></small>
                                            <div class="mt-2">
                                                <button class="btn btn-sm btn-outline-danger me-1">Cancel Booking</button>
                                                <button class="btn btn-sm btn-outline-secondary">Reschedule</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p>No upcoming appointments.</p>
                                <a href="<?php echo '/appointments/book.php'; ?>" class="btn btn-primary">Book Appointment</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex">
                                    <?php if(!empty($data['recent_activity'])) : ?>
                                        <?php foreach($data['recent_activity'] as $activity) : ?>
                                            <div class="list-group-item">
                                                <div class="d-flex">
                                                    <div class="rounded-circle bg-light p-2 me-3">
                                                        <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Provider">
                                                    </div>
                                                    <div>
                                                        <p class="mb-1"><?php echo htmlspecialchars($activity['provider']) . ' ' . htmlspecialchars($activity['description']); ?><?php if(isset($activity['reference'])) { echo ' for item <span class="badge bg-secondary">' . htmlspecialchars($activity['reference']) . '</span>'; } ?>.</p>
                                                        <small class="text-muted"><?php echo date('d M Y', strtotime($activity['date'])); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p>No recent activity.</p>
                                    <?php endif; ?>
                                </div>
                        </div>
                    </div>
                </div>

                <!-- Medications Section -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Medications</h5>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($data['medications'])) : ?>
                                <div class="list-group">
                                    <?php foreach($data['medications'] as $medication) : ?>
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><?php echo htmlspecialchars($medication['name']); ?> (<?php echo htmlspecialchars($medication['dosage']); ?>)</h6>
                                            </div>
                                            <p class="mb-1"><?php echo htmlspecialchars($medication['instructions']); ?></p>
                                            <small>Last Refill: <?php echo date('d M, Y', strtotime($medication['last_refill'])); ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p>No current medications.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Current Conditions Section -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Current Conditions</h5>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($data['conditions'])) : ?>
                                <?php foreach($data['conditions'] as $condition) : ?>
                                    <div class="mb-3">
                                        <h6><?php echo htmlspecialchars($condition['name']); ?> <span class="badge bg-warning text-dark"><?php echo ucfirst(htmlspecialchars($condition['status'])); ?></span></h6>
                                        <p><?php echo htmlspecialchars($condition['description']); ?></p>
                                        <small>Diagnosed by <?php echo htmlspecialchars($condition['diagnosed_by']); ?> on <?php echo date('d M, Y', strtotime($condition['diagnosed_date'])); ?></small>
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-primary">Schedule Follow-up</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p>No current conditions.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Bills Section -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Bills</h5>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($data['recent_bills'])) : ?>
                                <ul class="list-group">
                                    <?php 
                                    $totalPayment = 0;
                                    $totalMedicare = 0;
                                    foreach($data['recent_bills'] as $bill) : 
                                        if($bill['provider'] !== 'Medicare') {
                                            $totalPayment += $bill['amount'];
                                        } else {
                                            $totalMedicare += $bill['amount'];
                                        }
                                    ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo htmlspecialchars($bill['provider']); ?></strong>
                                                <small class="d-block text-muted">Paid on <?php echo date('d M, Y', strtotime($bill['date'])); ?></small>
                                            </div>
                                            <span class="badge bg-<?php echo $bill['status'] === 'paid' || $bill['status'] === 'processed' ? 'success' : 'warning'; ?> rounded-pill">$<?php echo number_format($bill['amount'], 2); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="mt-3 d-flex justify-content-between fw-bold">
                                    <span>Your Payment</span>
                                    <span>$<?php echo number_format($totalPayment, 2); ?></span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Medicare</span>
                                    <span>$<?php echo number_format($totalMedicare, 2); ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold h5">
                                    <span>Total</span>
                                    <span>$<?php echo number_format($totalPayment + $totalMedicare, 2); ?></span>
                                </div>
                            <?php else : ?>
                                <p>No recent bills.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex">
                                        <div class="rounded-circle bg-light p-2 me-3">
                                            <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Provider">
                                        </div>
                                        <div>
                                            <p class="mb-1">Medicare has sent a benefit of $122.44 for item <span class="badge bg-secondary">3085</span></p>
                                            <small class="text-muted">08 May 2023</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex">
                                        <div class="rounded-circle bg-light p-2 me-3">
                                            <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Provider">
                                        </div>
                                        <div>
                                            <p class="mb-1">Dr. Kaleb has updated the prescription of <span class="badge bg-info">Albuterol</span> from 8mg to 10mg.</p>
                                            <small class="text-muted">07 Apr 2023</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Medications Section -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Medications</h5>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($data['medications'])) : ?>
                                <div class="list-group">
                                    <?php foreach($data['medications'] as $medication) : ?>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-1"><?php echo $medication['name']; ?> (<?php echo $medication['dosage']; ?>)</h6>
                                                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                                            </div>
                                            <p class="mb-1">Take <?php echo $medication['instructions']; ?></p>
                                            <small class="text-muted">Last filled: <?php echo date('d M, Y', strtotime($medication['last_filled'])); ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p>No active medications.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Current Conditions Section -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Current Conditions</h5>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1 badge bg-warning text-dark">Sinusitis</h6>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                                    </div>
                                    <p class="mb-1">Inflammation of the sinuses resulting in the nasal passages becoming inflamed.</p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted">Last seen: 05 Mar, 2023</small>
                                        <button class="btn btn-sm btn-outline-primary">Schedule</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bills Section -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Bills</h5>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-three-dots-vertical"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="mb-0">$110.00</h2>
                                <span class="badge bg-success">Paid</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Date of service</span>
                                <span>27 April 2023</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Medicare</span>
                                <span>$124.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total</span>
                                <span>$234.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0">Dr. Perry Attasee Dorbin</p>
                                    <small class="text-muted">Cardiologist</small>
                                </div>
                                <button class="btn btn-sm btn-outline-primary">View Details</button>
                            </div>
                            <hr>
                            <p class="mb-1">Suite 250/2023 New King James Rd, Maroubra NSW 2067</p>
                            <button class="btn btn-sm btn-outline-secondary w-100 mt-2">Download Full Receipt</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>