<?php
$basePath = $basePath ?? '';
$pageTitle = $pageTitle ?? 'SilentPrint Admin';
$adminPage = $adminPage ?? 'dashboard';
$adminDisplayName = htmlspecialchars(authFullName($currentUser ?? null) ?: 'Admin');
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
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $basePath ?>/css/admin.css">
</head>
<body class="admin-shell">
    <div class="admin-layout">
        <aside class="admin-sidebar" aria-label="Admin sidebar">
            <div class="admin-sidebar__panel">
                <a class="admin-brand" href="<?= $basePath ?>/admin/">
                    <img src="<?= $basePath ?>/img/logo.png" class="site-logo" alt="SilentPrint Admin" loading="eager">
                    <span>
                        <span class="admin-brand__eyebrow">SilentPrint</span>
                        <span class="admin-brand__title">Admin Console</span>
                    </span>
                </a>

                <div class="admin-identity">
                    <span class="admin-identity__label">Signed in as</span>
                    <strong><?= $adminDisplayName ?></strong>
                </div>

                <nav class="admin-nav" aria-label="Admin navigation">
                    <a href="<?= $basePath ?>/admin/" class="admin-nav__link <?= $adminPage === 'dashboard' ? 'is-active' : '' ?>">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Overview</span>
                    </a>
                    <a href="<?= $basePath ?>/admin/users/" class="admin-nav__link <?= $adminPage === 'users' ? 'is-active' : '' ?>">
                        <i class="bi bi-people-fill"></i>
                        <span>Users</span>
                    </a>
                    <a href="<?= $basePath ?>/admin/security/" class="admin-nav__link <?= $adminPage === 'security' ? 'is-active' : '' ?>">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Security</span>
                    </a>
                    <a href="<?= $basePath ?>/admin/system/" class="admin-nav__link <?= $adminPage === 'system' ? 'is-active' : '' ?>">
                        <i class="bi bi-sliders"></i>
                        <span>System</span>
                    </a>
                </nav>

                <div class="admin-sidebar__actions">
                    <a href="<?= $basePath ?>/account/" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Account</a>
                    <a href="<?= $basePath ?>/" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Storefront</a>
                    <a href="<?= $basePath ?>/logout/" class="btn btn-primary btn-sm rounded-pill px-3">Log Out</a>
                </div>
            </div>
        </aside>

        <div class="admin-content">
            <?php if (!empty($flash['message'])): ?>
                <div class="container admin-flash">
            <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?> auth-alert mb-0" role="alert">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
                </div>
            <?php endif; ?>

            <main class="admin-main">