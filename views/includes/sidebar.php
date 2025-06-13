<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : ''; ?>" aria-current="page" href="/views/dashboard/index.php">
                    <i class="bi bi-house-door"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'appointments') !== false ? 'active' : ''; ?>" href="/views/appointments/index.php">
                    <i class="bi bi-calendar-event"></i>
                    Appointments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'messages') !== false ? 'active' : ''; ?>" href="/views/messages/index.php">
                    <i class="bi bi-chat-dots"></i>
                    Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-person-lines-fill"></i>
                    Contacts
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>MEDICAL</span>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/results') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/results">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Test Results
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/records') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/records">
                    <i class="bi bi-journal-medical me-2"></i>
                    Medical Records
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/medications') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/medications">
                    <i class="bi bi-capsule me-2"></i>
                    Medications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/care-plans') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/care-plans">
                    <i class="bi bi-clipboard2-pulse me-2"></i>
                    Care plans
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/forms') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/forms">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Forms
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>FINANCE</span>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/billing') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/billing">
                    <i class="bi bi-credit-card me-2"></i>
                    Billing
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/history') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/history">
                    <i class="bi bi-clock-history me-2"></i>
                    History
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/reports') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/reports">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>
                    Reports
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>SETTINGS</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/settings') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/settings">
                    <i class="bi bi-gear me-2"></i>
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/help') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/help">
                    <i class="bi bi-question-circle me-2"></i>
                    Help/FAQ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/support') !== false ? 'active' : ''; ?>" href="<?php echo APP_URL; ?>/support">
                    <i class="bi bi-headset me-2"></i>
                    Support
                </a>
            </li>
        </ul>
    </div>
</div>