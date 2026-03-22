<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../');
    exit;
}

include dirname(__DIR__) . '/includes/header.php';
?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-video-wrap" aria-hidden="true">
            <iframe
                src="https://www.youtube.com/embed/gqec9YvbnG8?autoplay=1&mute=1&loop=1&playlist=gqec9YvbnG8&controls=0&showinfo=0&modestbranding=1&playsinline=1&rel=0"
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
                            <a href="<?= $basePath ?>/products/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/calendars.png" class="img-fluid category-product-image" alt="Calendars" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Calendars</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= $basePath ?>/products/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/notebooks.png" class="img-fluid category-product-image" alt="Notebooks" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Notebooks</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= $basePath ?>/products/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/paper-bags.png" class="img-fluid category-product-image" alt="Paper Bags" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Paper Bags</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= $basePath ?>/products/business-card/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/business-cards.png" class="img-fluid category-product-image" alt="Business Cards" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Business Cards</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= $basePath ?>/products/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/envelopes.png" class="img-fluid category-product-image" alt="Envelopes" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Envelopes</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= $basePath ?>/products/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/folder-sets.png" class="img-fluid category-product-image" alt="Folder Sets" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Folder Sets</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= $basePath ?>/products/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/food-packing.png" class="img-fluid category-product-image" alt="Food Packaging" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Food Packaging</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?= $basePath ?>/products/" class="text-decoration-none text-reset d-block">
                                <div class="category-card">
                                    <div class="category-img">
                                        <img src="<?= $basePath ?>/img/products/marketing-materials.png" class="img-fluid category-product-image" alt="Marketing Materials" loading="lazy">
                                    </div>
                                    <div class="small fw-bold">Marketing Materials</div>
                                </div>
                            </a>
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
                    <img src="<?= $basePath ?>/img/membership/silver.png" class="img-fluid membership-tier-image rounded-circle mb-2 border border-2 border-white shadow" alt="Silver tier" loading="lazy">
                    <div class="small fw-bold">SILVER</div>
                </div>
                <div class="col-4 col-md-2">
                    <img src="<?= $basePath ?>/img/membership/gold.png" class="img-fluid membership-tier-image rounded-circle mb-2 border border-2 border-white shadow" alt="Gold tier" loading="lazy">
                    <div class="small fw-bold">GOLD</div>
                </div>
                <div class="col-4 col-md-2">
                    <img src="<?= $basePath ?>/img/membership/platinum.png" class="img-fluid membership-tier-image rounded-circle mb-2 border border-2 border-white shadow" alt="Platinum tier" loading="lazy">
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
                    <img src="<?= $basePath ?>/img/faqs.png" class="img-fluid faq-image" alt="FAQ" loading="lazy">
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
                        <img src="<?= $basePath ?>/img/blog/guides.png" class="card-img-top blog-image" alt="Guides" loading="lazy">
                        <div class="card-body">
                            <small class="text-primary">Guides</small>
                            <h6 class="fw-bold mt-2">Services & Features Update</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 text-start shadow-sm h-100">
                        <img src="<?= $basePath ?>/img/blog/shipping.png" class="card-img-top blog-image" alt="Shipping" loading="lazy">
                        <div class="card-body">
                            <small class="text-primary">Shipping</small>
                            <h6 class="fw-bold mt-2">Logistics Partners Worldwide</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 text-start shadow-sm h-100">
                        <img src="<?= $basePath ?>/img/blog/products.png" class="card-img-top blog-image" alt="Products" loading="lazy">
                        <div class="card-body">
                            <small class="text-primary">Products</small>
                            <h6 class="fw-bold mt-2">Comprehensive Signage Guide</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 text-start shadow-sm h-100">
                        <img src="<?= $basePath ?>/img/blog/trends.png" class="card-img-top blog-image" alt="Trends" loading="lazy">
                        <div class="card-body">
                            <small class="text-primary">Trends</small>
                            <h6 class="fw-bold mt-2">Marketing Material Success</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include dirname(__DIR__) . '/includes/footer.php'; ?>