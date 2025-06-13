<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] . ' - ' . APP_NAME : APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/style.css">
    
    <!-- Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Data Service -->
    <script src="<?php echo APP_URL; ?>/static/js/data_service.js"></script>
</head>
<body>
    <header class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo APP_URL; ?>">
                <i class="bi bi-heart-pulse-fill text-primary me-2"></i>
                <span>Healer</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <form class="d-flex mx-auto" style="max-width: 400px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" class="form-control bg-light border-start-0" placeholder="Search" aria-label="Search">
                    </div>
                </form>
                
                <?php if(isset($_SESSION['user_id'])) : ?>
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                2
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#">New message from Dr. Smith</a></li>
                            <li><a class="dropdown-item" href="#">Your appointment is confirmed</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">View all notifications</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://via.placeholder.com/30" class="rounded-circle me-2" alt="User">
                            <span id="loggedInUserName"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/users/profile"><i class="bi bi-person me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/users/settings"><i class="bi bi-gear me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/users/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <?php else : ?>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="<?php echo APP_URL; ?>/users/login">Login</a>
                    <a class="nav-link" href="<?php echo APP_URL; ?>/users/register">Register</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userNameElement = document.getElementById('loggedInUserName');
            if (userNameElement && typeof dataService !== 'undefined' && dataService.getCurrentUser) {
                const currentUser = dataService.getCurrentUser();
                if (currentUser && currentUser.username) {
                    userNameElement.textContent = currentUser.username;
                }
            }
        });
    </script>
</body>
</html>