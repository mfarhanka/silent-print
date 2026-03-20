<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SilentPrint - Online Printing Marketplace</title>
    <!-- Favicon and App Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
    <link rel="manifest" href="favicon_io/site.webmanifest">
    <link rel="shortcut icon" href="favicon_io/favicon.ico">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Header / Navbar -->
    <header class="sticky-top bg-white shadow-sm">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
                    <img src="img/logo.png" class="site-logo" alt="SilentPrint" loading="eager">
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
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Log In</button>
                    <button class="btn btn-primary btn-sm rounded-pill px-3">Sign Up</button>
                </div>

                <button class="navbar-toggler order-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php include 'menu.php'; ?>
            </div>
        </nav>
    </header>
