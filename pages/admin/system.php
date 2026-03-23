<?php
require_once dirname(__DIR__, 2) . '/includes/admin-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-data.php';

$databaseConfig = adminDatabaseConfig();
$adminEmails = authAdminEmails();
$adminPolicy = adminPolicySummary();
$authMode = adminAuthMode();
$systemStatus = adminSystemStatus($databaseConfig);

$pageTitle = 'Admin System | SilentPrint';
$adminPage = 'system';

include dirname(__DIR__, 2) . '/includes/admin-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="account-grid">
            <div class="content-card shadow-none border-0 bg-light">
                <span class="content-meta mb-3">System</span>
                <h1 class="fw-bold mb-3">Access policy and environment</h1>
                <p class="text-muted mb-4"><?= htmlspecialchars($adminPolicy) ?></p>

                <div class="admin-access-list mb-4">
                    <?php foreach ($adminEmails as $email): ?>
                        <span class="admin-access-pill"><?= htmlspecialchars($email) ?></span>
                    <?php endforeach; ?>
                    <?php if ($adminEmails === []): ?>
                        <span class="admin-access-pill">No admin account resolved</span>
                    <?php endif; ?>
                </div>

                <div class="admin-system-list">
                    <div class="admin-system-row">
                        <span class="text-muted">Auth mode</span>
                        <strong><?= htmlspecialchars($authMode) ?></strong>
                    </div>
                    <div class="admin-system-row">
                        <span class="text-muted">Database host</span>
                        <strong><?= htmlspecialchars($systemStatus['databaseHost']) ?></strong>
                    </div>
                    <div class="admin-system-row">
                        <span class="text-muted">Database name</span>
                        <strong><?= htmlspecialchars($systemStatus['databaseName']) ?></strong>
                    </div>
                    <div class="admin-system-row">
                        <span class="text-muted">Legacy users JSON</span>
                        <strong><?= $systemStatus['legacyUsersJsonExists'] ? 'Present' : 'Missing' ?></strong>
                    </div>
                    <div class="admin-system-row">
                        <span class="text-muted">Legacy resets JSON</span>
                        <strong><?= $systemStatus['legacyResetsJsonExists'] ? 'Present' : 'Missing' ?></strong>
                    </div>
                </div>
            </div>

            <div class="content-card shadow-none border-0 bg-light">
                <span class="content-meta mb-3">Next Steps</span>
                <h5 class="fw-bold mb-3">Recommended hardening</h5>
                <div class="d-grid gap-3">
                    <div class="account-stat">
                        <div class="fw-semibold mb-1">Quote operations</div>
                        <div class="small text-muted">Use the dedicated Quotes page to verify whether the public quote route is still informational or backed by storage.</div>
                    </div>
                    <div class="account-stat">
                        <div class="fw-semibold mb-1">Set explicit admin emails</div>
                        <div class="small text-muted">Define SILENT_PRINT_ADMIN_EMAILS to avoid relying on the local fallback rule.</div>
                    </div>
                    <div class="account-stat">
                        <div class="fw-semibold mb-1">Add rate limiting</div>
                        <div class="small text-muted">Track login and reset attempts in MySQL to harden the auth flow.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>