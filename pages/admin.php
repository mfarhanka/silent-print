<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../admin/');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/database.php';

authRequireAdmin($currentUser ?? null, $basePath);

$connection = dbConnection();
$totalUsers = (int) (($connection->query('SELECT COUNT(*) AS total FROM users')->fetch_assoc()['total'] ?? 0));
$usersThisWeek = (int) (($connection->query("SELECT COUNT(*) AS total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['total'] ?? 0));
$activeResets = (int) (($connection->query('SELECT COUNT(*) AS total FROM password_resets WHERE expires_at > NOW()')->fetch_assoc()['total'] ?? 0));
$adminEmails = authAdminEmails();
$recentUsers = [];
$recentUsersResult = $connection->query('SELECT first_name, last_name, email, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT 8');

if ($recentUsersResult instanceof mysqli_result) {
    while ($row = $recentUsersResult->fetch_assoc()) {
        $recentUsers[] = $row;
    }
}

$adminPolicy = getenv('SILENT_PRINT_ADMIN_EMAILS')
    ? 'Admin access is controlled by the SILENT_PRINT_ADMIN_EMAILS environment variable.'
    : 'Admin access currently falls back to the earliest registered account for local development.';

include dirname(__DIR__) . '/includes/header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <span class="content-meta mb-3">Admin Dashboard</span>
                    <h1 class="fw-bold mb-2">Operational overview</h1>
                    <p class="text-muted mb-0">Monitor account growth, active reset requests, and the accounts that currently have admin access.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= $basePath ?>/account/" class="btn btn-outline-primary rounded-pill px-4">Back to Account</a>
                    <a href="<?= $basePath ?>/products/" class="btn btn-primary rounded-pill px-4">View Storefront</a>
                </div>
            </div>
        </div>

        <div class="admin-stats-grid mb-4">
            <article class="admin-stat-card">
                <div class="admin-stat-label">Registered users</div>
                <div class="admin-stat-value"><?= number_format($totalUsers) ?></div>
                <p class="text-muted mb-0">All customer accounts currently stored in MySQL.</p>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-label">New this week</div>
                <div class="admin-stat-value"><?= number_format($usersThisWeek) ?></div>
                <p class="text-muted mb-0">Accounts created during the last 7 days.</p>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-label">Active reset links</div>
                <div class="admin-stat-value"><?= number_format($activeResets) ?></div>
                <p class="text-muted mb-0">Password reset requests that have not expired yet.</p>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-label">Admin accounts</div>
                <div class="admin-stat-value"><?= number_format(count($adminEmails)) ?></div>
                <p class="text-muted mb-0">Accounts currently allowed to open this dashboard.</p>
            </article>
        </div>

        <div class="account-grid">
            <div class="content-card shadow-none border-0 bg-light">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                    <div>
                        <h5 class="fw-bold mb-2">Recent account activity</h5>
                        <p class="text-muted mb-0">Latest sign-ups captured from the users table.</p>
                    </div>
                    <span class="content-meta">Last <?= count($recentUsers) ?> accounts</span>
                </div>

                <?php if ($recentUsers === []): ?>
                    <div class="account-stat">
                        <div class="fw-semibold">No accounts found</div>
                        <div class="small text-muted">Create a test user from the sign-up page to populate the dashboard.</div>
                    </div>
                <?php else: ?>
                    <div class="admin-user-list">
                        <?php foreach ($recentUsers as $user): ?>
                            <div class="admin-user-row">
                                <div>
                                    <div class="fw-semibold"><?= htmlspecialchars(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: 'Unnamed User') ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                                </div>
                                <div class="small text-muted text-md-end">
                                    Joined <?= htmlspecialchars(date('d M Y, H:i', strtotime($user['created_at'] ?? 'now'))) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-grid gap-4">
                <div class="content-card shadow-none border-0 bg-light">
                    <h5 class="fw-bold mb-3">Access policy</h5>
                    <p class="text-muted"><?= htmlspecialchars($adminPolicy) ?></p>
                    <div class="admin-access-list">
                        <?php foreach ($adminEmails as $email): ?>
                            <span class="admin-access-pill"><?= htmlspecialchars($email) ?></span>
                        <?php endforeach; ?>
                        <?php if ($adminEmails === []): ?>
                            <span class="admin-access-pill">No admin account resolved</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="content-card shadow-none border-0 bg-light">
                    <h5 class="fw-bold mb-3">Recommended next steps</h5>
                    <div class="d-grid gap-3">
                        <div class="account-stat">
                            <div class="fw-semibold mb-1">Set explicit admin emails</div>
                            <div class="small text-muted">Define SILENT_PRINT_ADMIN_EMAILS to avoid relying on the local fallback rule.</div>
                        </div>
                        <div class="account-stat">
                            <div class="fw-semibold mb-1">Add quote management</div>
                            <div class="small text-muted">The dashboard is ready for quote and order metrics once those tables exist.</div>
                        </div>
                        <div class="account-stat">
                            <div class="fw-semibold mb-1">Add rate limiting</div>
                            <div class="small text-muted">Track login and reset attempts in MySQL to harden the auth flow.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>