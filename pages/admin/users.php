<?php
require_once dirname(__DIR__, 2) . '/includes/admin-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-data.php';

$connection = adminDbConnection();
$searchQuery = trim((string) ($_GET['q'] ?? ''));
$directoryUsers = adminDirectoryUsers($connection, $searchQuery, 20);
$adminEmails = authAdminEmails();

$pageTitle = 'Admin Users | SilentPrint';
$adminPage = 'users';

include dirname(__DIR__, 2) . '/includes/admin-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">User Directory</span>
                    <h1 class="fw-bold mb-2">Customer accounts</h1>
                    <p class="text-muted mb-0">Search across names and email addresses, then review which users currently have admin access.</p>
                </div>
                <form method="get" action="<?= $basePath ?>/admin/users/" class="admin-search-form">
                    <div class="input-group">
                        <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>" class="form-control admin-search-input" placeholder="Search by name or email">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <?php if ($searchQuery !== ''): ?>
                            <a href="<?= $basePath ?>/admin/users/" class="btn btn-outline-secondary">Clear</a>
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
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>