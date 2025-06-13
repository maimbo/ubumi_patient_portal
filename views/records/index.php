<?php
require_once 'views/includes/header.php';
require_once 'mock/MockDataService.php';

$mockDataService = new MockDataService();
$data['user'] = $mockDataService->getCurrentUser();
$data['medications'] = $mockDataService->getMedications();
$data['conditions'] = $mockDataService->getConditions();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once 'views/includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Medical Records</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Download</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Current Medications -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Current Medications</h5>
                            <button class="btn btn-sm btn-outline-primary">Request Refill</button>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($data['medications'])) : ?>
                                <div class="list-group">
                                    <?php foreach($data['medications'] as $medication) : ?>
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><?php echo htmlspecialchars($medication['name']); ?> (<?php echo htmlspecialchars($medication['dosage']); ?>)</h6>
                                                <small>Last Refill: <?php echo date('M d, Y', strtotime($medication['last_refill'])); ?></small>
                                            </div>
                                            <p class="mb-1"><?php echo htmlspecialchars($medication['instructions']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p>No current medications.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Medical Conditions -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Medical Conditions</h5>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($data['conditions'])) : ?>
                                <?php foreach($data['conditions'] as $condition) : ?>
                                    <div class="mb-3">
                                        <h6>
                                            <?php echo htmlspecialchars($condition['name']); ?>
                                            <span class="badge bg-<?php echo $condition['status'] === 'active' ? 'warning' : 'success'; ?> text-dark">
                                                <?php echo ucfirst(htmlspecialchars($condition['status'])); ?>
                                            </span>
                                        </h6>
                                        <p class="mb-1"><?php echo htmlspecialchars($condition['description']); ?></p>
                                        <small class="text-muted">
                                            Diagnosed by <?php echo htmlspecialchars($condition['diagnosed_by']); ?> on 
                                            <?php echo date('M d, Y', strtotime($condition['diagnosed_date'])); ?>
                                        </small>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p>No medical conditions recorded.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Lab Results -->
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Lab Results</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Date</th>
                                            <th>Result</th>
                                            <th>Reference Range</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Complete Blood Count (CBC)</td>
                                            <td>Mar 15, 2024</td>
                                            <td>14.2 g/dL</td>
                                            <td>13.5 - 17.5 g/dL</td>
                                            <td><span class="badge bg-success">Normal</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">View Details</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Lipid Panel</td>
                                            <td>Mar 10, 2024</td>
                                            <td>210 mg/dL</td>
                                            <td>< 200 mg/dL</td>
                                            <td><span class="badge bg-warning text-dark">High</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">View Details</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Immunizations -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Immunization History</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">COVID-19 Vaccine</h6>
                                        <small>Mar 01, 2024</small>
                                    </div>
                                    <p class="mb-1">Pfizer-BioNTech - Dose 3 (Booster)</p>
                                    <small class="text-muted">Next dose due: Not required</small>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Influenza Vaccine</h6>
                                        <small>Oct 15, 2023</small>
                                    </div>
                                    <p class="mb-1">Seasonal Flu Shot</p>
                                    <small class="text-muted">Next dose due: Oct 2024</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Allergies -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Allergies</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Penicillin</h6>
                                        <span class="badge bg-danger">Severe</span>
                                    </div>
                                    <p class="mb-1">Causes anaphylactic reaction</p>
                                    <small class="text-muted">Documented on: Jan 15, 2024</small>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Pollen</h6>
                                        <span class="badge bg-warning text-dark">Moderate</span>
                                    </div>
                                    <p class="mb-1">Seasonal allergic rhinitis</p>
                                    <small class="text-muted">Documented on: Feb 20, 2024</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>