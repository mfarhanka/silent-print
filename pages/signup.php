<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../signup/');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';

authRequireGuest($currentUser ?? null, $basePath);

$signupErrors = [];
$signupValues = [
    'firstName' => trim($_POST['firstName'] ?? ''),
    'lastName' => trim($_POST['lastName'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $agreeTerms = $_POST['agreeTerms'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!authVerifyCsrfToken($csrfToken)) {
        $signupErrors[] = 'Your session expired. Please try again.';
    }

    if ($signupValues['firstName'] === '' || $signupValues['lastName'] === '') {
        $signupErrors[] = 'First name and last name are required.';
    }

    if ($signupValues['email'] === '' || !filter_var($signupValues['email'], FILTER_VALIDATE_EMAIL)) {
        $signupErrors[] = 'A valid email address is required.';
    } elseif (authFindUserByEmail($signupValues['email'])) {
        $signupErrors[] = 'An account with that email already exists.';
    }

    if (strlen($password) < 8) {
        $signupErrors[] = 'Password must be at least 8 characters long.';
    }

    if ($password !== $confirmPassword) {
        $signupErrors[] = 'Password confirmation does not match.';
    }

    if ($agreeTerms !== '1') {
        $signupErrors[] = 'You must agree to the terms to create an account.';
    }

    if ($signupErrors === []) {
        $user = authCreateUser([
            'first_name' => $signupValues['firstName'],
            'last_name' => $signupValues['lastName'],
            'email' => $signupValues['email'],
            'password' => $password,
        ]);

        authLoginUser($user);
        authFlash('success', 'Your account has been created. Welcome to SilentPrint.');
        authRedirect($basePath, '/account/');
    }
}

include dirname(__DIR__) . '/includes/header.php';
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
                                    <span class="content-meta bg-white text-primary mb-3">Create Account</span>
                                    <h1 class="fw-bold mb-3">Set up your SilentPrint account.</h1>
                                    <p class="mb-0 opacity-75">Create an account to save product preferences, manage quotes, and keep all print requests in one place.</p>
                                </div>
                                <div class="mt-5">
                                    <div class="small text-uppercase opacity-75 mb-2">What you get</div>
                                    <ul class="mb-0 ps-3">
                                        <li class="mb-2">Faster repeat ordering</li>
                                        <li class="mb-2">Access to quote and order history</li>
                                        <li class="mb-0">A central workspace for print requests</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="auth-form-wrap">
                                <h2 class="fw-bold mb-2">Sign Up</h2>
                                <p class="text-muted mb-4">Create your account with your basic details and a secure password.</p>
                                <?php if ($signupErrors !== []): ?>
                                    <div class="alert alert-danger auth-alert" role="alert">
                                        <ul class="mb-0 ps-3">
                                            <?php foreach ($signupErrors as $signupError): ?>
                                                <li><?= htmlspecialchars($signupError) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <form action="" method="post" novalidate>
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(authCsrfToken()) ?>">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label">First name</label>
                                            <input type="text" class="form-control auth-input" id="firstName" name="firstName" placeholder="Aina" value="<?= htmlspecialchars($signupValues['firstName']) ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last name</label>
                                            <input type="text" class="form-control auth-input" id="lastName" name="lastName" placeholder="Rahman" value="<?= htmlspecialchars($signupValues['lastName']) ?>" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="signupEmail" class="form-label">Email address</label>
                                            <input type="email" class="form-control auth-input" id="signupEmail" name="email" placeholder="name@company.com" value="<?= htmlspecialchars($signupValues['email']) ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="signupPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control auth-input" id="signupPassword" name="password" placeholder="Create a password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirmPassword" class="form-label">Confirm password</label>
                                            <input type="password" class="form-control auth-input" id="confirmPassword" name="confirmPassword" placeholder="Repeat your password" required>
                                        </div>
                                    </div>
                                    <div class="form-check mt-4 mb-4">
                                        <input class="form-check-input" type="checkbox" value="1" id="agreeTerms" name="agreeTerms" <?= (($_POST['agreeTerms'] ?? '') === '1') ? 'checked' : '' ?> required>
                                        <label class="form-check-label" for="agreeTerms">I agree to the terms of service and privacy policy.</label>
                                    </div>
                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-primary rounded-pill py-2">Create Account</button>
                                        <button type="button" class="btn btn-outline-secondary rounded-pill py-2">Sign up with Google</button>
                                    </div>
                                </form>
                                <p class="small text-muted mt-4 mb-2">Already have an account? <a href="<?= $basePath ?>/login/" class="text-decoration-none">Log in here</a>.</p>
                                <p class="small text-muted mb-0">This sign-up now creates a local account and signs the user in immediately after registration.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>