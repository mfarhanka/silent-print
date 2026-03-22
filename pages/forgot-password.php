<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../forgot-password/');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';
authRequireGuest($currentUser ?? null, $basePath);

$requestError = '';
$requestEmail = trim($_POST['email'] ?? '');
$resetLink = '';
$requestSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!authVerifyCsrfToken($csrfToken)) {
        $requestError = 'Your session expired. Please try again.';
    } elseif ($requestEmail === '' || !filter_var($requestEmail, FILTER_VALIDATE_EMAIL)) {
        $requestError = 'Enter a valid email address.';
    } else {
        $user = authFindUserByEmail($requestEmail);
        if ($user) {
            $token = authCreatePasswordReset($requestEmail);
            $resetLink = $basePath . '/reset-password/?token=' . urlencode($token);
        }

        $requestSuccess = true;
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
                        <span class="content-meta mb-3">Password Reset</span>
                        <h1 class="fw-bold mb-2">Reset your password.</h1>
                        <p class="text-muted mb-4">Enter your account email. In this local setup, the reset link will be shown directly instead of being emailed.</p>

                        <?php if ($requestError !== ''): ?>
                            <div class="alert alert-danger auth-alert" role="alert"><?= htmlspecialchars($requestError) ?></div>
                        <?php endif; ?>

                        <?php if ($requestSuccess): ?>
                            <div class="alert alert-success auth-alert" role="alert">
                                If an account exists for that email, a reset link has been prepared.
                                <?php if ($resetLink !== ''): ?>
                                    <div class="mt-2">
                                        <a href="<?= htmlspecialchars($resetLink) ?>" class="alert-link">Open your reset link</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="post" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(authCsrfToken()) ?>">
                            <div class="mb-3">
                                <label for="resetEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control auth-input" id="resetEmail" name="email" placeholder="name@company.com" value="<?= htmlspecialchars($requestEmail) ?>" required>
                            </div>
                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-primary rounded-pill py-2">Send Reset Link</button>
                                <a href="<?= $basePath ?>/login/" class="btn btn-outline-secondary rounded-pill py-2">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>