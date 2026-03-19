<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SilentPrint - Online Printing Marketplace</title>
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
                <a class="navbar-brand fw-bold text-primary" href="#">SilentPrint</a>
                
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
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button">USD</button>
                    </div>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Log In</button>
                    <button class="btn btn-primary btn-sm rounded-pill px-3">Sign Up</button>
                </div>

                <button class="navbar-toggler order-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-lg-0" id="navbarNav">
                    <ul class="navbar-nav small">
                        <li class="nav-item"><a class="nav-link" href="#">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Latest Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Packages</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Process</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-video-wrap" aria-hidden="true">
            <iframe
                src="https://www.youtube.com/embed/R32fccQBTEo?autoplay=1&mute=1&loop=1&playlist=R32fccQBTEo&controls=0&showinfo=0&modestbranding=1&playsinline=1&rel=0"
                title="SilentPrint Banner Background Video"
                allow="autoplay; encrypted-media; picture-in-picture"
                referrerpolicy="strict-origin-when-cross-origin"
                tabindex="-1">
            </iframe>
        </div>
    </section>

    <!-- Quick Info Grid -->
    <section class="py-4 border-bottom">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-trophy h3 me-2 text-warning"></i>
                        <div class="text-start">
                            <div class="fw-bold small">Missions & Rewards</div>
                            <small class="text-muted">Join now</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-globe h3 me-2 text-info"></i>
                        <div class="text-start">
                            <div class="fw-bold small">Worldwide Delivery</div>
                            <small class="text-muted">Fast shipping</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-whatsapp h3 me-2 text-success"></i>
                        <div class="text-start">
                            <div class="fw-bold small">WhatsApp Channel</div>
                            <small class="text-muted">Stay updated</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-palette h3 me-2 text-primary"></i>
                        <div class="text-start">
                            <div class="fw-bold small">Sublimation Shirts</div>
                            <small class="text-muted">Explore styles</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card p-4 h-100 bg-light border-0">
                        <h5 class="fw-bold">Can't find what you want?</h5>
                        <p class="small text-muted">Specializing in custom orders for bulk printing. Contact our sales team for a custom quote.</p>
                        <button class="btn btn-primary rounded-pill btn-sm w-50">GET QUOTE</button>
                        <img src="https://via.placeholder.com/150x150/ffffff/000000?text=Help+Icon" class="mt-auto opacity-50" style="width: 100px;">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row g-3">
                        <!-- Product Item -->
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/calendars.png" class="img-fluid category-product-image" alt="Calendars" loading="lazy">
                                </div>
                                <div class="small fw-bold">Calendars</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/notebooks.png" class="img-fluid category-product-image" alt="Notebooks" loading="lazy">
                                </div>
                                <div class="small fw-bold">Notebooks</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/paper-bags.png" class="img-fluid category-product-image" alt="Paper Bags" loading="lazy">
                                </div>
                                <div class="small fw-bold">Paper Bags</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/business-cards.png" class="img-fluid category-product-image" alt="Business Cards" loading="lazy">
                                </div>
                                <div class="small fw-bold">Business Cards</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/envelopes.png" class="img-fluid category-product-image" alt="Envelopes" loading="lazy">
                                </div>
                                <div class="small fw-bold">Envelopes</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/folder-sets.png" class="img-fluid category-product-image" alt="Folder Sets" loading="lazy">
                                </div>
                                <div class="small fw-bold">Folder Sets</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/food-packing.png" class="img-fluid category-product-image" alt="Food Packaging" loading="lazy">
                                </div>
                                <div class="small fw-bold">Food Packaging</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="category-card">
                                <div class="category-img">
                                    <img src="img/products/marketing-materials.png" class="img-fluid category-product-image" alt="Marketing Materials" loading="lazy">
                                </div>
                                <div class="small fw-bold">Marketing Materials</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Member Privilege -->
    <section class="member-privilege text-center">
        <div class="container">
            <h2 class="fw-bold mb-4">MEMBER PRIVILEGE PLAN</h2>
            <div class="row justify-content-center g-4">
                <div class="col-4 col-md-2">
                    <img src="https://via.placeholder.com/80x80/silver/000?text=Silver" class="img-fluid rounded-circle mb-2 border border-2 border-white shadow">
                    <div class="small fw-bold">SILVER</div>
                </div>
                <div class="col-4 col-md-2">
                    <img src="https://via.placeholder.com/80x80/gold/000?text=Gold" class="img-fluid rounded-circle mb-2 border border-2 border-white shadow">
                    <div class="small fw-bold">GOLD</div>
                </div>
                <div class="col-4 col-md-2">
                    <img src="https://via.placeholder.com/80x80/platinum/000?text=Plat" class="img-fluid rounded-circle mb-2 border border-2 border-white shadow">
                    <div class="small fw-bold">PLATINUM</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <h6 class="text-center text-primary fw-bold">RATINGS & REVIEWS</h6>
            <div class="row g-4 mt-2">
                <div class="col-md-3 text-center d-flex flex-column justify-content-center">
                    <div class="display-4 fw-bold">4.74</div>
                    <div class="text-warning mb-2">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                    </div>
                    <div class="small text-muted">Trusted across Malaysia</div>
                </div>
                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="rating-box h-100">
                                <div class="text-warning small mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                                <h6 class="fw-bold small">EFFECTIVE AND KIND</h6>
                                <p class="small text-muted">"Great service and fast delivery. The quality of the printing was top notch!"</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rating-box h-100">
                                <div class="text-warning small mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                                <h6 class="fw-bold small">EXCELLENT SERVICE</h6>
                                <p class="small text-muted">"Easy to use platform and helpful support team."</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rating-box h-100">
                                <div class="text-warning small mb-2"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                                <h6 class="fw-bold small">EXCELLENT QUALITY</h6>
                                <p class="small text-muted">"Best printing marketplace I have used so far."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0 text-center">
                    <img src="https://via.placeholder.com/350x350/ffffff/000000?text=FAQ+Illustration" class="img-fluid" alt="FAQ">
                </div>
                <div class="col-lg-7">
                    <h2 class="fw-bold mb-4">GENERAL <span class="text-primary">FAQ</span></h2>
                    <div class="accordion accordion-flush" id="faqAccordion">
                        <div class="accordion-item bg-transparent">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-transparent fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#f1">
                                    How can I track my order?
                                </button>
                            </h2>
                            <div id="f1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">You can track your order status in your member dashboard under 'Order History'.</div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-transparent fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#f2">
                                    What are the payment methods?
                                </button>
                            </h2>
                            <div id="f2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">We accept online banking, credit/debit cards, and major e-wallets.</div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-transparent fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#f3">
                                    What is the standard delivery time?
                                </button>
                            </h2>
                            <div id="f3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">Standard processing takes 3-5 days plus courier shipping time.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="py-5">
        <div class="container text-center">
            <h6 class="text-primary fw-bold mb-4">BLOG</h6>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card border-0 text-start shadow-sm h-100">
                        <img src="https://via.placeholder.com/300x200?text=Laptop" class="card-img-top">
                        <div class="card-body">
                            <small class="text-primary">Guides</small>
                            <h6 class="fw-bold mt-2">Services & Features Update</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 text-start shadow-sm h-100">
                        <img src="https://via.placeholder.com/300x200?text=World" class="card-img-top">
                        <div class="card-body">
                            <small class="text-primary">Shipping</small>
                            <h6 class="fw-bold mt-2">Logistics Partners Worldwide</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 text-start shadow-sm h-100">
                        <img src="https://via.placeholder.com/300x200?text=Banner" class="card-img-top">
                        <div class="card-body">
                            <small class="text-primary">Products</small>
                            <h6 class="fw-bold mt-2">Comprehensive Signage Guide</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 text-start shadow-sm h-100">
                        <img src="https://via.placeholder.com/300x200?text=Marketing" class="card-img-top">
                        <div class="card-body">
                            <small class="text-primary">Trends</small>
                            <h6 class="fw-bold mt-2">Marketing Material Success</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Features -->
    <section class="footer-top">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-4 col-md-2"><i class="bi bi-truck h4"></i><div class="small mt-1">Free Delivery</div></div>
                <div class="col-4 col-md-2"><i class="bi bi-shield-check h4"></i><div class="small mt-1">Secure Payment</div></div>
                <div class="col-4 col-md-2"><i class="bi bi-clock h4"></i><div class="small mt-1">Quick Turnaround</div></div>
                <div class="col-4 col-md-2"><i class="bi bi-award h4"></i><div class="small mt-1">Best Price</div></div>
                <div class="col-4 col-md-2"><i class="bi bi-people h4"></i><div class="small mt-1">24/7 Support</div></div>
                <div class="col-4 col-md-2"><i class="bi bi-stars h4"></i><div class="small mt-1">Premium Quality</div></div>
            </div>
        </div>
    </section>

    <!-- Footer Main -->
    <footer class="footer-main">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-4">SILENTPRINT</h5>
                    <p class="small text-muted">SilentPrint is a leading online printing marketplace specializing in high-quality business and marketing materials.</p>
                    <div class="d-flex gap-3 h4 mt-4">
                        <i class="bi bi-facebook text-primary"></i>
                        <i class="bi bi-instagram text-danger"></i>
                        <i class="bi bi-youtube text-danger"></i>
                        <i class="bi bi-twitter-x"></i>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <h6 class="fw-bold mb-4">About SilentPrint</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2">Our Story</li>
                        <li class="mb-2">Member Rewards</li>
                        <li class="mb-2">Carrier Partner</li>
                        <li class="mb-2">Terms of Service</li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="fw-bold mb-4">Customer Care</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2">Contact Us</li>
                        <li class="mb-2">Track Shipping</li>
                        <li class="mb-2">Price Calculator</li>
                        <li class="mb-2">Complaints</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold mb-4">Stay Connected</h6>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email address">
                        <button class="btn btn-primary" type="button">Join</button>
                    </div>
                    <img src="https://via.placeholder.com/200x40/ffffff/000000?text=Payment+Methods" class="img-fluid opacity-75 mt-3">
                </div>
            </div>
            <hr class="my-5 opacity-10">
            <div class="text-center small text-muted">
                &copy; 2026 SilentPrint Corporation. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>