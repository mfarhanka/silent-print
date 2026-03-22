<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../login/');
    exit;
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
                                <h2 class="fw-bold mb-2">Log In</h2>
                                <p class="text-muted mb-4">Enter your email and password to access your account.</p>
                                <form action="#" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control auth-input" id="email" name="email" placeholder="name@company.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="password" class="form-label mb-0">Password</label>
                                            <a href="<?= $basePath ?>/quote/" class="small text-decoration-none">Need help?</a>
                                        </div>
                                        <input type="password" class="form-control auth-input" id="password" name="password" placeholder="Enter your password" required>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <a href="<?= $basePath ?>/quote/" class="small text-decoration-none">Forgot password?</a>
                                    </div>
                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-primary rounded-pill py-2">Continue</button>
                                        <button type="button" class="btn btn-outline-secondary rounded-pill py-2">Continue with Google</button>
                                    </div>
                                </form>
                                <p class="small text-muted mt-4 mb-0">This is currently a front-end login page. If you want, the next step is to connect it to a real PHP session-based authentication flow.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>