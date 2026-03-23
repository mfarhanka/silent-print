<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../admin/login/');
    exit;
}

require_once dirname(__DIR__, 2) . '/includes/auth.php';

authRequireGuestForBackoffice($currentUser ?? null, $basePath);

$loginError = '';
$loginEmail = trim((string) ($_POST['email'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');
    $user = authFindUserByEmail($loginEmail);
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!authVerifyCsrfToken($csrfToken)) {
        $loginError = 'Your session expired. Please try again.';
    } elseif ($loginEmail === '' || $password === '') {
        $loginError = 'Email and password are required.';
    } elseif (!$user || !password_verify($password, $user['password_hash'] ?? '')) {
        $loginError = 'The email or password is incorrect.';
    } elseif (!authHasBackofficeAccess($user)) {
        $loginError = 'This login is only for admin and staff accounts. Use the client login instead.';
    } else {
        authLoginUser($user);
        authFlash('success', 'You are now logged in to the management console.');
        authRedirect($basePath, authLoginDestination($user));
    }
}

include dirname(__DIR__, 2) . '/includes/header.php';
?>

<section class="auth-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="auth-panel">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="auth-aside d-flex flex-column justify-content-between">
                                <div>
                                    <span class="content-meta bg-white text-primary mb-3">Backoffice Access</span>
                                    <h1 class="fw-bold mb-3">Management console login.</h1>
                                    <p class="mb-0 opacity-75">Use this entry point for admin and staff accounts that manage quotes, operations, and system settings.</p>
                                </div>
                                <div class="mt-5">
                                    <div class="small text-uppercase opacity-75 mb-2">Who should use this</div>
                                    <ul class="mb-0 ps-3">
                                        <li class="mb-2">Admins managing users and security</li>
                                        <li class="mb-2">Staff working quote and order operations</li>
                                        <li class="mb-0">Not intended for client accounts</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="auth-form-wrap">
                                <h2 class="fw-bold mb-2">Admin / Staff Login</h2>
                                <p class="text-muted mb-4">Enter your backoffice account credentials to access the management console.</p>
                                <?php if ($loginError !== ''): ?>
                                    <div class="alert alert-danger auth-alert" role="alert"><?= htmlspecialchars($loginError) ?></div>
                                <?php endif; ?>
                                <form action="" method="post" novalidate>
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(authCsrfToken()) ?>">
                                    <div class="mb-3">
                                        <label for="adminEmail" class="form-label">Email address</label>
                                        <input type="email" class="form-control auth-input" id="adminEmail" name="email" placeholder="name@company.com" value="<?= htmlspecialchars($loginEmail) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="adminPassword" class="form-label mb-0">Password</label>
                                            <a href="<?= $basePath ?>/forgot-password/" class="small text-decoration-none">Need help?</a>
                                        </div>
                                        <input type="password" class="form-control auth-input" id="adminPassword" name="password" placeholder="Enter your password" required>
                                    </div>
                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-primary rounded-pill py-2">Open Console</button>
                                    </div>
                                </form>
                                <p class="small text-muted mt-4 mb-2">Client account? <a href="<?= $basePath ?>/login/" class="text-decoration-none">Use the client login</a>.</p>
                                <p class="small text-muted mb-0">Successful login redirects admins to the admin dashboard and staff to the quotes operations console.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>