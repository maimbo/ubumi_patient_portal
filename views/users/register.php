<?php require_once 'views/includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3">Create Your Patient Portal Account</h2>
                        <p class="text-muted">Join the National Centralised Patient Portal to access your health information</p>
                    </div>

                    <?php if(isset($data['error'])) : ?>
                        <div class="alert alert-danger">
                            <?php echo $data['error']; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo APP_URL; ?>/users/register" method="post" id="registrationForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="" selected disabled>Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer_not_to_say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <div class="form-text">We'll never share your email with anyone else.</div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>

                        <div class="mb-3">
                            <label for="medicare_number" class="form-label">Medicare Number (optional)</label>
                            <input type="text" class="form-control" id="medicare_number" name="medicare_number" placeholder="Enter your Medicare number">
                            <div class="form-text">Providing your Medicare number helps us link your existing health records.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                                <div class="form-text">Password must be at least 8 characters long and include a number and special character.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Security Questions</label>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="security_question_1" class="form-label">Question 1</label>
                                        <select class="form-select" id="security_question_1" name="security_question_1" required>
                                            <option value="" selected disabled>Select a security question</option>
                                            <option value="mother_maiden_name">What is your mother's maiden name?</option>
                                            <option value="first_pet">What was the name of your first pet?</option>
                                            <option value="childhood_street">What street did you grow up on?</option>
                                            <option value="high_school">What high school did you attend?</option>
                                        </select>
                                    </div>
                                    <div class="mb-0">
                                        <label for="security_answer_1" class="form-label">Answer</label>
                                        <input type="text" class="form-control" id="security_answer_1" name="security_answer_1" placeholder="Your answer" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="<?php echo APP_URL; ?>/terms" target="_blank">Terms of Service</a> and <a href="<?php echo APP_URL; ?>/privacy" target="_blank">Privacy Policy</a></label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p>Already have an account? <a href="<?php echo APP_URL; ?>/users/login">Login</a></p>
                    </div>
                </div>
            </div>

            <div class="card mt-4 mb-5">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle text-primary me-3" style="font-size: 2rem;"></i>
                        <div>
                            <h5 class="mb-1">Need help registering?</h5>
                            <p class="mb-0 text-muted">Call our support team at 1-800-HEALTH or visit your local healthcare provider for assistance with registration.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/includes/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registrationForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

        form.addEventListener('submit', function(event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault();
                alert('Passwords do not match!');
            }

            // Password strength validation
            const passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
            if (!passwordRegex.test(password.value)) {
                event.preventDefault();
                alert('Password must be at least 8 characters long and include a number and special character.');
            }
        });
    });
</script>