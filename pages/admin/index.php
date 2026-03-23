<?php
require_once dirname(__DIR__, 2) . '/includes/admin-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-data.php';

authRequireAdminPrivileges($currentUser ?? null, $basePath);

$connection = adminDbConnection();
$databaseConfig = adminDatabaseConfig();
$totalUsers = adminTotalUsers($connection);
$usersThisWeek = adminUsersThisWeek($connection);
$usersThisMonth = adminUsersThisMonth($connection);
$activeResets = adminActiveResets($connection);
$expiredResets = adminExpiredResets($connection);
$roleCounts = adminRoleCounts($connection);
$backofficeUsers = adminBackofficeUsers($connection);
$recentUsers = adminRecentUsers($connection, 8);
$adminPolicy = adminPolicySummary();
$authMode = adminAuthMode();
$systemStatus = adminSystemStatus($databaseConfig);
$quoteStatus = adminQuoteStatus($connection, $basePath);

$pageTitle = 'Admin Dashboard | SilentPrint';
$adminPage = 'dashboard';

include dirname(__DIR__, 2) . '/includes/admin-header.php';
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
                        <div class="admin-stat-label">Backoffice users</div>
                        <div class="admin-stat-value"><?= number_format($roleCounts['admin'] + $roleCounts['staff']) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-person-badge-fill"></i></div>
                </div>
                <p class="text-muted mb-0">Admins and staff who can access the management console.</p>
            </article>
        </div>

        <div class="admin-shortcuts mb-4">
            <article class="content-card shadow-none border-0 bg-light admin-shortcut-card">
                <div class="admin-kicker">Quotes</div>
                <h5 class="fw-bold mb-2">Review quote operations</h5>
                <p class="text-muted mb-3">See whether quote intake is live and what the next implementation step should be.</p>
                <a href="<?= $basePath ?>/admin/quotes/" class="btn btn-outline-primary rounded-pill">Open Quote Operations</a>
            </article>
            <article class="content-card shadow-none border-0 bg-light admin-shortcut-card">
                <div class="admin-kicker">Accounts</div>
                <h5 class="fw-bold mb-2">Search user directory</h5>
                <p class="text-muted mb-3">Find accounts by name or email directly from the users table.</p>
                <a href="<?= $basePath ?>/admin/users/" class="btn btn-outline-primary rounded-pill">Open User Directory</a>
            </article>
            <article class="content-card shadow-none border-0 bg-light admin-shortcut-card">
                <div class="admin-kicker">Security</div>
                <h5 class="fw-bold mb-2">Review reset activity</h5>
                <p class="text-muted mb-3">Inspect recent password reset requests and whether each link is still active.</p>
                <a href="<?= $basePath ?>/admin/security/" class="btn btn-outline-primary rounded-pill">Open Security Feed</a>
            </article>
            <article class="content-card shadow-none border-0 bg-light admin-shortcut-card">
                <div class="admin-kicker">System</div>
                <h5 class="fw-bold mb-2">Check app configuration</h5>
                <p class="text-muted mb-3">See which database is active and how admin access is currently resolved.</p>
                <a href="<?= $basePath ?>/admin/system/" class="btn btn-outline-primary rounded-pill">Open System Status</a>
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
                        <?php foreach ($backofficeUsers as $backofficeUser): ?>
                            <span class="admin-access-pill"><?= htmlspecialchars(($backofficeUser['email'] ?? '') . ' • ' . adminResolvedRoleLabel($backofficeUser['resolved_role'] ?? 'customer')) ?></span>
                        <?php endforeach; ?>
                        <?php if ($backofficeUsers === []): ?>
                            <span class="admin-access-pill">No backoffice accounts resolved</span>
                        <?php endif; ?>
                    </div>

                    <div class="admin-system-list mt-4">
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
                    <h5 class="fw-bold mb-3">Recommended next steps</h5>
                    <div class="d-grid gap-3">
                        <div class="account-stat">
                            <div class="fw-semibold mb-1">Quote operations status</div>
                            <div class="small text-muted"><?= htmlspecialchars($quoteStatus['nextAction']) ?></div>
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
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>