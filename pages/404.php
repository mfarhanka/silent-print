<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../');
    exit;
}

include dirname(__DIR__) . '/includes/header.php';
?>

<section class="not-found-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="not-found-card text-center text-md-start">
                    <div class="not-found-code mb-3">ERROR 404</div>
                    <h1 class="not-found-title fw-bold mb-3">This page does not exist.</h1>
                    <p class="lead text-muted mb-4">The link may be outdated, the page may have moved, or the address might be incorrect.</p>
                    <div class="not-found-links justify-content-center justify-content-md-start">
                        <a href="<?= $basePath ?>/" class="btn btn-primary rounded-pill px-4">Back to Home</a>
                        <a href="<?= $basePath ?>/products/" class="btn btn-outline-primary rounded-pill px-4">Browse Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>