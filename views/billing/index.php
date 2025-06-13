<?php
require_once 'views/includes/header.php';
require_once 'mock/MockDataService.php';

$mockDataService = new MockDataService();
$data['user'] = $mockDataService->getCurrentUser();
$data['recent_bills'] = $mockDataService->getRecentBills();

// Calculate totals
$totalPayment = 0;
$totalMedicare = 0;
foreach($data['recent_bills'] as $bill) {
    if($bill['provider'] !== 'Medicare') {
        $totalPayment += $bill['amount'];
    } else {
        $totalMedicare += $bill['amount'];
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once 'views/includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Billing & Payments</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-primary me-2">
                        <i class="bi bi-credit-card"></i> Make a Payment
                    </button>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Download Statement</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-primary h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Total Outstanding</h6>
                            <h2 class="card-title text-primary">$<?php echo number_format($totalPayment, 2); ?></h2>
                            <p class="card-text">Due within 30 days</p>
                            <button class="btn btn-primary btn-sm">Pay Now</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Medicare Benefits</h6>
                            <h2 class="card-title text-success">$<?php echo number_format($totalMedicare, 2); ?></h2>
                            <p class="card-text">Total benefits received</p>
                            <button class="btn btn-outline-success btn-sm">View Details</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info h-100">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Insurance Claims</h6>
                            <h2 class="card-title text-info">2</h2>
                            <p class="card-text">Pending claims</p>
                            <button class="btn btn-outline-info btn-sm">Track Claims</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bills -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Bills</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($data['recent_bills'])) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Bill Date</th>
                                        <th>Provider</th>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['recent_bills'] as $bill) : ?>
                                        <tr>
                                            <td><?php echo date('M d, Y', strtotime($bill['date'])); ?></td>
                                            <td><?php echo htmlspecialchars($bill['provider']); ?></td>
                                            <td>Medical Consultation</td>
                                            <td>$<?php echo number_format($bill['amount'], 2); ?></td>
                                            <td>
                                                <span class="badge bg-<?php 
                                                    echo $bill['status'] === 'paid' ? 'success' : 
                                                        ($bill['status'] === 'pending' ? 'warning' : 'info'); 
                                                    ?>">
                                                    <?php echo ucfirst($bill['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <?php if($bill['status'] === 'pending') : ?>
                                                        <button class="btn btn-sm btn-primary">Pay</button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <p>No recent bills found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payment Methods</h5>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus"></i> Add New
                    </button>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-credit-card me-2"></i>
                                    <strong>Visa ending in 4242</strong>
                                    <small class="text-muted ms-2">Expires 12/25</small>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-bank me-2"></i>
                                    <strong>Bank Account ending in 9999</strong>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Insurance Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Insurance Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Primary Insurance</h6>
                            <p class="mb-1"><strong>Provider:</strong> Medicare</p>
                            <p class="mb-1"><strong>Policy Number:</strong> MED123456789</p>
                            <p class="mb-1"><strong>Group Number:</strong> GRP987654</p>
                            <p class="mb-3"><strong>Coverage:</strong> Active</p>
                            <button class="btn btn-sm btn-outline-primary">Update Info</button>
                        </div>
                        <div class="col-md-6">
                            <h6>Secondary Insurance</h6>
                            <p class="mb-1"><strong>Provider:</strong> Private Health Plus</p>
                            <p class="mb-1"><strong>Policy Number:</strong> PHP987654321</p>
                            <p class="mb-1"><strong>Group Number:</strong> GRP123456</p>
                            <p class="mb-3"><strong>Coverage:</strong> Active</p>
                            <button class="btn btn-sm btn-outline-primary">Update Info</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>