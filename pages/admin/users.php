<?php
require_once dirname(__DIR__, 2) . '/includes/admin-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-data.php';

authRequireAdminPrivileges($currentUser ?? null, $basePath);

$connection = adminDbConnection();
$searchQuery = trim((string) ($_GET['q'] ?? ''));
$managementErrors = [];
$managementValues = [
    'firstName' => trim((string) ($_POST['firstName'] ?? '')),
    'lastName' => trim((string) ($_POST['lastName'] ?? '')),
    'email' => trim((string) ($_POST['email'] ?? '')),
    'role' => trim((string) ($_POST['role'] ?? 'staff')),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');
    $csrfToken = $_POST['csrf_token'] ?? '';
    $allowedRoles = ['admin', 'staff'];

    if (!authVerifyCsrfToken($csrfToken)) {
        $managementErrors[] = 'Your session expired. Please try again.';
    }

    if ($managementValues['firstName'] === '' || $managementValues['lastName'] === '') {
        $managementErrors[] = 'First name and last name are required.';
    }

    if ($managementValues['email'] === '' || !filter_var($managementValues['email'], FILTER_VALIDATE_EMAIL)) {
        $managementErrors[] = 'A valid email address is required.';
    } elseif (authFindUserByEmail($managementValues['email'])) {
        $managementErrors[] = 'An account with that email already exists.';
    }

    if (!in_array(authNormalizeRole($managementValues['role']), $allowedRoles, true)) {
        $managementErrors[] = 'Role must be either admin or staff.';
    }

    if (strlen($password) < 8) {
        $managementErrors[] = 'Password must be at least 8 characters long.';
    }

    if ($managementErrors === []) {
        authCreateUser([
            'first_name' => $managementValues['firstName'],
            'last_name' => $managementValues['lastName'],
            'email' => $managementValues['email'],
            'password' => $password,
            'role' => $managementValues['role'],
        ]);

        authFlash('success', 'Backoffice account created successfully.');
        authRedirect($basePath, '/admin/users/');
    }
}

$directoryUsers = adminDirectoryUsers($connection, $searchQuery, 20);
$roleCounts = adminRoleCounts($connection);

$pageTitle = 'Admin Users | SilentPrint';
$adminPage = 'users';

include dirname(__DIR__, 2) . '/includes/admin-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">Backoffice Access</span>
                    <h1 class="fw-bold mb-2">Create admin and staff accounts</h1>
                    <p class="text-muted mb-0">Admins can provision new admins for governance and staff accounts for quote and future order operations.</p>
                </div>
                <div class="d-flex gap-3 flex-wrap">
                    <div class="account-stat">
                        <div class="small text-muted mb-1">Admins</div>
                        <div class="fw-semibold"><?= number_format($roleCounts['admin']) ?></div>
                    </div>
                    <div class="account-stat">
                        <div class="small text-muted mb-1">Staff</div>
                        <div class="fw-semibold"><?= number_format($roleCounts['staff']) ?></div>
                    </div>
                </div>
            </div>

            <?php if ($managementErrors !== []): ?>
                <div class="alert alert-danger auth-alert mb-4" role="alert">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($managementErrors as $managementError): ?>
                            <li><?= htmlspecialchars($managementError) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= $basePath ?>/admin/users/" method="post" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(authCsrfToken()) ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="managedFirstName" class="form-label">First name</label>
                        <input type="text" class="form-control auth-input" id="managedFirstName" name="firstName" value="<?= htmlspecialchars($managementValues['firstName']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="managedLastName" class="form-label">Last name</label>
                        <input type="text" class="form-control auth-input" id="managedLastName" name="lastName" value="<?= htmlspecialchars($managementValues['lastName']) ?>" required>
                    </div>
                    <div class="col-md-5">
                        <label for="managedEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control auth-input" id="managedEmail" name="email" value="<?= htmlspecialchars($managementValues['email']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="managedRole" class="form-label">Role</label>
                        <select class="form-select auth-input" id="managedRole" name="role">
                            <option value="staff" <?= authNormalizeRole($managementValues['role']) === 'staff' ? 'selected' : '' ?>>Staff</option>
                            <option value="admin" <?= authNormalizeRole($managementValues['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="managedPassword" class="form-label">Temporary password</label>
                        <input type="password" class="form-control auth-input" id="managedPassword" name="password" placeholder="Minimum 8 chars" required>
                    </div>
                </div>
                <div class="small text-muted mt-3 mb-4">Staff can manage quote workflows and future order operations. Admins keep full governance over users, security, and system settings.</div>
                <div class="d-flex gap-3 flex-wrap">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create Backoffice Account</button>
                    <a href="<?= $basePath ?>/admin/quotes/" class="btn btn-outline-secondary rounded-pill px-4">Review Quote Queue</a>
                </div>
            </form>
        </div>

        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">User Directory</span>
                    <h1 class="fw-bold mb-2">All accounts</h1>
                    <p class="text-muted mb-0">Search across customers, staff, and admins, then review which role each account currently holds.</p>
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
                                <th scope="col">Role</th>
                                <th scope="col">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($directoryUsers as $user): ?>
                                <?php $resolvedRole = (string) ($user['resolved_role'] ?? authUserRole($user)); ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: 'Unnamed User') ?></div>
                                    </td>
                                    <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                                    <td>
                                        <span class="admin-badge <?= adminResolvedRoleBadgeClass($resolvedRole) ?>">
                                            <?= htmlspecialchars(adminResolvedRoleLabel($resolvedRole)) ?>
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