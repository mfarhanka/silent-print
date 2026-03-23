<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../login/');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';

authRequireGuest($currentUser ?? null, $basePath);

$loginError = '';
$loginEmail = trim($_POST['email'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $user = authFindUserByEmail($loginEmail);
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!authVerifyCsrfToken($csrfToken)) {
        $loginError = 'Your session expired. Please try again.';
    } elseif ($loginEmail === '' || $password === '') {
        $loginError = 'Email and password are required.';
    } elseif (!$user || !password_verify($password, $user['password_hash'] ?? '')) {
        $loginError = 'The email or password is incorrect.';
    } else {
        authLoginUser($user);
        authFlash('success', 'You are now logged in.');
        authRedirect($basePath, authLoginDestination($user));
    }
}

$pageTitle = 'Log In | SilentPrint';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $basePath ?>/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $basePath ?>/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $basePath ?>/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="<?= $basePath ?>/favicon_io/site.webmanifest">
    <link rel="shortcut icon" href="<?= $basePath ?>/favicon_io/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
</head>
<body class="client-login-page">
    <?php if (!empty($flash['message'])): ?>
        <div class="container pt-4">
            <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?> auth-alert mb-0" role="alert">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        </div>
    <?php endif; ?>

    <section class="auth-shell">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-11">
                    <div class="auth-panel">
                        <div class="row g-0">
                            <div class="col-lg-5">
                                <div class="auth-aside d-flex flex-column justify-content-between">
                                    <div>
                                        <a href="<?= $basePath ?>/" class="d-inline-flex align-items-center text-white text-decoration-none mb-4">
                                            <img src="<?= $basePath ?>/img/logo.png" class="site-logo" alt="SilentPrint" loading="eager">
                                        </a>
                                        <span class="content-meta bg-white text-primary mb-3">Account Access</span>
                                        <h1 class="fw-bold mb-3">Welcome back to SilentPrint.</h1>
                                        <p class="mb-0 opacity-75">Sign in to review orders, manage requests, and keep your print workflow moving without repeating the setup.</p>
                                    </div>
                                    <div class="mt-5">
                                        <div class="small text-uppercase opacity-75 mb-2">Why sign in</div>
                                        <ul class="mb-0 ps-3">
                                            <li class="mb-2">Track current and previous orders</li>
                                            <li class="mb-2">Reuse saved product preferences</li>
                                            <li class="mb-0">Manage quote follow-ups in one place</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="auth-form-wrap">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                                        <div>
                                            <h2 class="fw-bold mb-2">Log In</h2>
                                            <p class="text-muted mb-0">Enter your email and password to access your account.</p>
                                        </div>
                                        <a href="<?= $basePath ?>/admin/login/" class="btn btn-outline-primary rounded-pill px-3">Backoffice Login</a>
                                    </div>
                                    <?php if ($loginError !== ''): ?>
                                        <div class="alert alert-danger auth-alert" role="alert"><?= htmlspecialchars($loginError) ?></div>
                                    <?php endif; ?>
                                    <form action="" method="post" novalidate>
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(authCsrfToken()) ?>">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input type="email" class="form-control auth-input" id="email" name="email" placeholder="name@company.com" value="<?= htmlspecialchars($loginEmail) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label for="password" class="form-label mb-0">Password</label>
                                                <a href="<?= $basePath ?>/forgot-password/" class="small text-decoration-none">Need help?</a>
                                            </div>
                                            <input type="password" class="form-control auth-input" id="password" name="password" placeholder="Enter your password" required>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                            <a href="<?= $basePath ?>/forgot-password/" class="small text-decoration-none">Forgot password?</a>
                                        </div>
                                        <div class="d-grid gap-3">
                                            <button type="submit" class="btn btn-primary rounded-pill py-2">Continue</button>
                                            <button type="button" class="btn btn-outline-secondary rounded-pill py-2">Continue with Google</button>
                                        </div>
                                    </form>
                                    <p class="small text-muted mt-4 mb-2">New here? <a href="<?= $basePath ?>/signup/" class="text-decoration-none">Create an account</a>.</p>
                                    <p class="small text-muted mb-2">Admin or staff? <a href="<?= $basePath ?>/admin/login/" class="text-decoration-none">Use the backoffice login</a>.</p>
                                    <p class="small text-muted mb-0">This login now uses local PHP session authentication backed by the workspace data store.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>