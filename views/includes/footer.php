<footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>National Centralised Patient Portal</h5>
                    <p class="text-muted">Providing unified access to your health information across all healthcare providers.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo APP_URL; ?>/about">About</a></li>
                        <li><a href="<?php echo APP_URL; ?>/privacy">Privacy Policy</a></li>
                        <li><a href="<?php echo APP_URL; ?>/terms">Terms of Service</a></li>
                        <li><a href="<?php echo APP_URL; ?>/contact">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo APP_URL; ?>/help">Help Center</a></li>
                        <li><a href="<?php echo APP_URL; ?>/faq">FAQ</a></li>
                        <li><a href="<?php echo APP_URL; ?>/feedback">Feedback</a></li>
                        <li><a href="<?php echo APP_URL; ?>/accessibility">Accessibility</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">&copy; <?php echo date('Y'); ?> National Health Service. All rights reserved.</p>
                <div>
                    <a href="#" class="text-muted me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-muted me-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-muted me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="<?php echo APP_URL; ?>/public/js/main.js"></script>

    <!-- Page-specific scripts -->
    <?php if(isset($data['scripts'])) : ?>
        <?php foreach($data['scripts'] as $script) : ?>
            <script src="<?php echo APP_URL; ?>/public/js/<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Vue.js Components -->
    <script>
        // Initialize Vue components if needed
        <?php if(isset($data['vue_components'])) : ?>
        new Vue({
            el: '#app',
            data: {
                // Data properties will be set here
            },
            methods: {
                // Methods will be defined here
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>