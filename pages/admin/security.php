<?php
require_once dirname(__DIR__, 2) . '/includes/admin-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-data.php';

authRequireAdminPrivileges($currentUser ?? null, $basePath);

$connection = adminDbConnection();
$activeResets = adminActiveResets($connection);
$recentResets = adminRecentResets($connection, 10);

$pageTitle = 'Admin Security | SilentPrint';
$adminPage = 'security';

include dirname(__DIR__, 2) . '/includes/admin-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card" id="admin-security">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">Security Feed</span>
                    <h1 class="fw-bold mb-2">Password reset activity</h1>
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

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>