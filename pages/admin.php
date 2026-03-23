<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../admin/');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/database.php';

authRequireAdmin($currentUser ?? null, $basePath);

$connection = dbConnection();
$databaseConfig = dbConfig();
$searchQuery = trim((string) ($_GET['q'] ?? ''));
$totalUsers = (int) (($connection->query('SELECT COUNT(*) AS total FROM users')->fetch_assoc()['total'] ?? 0));
$usersThisWeek = (int) (($connection->query("SELECT COUNT(*) AS total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['total'] ?? 0));
$usersThisMonth = (int) (($connection->query("SELECT COUNT(*) AS total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetch_assoc()['total'] ?? 0));
$activeResets = (int) (($connection->query('SELECT COUNT(*) AS total FROM password_resets WHERE expires_at > NOW()')->fetch_assoc()['total'] ?? 0));
$expiredResets = (int) (($connection->query('SELECT COUNT(*) AS total FROM password_resets WHERE expires_at <= NOW()')->fetch_assoc()['total'] ?? 0));
$adminEmails = authAdminEmails();
$recentUsers = [];
$directoryUsers = [];
$recentResets = [];
$recentUsersResult = $connection->query('SELECT first_name, last_name, email, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT 8');

if ($recentUsersResult instanceof mysqli_result) {
    while ($row = $recentUsersResult->fetch_assoc()) {
        $recentUsers[] = $row;
    }
}

if ($searchQuery !== '') {
    $directoryStatement = $connection->prepare('SELECT first_name, last_name, email, created_at FROM users WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? ORDER BY created_at DESC, id DESC LIMIT 20');
    $searchTerm = '%' . $searchQuery . '%';
    $directoryStatement->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
    $directoryStatement->execute();
    $directoryResult = $directoryStatement->get_result();

    if ($directoryResult instanceof mysqli_result) {
        while ($row = $directoryResult->fetch_assoc()) {
            $directoryUsers[] = $row;
        }
    }

    $directoryStatement->close();
} else {
    $directoryResult = $connection->query('SELECT first_name, last_name, email, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT 20');

    if ($directoryResult instanceof mysqli_result) {
        while ($row = $directoryResult->fetch_assoc()) {
            $directoryUsers[] = $row;
        }
    }
}

$recentResetsResult = $connection->query('SELECT email, created_at, expires_at FROM password_resets ORDER BY created_at DESC, id DESC LIMIT 10');

if ($recentResetsResult instanceof mysqli_result) {
    while ($row = $recentResetsResult->fetch_assoc()) {
        $recentResets[] = $row;
    }
}

$adminPolicy = getenv('SILENT_PRINT_ADMIN_EMAILS')
    ? 'Admin access is controlled by the SILENT_PRINT_ADMIN_EMAILS environment variable.'
    : 'Admin access currently falls back to the earliest registered account for local development.';

$authMode = getenv('SILENT_PRINT_ADMIN_EMAILS') ? 'Explicit environment configuration' : 'Local fallback mode';
$databaseHost = (string) ($databaseConfig['host'] ?? '127.0.0.1');
$databaseName = (string) ($databaseConfig['database'] ?? 'silent_print');
$legacyUsersJsonExists = is_file(dirname(__DIR__) . '/data/users.json');
$legacyResetsJsonExists = is_file(dirname(__DIR__) . '/data/password_resets.json');

$pageTitle = 'Admin Dashboard | SilentPrint';
$adminPage = 'dashboard';

include dirname(__DIR__) . '/includes/admin-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <span class="content-meta mb-3">Admin Dashboard</span>
                    <h1 class="fw-bold mb-2">Admin control center</h1>
                    <p class="text-muted mb-0">Review account activity, auth health, reset traffic, and current system access rules from one page.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= $basePath ?>/account/" class="btn btn-outline-primary rounded-pill px-4">Back to Account</a>
                    <a href="<?= $basePath ?>/products/" class="btn btn-primary rounded-pill px-4">View Storefront</a>
                </div>
            </div>
        </div>

        <div class="admin-stats-grid mb-4">
            <article class="admin-stat-card admin-stat-card-featured">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Registered users</div>
                        <div class="admin-stat-value"><?= number_format($totalUsers) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-people-fill"></i></div>
                </div>
                <p class="text-muted mb-4">All customer accounts currently stored in MySQL.</p>
                <div class="admin-stat-footer">
                    <span class="admin-stat-chip">This week: <?= number_format($usersThisWeek) ?></span>
                    <span class="admin-stat-chip">This month: <?= number_format($usersThisMonth) ?></span>
                </div>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">New this week</div>
                        <div class="admin-stat-value"><?= number_format($usersThisWeek) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-calendar-week"></i></div>
                </div>
                <p class="text-muted mb-0">Accounts created during the last 7 days.</p>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">New this month</div>
                        <div class="admin-stat-value"><?= number_format($usersThisMonth) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-calendar-range"></i></div>
                </div>
                <p class="text-muted mb-0">Accounts created during the last 30 days.</p>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Active reset links</div>
                        <div class="admin-stat-value"><?= number_format($activeResets) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-shield-lock-fill"></i></div>
                </div>
                <p class="text-muted mb-0">Password reset requests that have not expired yet.</p>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Expired resets</div>
                        <div class="admin-stat-value"><?= number_format($expiredResets) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-clock-history"></i></div>
                </div>
                <p class="text-muted mb-0">Historical reset records still stored in the database.</p>
            </article>
            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Admin accounts</div>
                        <div class="admin-stat-value"><?= number_format(count($adminEmails)) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-person-badge-fill"></i></div>
                </div>
                <p class="text-muted mb-0">Accounts currently allowed to open this dashboard.</p>
            </article>
        </div>

        <div class="admin-shortcuts mb-4">
            <article class="content-card shadow-none border-0 bg-light admin-shortcut-card">
                <div class="admin-kicker">Accounts</div>
                <h5 class="fw-bold mb-2">Search user directory</h5>
                <p class="text-muted mb-3">Find accounts by name or email directly from the users table.</p>
                <a href="#admin-users" class="btn btn-outline-primary rounded-pill">Open User Directory</a>
            </article>
            <article class="content-card shadow-none border-0 bg-light admin-shortcut-card">
                <div class="admin-kicker">Security</div>
                <h5 class="fw-bold mb-2">Review reset activity</h5>
                <p class="text-muted mb-3">Inspect recent password reset requests and whether each link is still active.</p>
                <a href="#admin-security" class="btn btn-outline-primary rounded-pill">Open Security Feed</a>
            </article>
            <article class="content-card shadow-none border-0 bg-light admin-shortcut-card">
                <div class="admin-kicker">System</div>
                <h5 class="fw-bold mb-2">Check app configuration</h5>
                <p class="text-muted mb-3">See which database is active and how admin access is currently resolved.</p>
                <a href="#admin-system" class="btn btn-outline-primary rounded-pill">Open System Status</a>
            </article>
        </div>

        <div class="account-grid mb-4">
            <div class="content-card shadow-none border-0 bg-light" id="admin-activity">
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
                <div class="content-card shadow-none border-0 bg-light" id="admin-system">
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

                    <div class="admin-system-list mt-4">
                        <div class="admin-system-row">
                            <span class="text-muted">Auth mode</span>
                            <strong><?= htmlspecialchars($authMode) ?></strong>
                        </div>
                        <div class="admin-system-row">
                            <span class="text-muted">Database host</span>
                            <strong><?= htmlspecialchars($databaseHost) ?></strong>
                        </div>
                        <div class="admin-system-row">
                            <span class="text-muted">Database name</span>
                            <strong><?= htmlspecialchars($databaseName) ?></strong>
                        </div>
                        <div class="admin-system-row">
                            <span class="text-muted">Legacy users JSON</span>
                            <strong><?= $legacyUsersJsonExists ? 'Present' : 'Missing' ?></strong>
                        </div>
                        <div class="admin-system-row">
                            <span class="text-muted">Legacy resets JSON</span>
                            <strong><?= $legacyResetsJsonExists ? 'Present' : 'Missing' ?></strong>
                        </div>
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

        <div class="content-card mb-4" id="admin-users">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">User Directory</span>
                    <h5 class="fw-bold mb-2">Customer accounts</h5>
                    <p class="text-muted mb-0">Search across names and email addresses, then review who has admin access.</p>
                </div>
                <form method="get" action="<?= $basePath ?>/admin/" class="admin-search-form">
                    <div class="input-group">
                        <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>" class="form-control admin-search-input" placeholder="Search by name or email">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <?php if ($searchQuery !== ''): ?>
                            <a href="<?= $basePath ?>/admin/" class="btn btn-outline-secondary">Clear</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <?php if ($directoryUsers === []): ?>
                <div class="account-stat">
                    <div class="fw-semibold">No matching accounts</div>
                    <div class="small text-muted">Try a broader search or remove the filter.</div>
                </div>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Access</th>
                                <th scope="col">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($directoryUsers as $user): ?>
                                <?php $isAdminUser = in_array(authNormalizeEmail((string) ($user['email'] ?? '')), $adminEmails, true); ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: 'Unnamed User') ?></div>
                                    </td>
                                    <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                                    <td>
                                        <span class="admin-badge <?= $isAdminUser ? 'is-admin' : 'is-user' ?>">
                                            <?= $isAdminUser ? 'Admin' : 'User' ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars(date('d M Y, H:i', strtotime($user['created_at'] ?? 'now'))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="content-card" id="admin-security">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">Security Feed</span>
                    <h5 class="fw-bold mb-2">Password reset activity</h5>
                    <p class="text-muted mb-0">Track which accounts requested reset links and whether those links are still active.</p>
                </div>
                <div class="admin-note">
                    <strong><?= number_format($activeResets) ?></strong> active reset links
                </div>
            </div>

            <?php if ($recentResets === []): ?>
                <div class="account-stat">
                    <div class="fw-semibold">No reset activity yet</div>
                    <div class="small text-muted">Reset requests will appear here once the forgot-password flow is used.</div>
                </div>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Email</th>
                                <th scope="col">Requested</th>
                                <th scope="col">Expires</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentResets as $reset): ?>
                                <?php $isActiveReset = strtotime((string) ($reset['expires_at'] ?? '')) > time(); ?>
                                <tr>
                                    <td><?= htmlspecialchars($reset['email'] ?? '') ?></td>
                                    <td><?= htmlspecialchars(date('d M Y, H:i', strtotime($reset['created_at'] ?? 'now'))) ?></td>
                                    <td><?= htmlspecialchars(date('d M Y, H:i', strtotime($reset['expires_at'] ?? 'now'))) ?></td>
                                    <td>
                                        <span class="admin-badge <?= $isActiveReset ? 'is-active' : 'is-expired' ?>">
                                            <?= $isActiveReset ? 'Active' : 'Expired' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/admin-footer.php'; ?>