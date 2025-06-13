<?php require_once 'views/includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-heart-pulse-fill text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3">Welcome to the National Centralised Patient Portal</h2>
                        <p class="text-muted">Please login to access your health information</p>
                    </div>

                    <?php if(isset($data['error'])) : ?>
                        <div class="alert alert-danger">
                            <?php echo $data['error']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo APP_URL; ?>/users/login" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p><a href="<?php echo APP_URL; ?>/users/forgot-password">Forgot your password?</a></p>
                        <p>Don't have an account? <a href="<?php echo APP_URL; ?>/users/register">Register</a></p>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-3">Or login with your healthcare provider</p>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-hospital me-2"></i> Medicare
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-hospital me-2"></i> MyHealth
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-lock text-primary me-3" style="font-size: 2rem;"></i>
                        <div>
                            <h5 class="mb-1">Your privacy is important to us</h5>
                            <p class="mb-0 text-muted">We use industry-standard encryption and security measures to protect your health information.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>