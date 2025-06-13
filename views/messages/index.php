<?php
require_once 'views/includes/header.php';
require_once 'mock/MockDataService.php';

$mockDataService = new MockDataService();
$data['user'] = $mockDataService->getCurrentUser();
$data['messages'] = $mockDataService->getMessages();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php require_once 'views/includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Messages</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-primary me-2">
                        <i class="bi bi-pencil-square"></i> Compose
                    </button>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Mark all as read</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Archive</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <?php if(!empty($data['messages'])) : ?>
                        <div class="list-group list-group-flush">
                            <?php foreach($data['messages'] as $message) : ?>
                                <a href="#" class="list-group-item list-group-item-action py-3 <?php echo !$message['read'] ? 'bg-light' : ''; ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo htmlspecialchars($message['sender_image']); ?>" 
                                                 class="rounded-circle me-3" 
                                                 alt="<?php echo htmlspecialchars($message['sender_name']); ?>">
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mb-0 <?php echo !$message['read'] ? 'fw-bold' : ''; ?>">
                                                        <?php echo htmlspecialchars($message['sender_name']); ?>
                                                    </h6>
                                                    <?php if(!$message['read']) : ?>
                                                        <span class="badge bg-primary ms-2">New</span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="mb-0 <?php echo !$message['read'] ? 'fw-bold' : ''; ?>">
                                                    <?php echo htmlspecialchars($message['subject']); ?>
                                                </p>
                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars($message['snippet']); ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block">
                                                <?php echo date('M d', strtotime($message['date'])); ?>
                                            </small>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-link text-muted" title="Archive">
                                                    <i class="bi bi-archive"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-link text-muted" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-5">
                            <i class="bi bi-envelope text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3">No messages in your inbox</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>