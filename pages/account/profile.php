<?php
require_once dirname(__DIR__, 2) . '/includes/account-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/account-data.php';

$connection = accountDbConnection();
$summary = accountConsoleSummary($connection, $currentUser ?? []);

$pageTitle = 'My Profile | SilentPrint';
$accountPage = 'profile';

include dirname(__DIR__, 2) . '/includes/account-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="account-summary-grid">
            <div class="content-card shadow-none border-0 bg-light">
                <span class="content-meta mb-3">Profile</span>
                <h1 class="fw-bold mb-3">Client identity</h1>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">First name</div>
                            <div class="fw-semibold"><?= htmlspecialchars($currentUser['first_name'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">Last name</div>
                            <div class="fw-semibold"><?= htmlspecialchars($currentUser['last_name'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">Email</div>
                            <div class="fw-semibold"><?= htmlspecialchars($currentUser['email'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">Member since</div>
                            <div class="fw-semibold"><?= htmlspecialchars($summary['memberSince']) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card shadow-none border-0 bg-light">
                <span class="content-meta mb-3">Console Status</span>
                <h5 class="fw-bold mb-3">Readiness</h5>
                <div class="d-grid gap-3">
                    <div class="account-panel-stat">
                        <div class="fw-semibold mb-1">Quote history</div>
                        <div class="small text-muted"><?= $summary['quoteTableExists'] ? 'Connected to the quotes table for request tracking.' : 'Waiting for quote storage in this environment.' ?></div>
                    </div>
                    <div class="account-panel-stat">
                        <div class="fw-semibold mb-1">Next recommended action</div>
                        <div class="small text-muted">Use the public quote page for new requests, then return here to monitor progress once workflow updates are connected.</div>
                    </div>
                    <?php if (authIsAdmin($currentUser)): ?>
                        <div class="account-panel-stat">
                            <div class="fw-semibold mb-1">Admin access</div>
                            <div class="small text-muted">This account can also open the admin console for operational oversight.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/account-footer.php'; ?>