<?php
$basePath = $basePath ?? '';
$pageTitle = $pageTitle ?? 'SilentPrint - Online Printing Marketplace';
$bodyClass = $bodyClass ?? '';
$extraStylesheets = is_array($extraStylesheets ?? null) ? $extraStylesheets : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- Favicon and App Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $basePath ?>/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $basePath ?>/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $basePath ?>/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="<?= $basePath ?>/favicon_io/site.webmanifest">
    <link rel="shortcut icon" href="<?= $basePath ?>/favicon_io/favicon.ico">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
    <?php foreach ($extraStylesheets as $extraStylesheet): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars((string) $extraStylesheet) ?>">
    <?php endforeach; ?>
</head>
<body<?= $bodyClass !== '' ? ' class="' . htmlspecialchars($bodyClass) . '"' : '' ?>>

    <!-- Header / Navbar -->
    <header class="sticky-top bg-white shadow-sm">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="<?= $basePath ?>/">
                    <img src="<?= $basePath ?>/img/logo.png" class="site-logo" alt="SilentPrint" loading="eager">
                </a>
                
                <div class="d-flex flex-grow-1 mx-lg-4 order-lg-1 order-3 mt-3 mt-lg-0">
                    <div class="input-group w-100">
                        <input type="text" class="form-control search-bar" placeholder="Search for products...">
                        <button class="btn btn-link text-secondary position-absolute end-0 z-3" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center order-lg-2 order-2 gap-3 ms-lg-3">
                    <div class="dropdown d-none d-md-block">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button">MYR</button>
                    </div>
                    <?php if (!empty($currentUser)): ?>
                        <?php if (authHasBackofficeAccess($currentUser)): ?>
                            <a href="<?= $basePath . authBackofficePath($currentUser) ?>" class="btn btn-light btn-sm rounded-pill px-3">Console</a>
                        <?php endif; ?>
                        <?php if (!authHasBackofficeAccess($currentUser)): ?>
                            <a href="<?= $basePath ?>/account/" class="btn btn-outline-primary btn-sm rounded-pill px-3"><?= htmlspecialchars(authFullName($currentUser) ?: 'My Account') ?></a>
                        <?php endif; ?>
                        <a href="<?= $basePath ?>/logout/" class="btn btn-primary btn-sm rounded-pill px-3">Log Out</a>
                    <?php else: ?>
                        <a href="<?= $basePath ?>/login/" class="btn btn-outline-primary btn-sm rounded-pill px-3">Log In</a>
                        <a href="<?= $basePath ?>/signup/" class="btn btn-primary btn-sm rounded-pill px-3">Sign Up</a>
                    <?php endif; ?>
                </div>

                <button class="navbar-toggler order-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php include __DIR__ . '/menu.php'; ?>
            </div>
        </nav>
    </header>

    <?php if (!empty($flash['message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info') ?> auth-alert mb-0" role="alert">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        </div>
    <?php endif; ?>