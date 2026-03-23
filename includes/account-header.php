<?php
$basePath = $basePath ?? '';
$pageTitle = $pageTitle ?? 'SilentPrint Client Console';
$accountPage = $accountPage ?? 'overview';
$accountDisplayName = htmlspecialchars(authFullName($currentUser ?? null) ?: 'Customer');
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $basePath ?>/css/account.css">
</head>
<body class="account-shell">
    <div class="account-layout">
        <aside class="account-sidebar" aria-label="Client console sidebar">
            <div class="account-sidebar__panel">
                <a class="account-brand" href="<?= $basePath ?>/account/">
                    <img src="<?= $basePath ?>/img/logo.png" class="site-logo" alt="SilentPrint Client Console" loading="eager">
                    <span>
                        <span class="account-brand__eyebrow">SilentPrint</span>
                        <span class="account-brand__title">Client Console</span>
                    </span>
                </a>

                <div class="account-identity">
                    <span class="account-identity__label">Signed in as</span>
                    <strong><?= $accountDisplayName ?></strong>
                    <span class="small text-muted"><?= htmlspecialchars($currentUser['email'] ?? '') ?></span>
                </div>

                <nav class="account-nav" aria-label="Client navigation">
                    <a href="<?= $basePath ?>/account/" class="account-nav__link <?= $accountPage === 'overview' ? 'is-active' : '' ?>">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Overview</span>
                    </a>
                    <a href="<?= $basePath ?>/account/quotes/" class="account-nav__link <?= $accountPage === 'quotes' ? 'is-active' : '' ?>">
                        <i class="bi bi-journal-text"></i>
                        <span>My Quotes</span>
                    </a>
                    <a href="<?= $basePath ?>/account/profile/" class="account-nav__link <?= $accountPage === 'profile' ? 'is-active' : '' ?>">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Profile</span>
                    </a>
                </nav>

                <div class="account-sidebar__actions">
                    <?php if (authHasBackofficeAccess($currentUser ?? null)): ?>
                        <a href="<?= $basePath . authBackofficePath($currentUser ?? null) ?>" class="btn btn-dark btn-sm rounded-pill px-3">Open Console</a>
                    <?php endif; ?>
                    <a href="<?= $basePath ?>/products/" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Browse Products</a>
                    <a href="<?= $basePath ?>/quote/" class="btn btn-primary btn-sm rounded-pill px-3">Request Quote</a>
                    <a href="<?= $basePath ?>/logout/" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Log Out</a>
                </div>
            </div>
        </aside>

        <div class="account-content">
            <?php if (!empty($flash['message'])): ?>
                <div class="container account-flash">
                    <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?> account-alert mb-0" role="alert">
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                </div>
            <?php endif; ?>

            <main class="account-main">