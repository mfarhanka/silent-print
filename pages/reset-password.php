<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../reset-password/');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';
authRequireGuest($currentUser ?? null, $basePath);

$token = trim($_GET['token'] ?? ($_POST['token'] ?? ''));
$resetRecord = $token !== '' ? authFindPasswordReset($token) : null;
$resetError = '';
$resetSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!authVerifyCsrfToken($csrfToken)) {
        $resetError = 'Your session expired. Please try again.';
    } elseif (!$resetRecord) {
        $resetError = 'This reset link is invalid or has expired.';
    } elseif (strlen($password) < 8) {
        $resetError = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirmPassword) {
        $resetError = 'Password confirmation does not match.';
    } elseif (!authConsumePasswordReset($token, $password)) {
        $resetError = 'This reset link is invalid or has expired.';
    } else {
        $resetSuccess = true;
    }
}

include dirname(__DIR__) . '/includes/header.php';
?>

<section class="auth-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="auth-panel">
                    <div class="auth-form-wrap">
                        <span class="content-meta mb-3">Set New Password</span>
                        <h1 class="fw-bold mb-2">Choose a new password.</h1>
                        <p class="text-muted mb-4">Use a password you have not used before and keep it at least 8 characters long.</p>

                        <?php if ($resetError !== ''): ?>
                            <div class="alert alert-danger auth-alert" role="alert"><?= htmlspecialchars($resetError) ?></div>
                        <?php endif; ?>

                        <?php if ($resetSuccess): ?>
                            <div class="alert alert-success auth-alert" role="alert">
                                Your password has been updated. You can now <a href="<?= $basePath ?>/login/" class="alert-link">log in</a>.
                            </div>
                        <?php elseif ($resetRecord): ?>
                            <form action="" method="post" novalidate>
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(authCsrfToken()) ?>">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="newPassword" class="form-label">New password</label>
                                        <input type="password" class="form-control auth-input" id="newPassword" name="password" placeholder="Create a new password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="newPasswordConfirm" class="form-label">Confirm password</label>
                                        <input type="password" class="form-control auth-input" id="newPasswordConfirm" name="confirmPassword" placeholder="Repeat the password" required>
                                    </div>
                                </div>
                                <div class="d-grid gap-3 mt-4">
                                    <button type="submit" class="btn btn-primary rounded-pill py-2">Update Password</button>
                                    <a href="<?= $basePath ?>/login/" class="btn btn-outline-secondary rounded-pill py-2">Back to Login</a>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning auth-alert" role="alert">
                                This reset link is invalid or has expired. <a href="<?= $basePath ?>/forgot-password/" class="alert-link">Request a new one</a>.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>