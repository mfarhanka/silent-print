<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../account/');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';

authRequireUser($currentUser ?? null, $basePath);

include dirname(__DIR__) . '/includes/header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">My Account</span>
                    <h1 class="fw-bold mb-2">Welcome, <?= htmlspecialchars($currentUser['first_name'] ?? 'Customer') ?>.</h1>
                    <p class="text-muted mb-0">Your account is active and ready for quote tracking, saved preferences, and future order management.</p>
                </div>
                <a href="<?= $basePath ?>/logout/" class="btn btn-outline-primary rounded-pill px-4">Log Out</a>
            </div>

            <div class="account-grid">
                <div class="content-card shadow-none border-0 bg-light">
                    <h5 class="fw-bold mb-3">Account summary</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="account-stat">
                                <div class="small text-muted mb-1">Full name</div>
                                <div class="fw-semibold"><?= htmlspecialchars(authFullName($currentUser)) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat">
                                <div class="small text-muted mb-1">Email address</div>
                                <div class="fw-semibold"><?= htmlspecialchars($currentUser['email'] ?? '') ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat">
                                <div class="small text-muted mb-1">Member since</div>
                                <div class="fw-semibold"><?= htmlspecialchars(date('d M Y', strtotime($currentUser['created_at'] ?? 'now'))) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat">
                                <div class="small text-muted mb-1">Next action</div>
                                <div class="fw-semibold">Request a quote or customize a product</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-card shadow-none border-0 bg-light">
                    <h5 class="fw-bold mb-3">Quick actions</h5>
                    <div class="d-grid gap-3">
                        <a href="<?= $basePath ?>/products/" class="btn btn-primary rounded-pill">Browse Products</a>
                        <a href="<?= $basePath ?>/quote/" class="btn btn-outline-primary rounded-pill">Request Quote</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>