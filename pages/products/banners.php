<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../../products/banners/');
    exit;
}

$pageTitle = 'Custom Banners | SilentPrint';

include dirname(__DIR__, 2) . '/includes/header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <span class="content-meta mb-3">Large Format Print</span>
                    <h1 class="fw-bold mb-3">Custom banners built for launches, events, and storefront visibility.</h1>
                    <p class="text-muted mb-4">Order promotional banners for indoor and outdoor use with the right size, finishing, and installation style for your campaign.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?= $basePath ?>/quote/" class="btn btn-primary rounded-pill px-4">Request a Quote</a>
                        <a href="<?= $basePath ?>/products/" class="btn btn-outline-primary rounded-pill px-4">Back to Catalog</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="<?= $basePath ?>/img/products/banners.png" class="article-image" alt="Custom banners by SilentPrint">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="content-card h-100">
                    <h2 class="fw-bold mb-3">Banner options</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">PVC banners</div>
                                <div class="small text-muted">Durable material for storefront promotions, roadside visibility, and repeated campaign use.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">Mesh banners</div>
                                <div class="small text-muted">Better airflow for outdoor installs where wind load matters.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">Roll-up displays</div>
                                <div class="small text-muted">Portable event signage for booths, retail campaigns, and presentations.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">Custom finishing</div>
                                <div class="small text-muted">Eyelets, pole pockets, hemming, and mounting-ready production support.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="content-card h-100">
                    <h3 class="fw-bold h5 mb-3">Before requesting a quote</h3>
                    <div class="quote-checklist">
                        <div class="quote-checklist-item">
                            <i class="bi bi-bounding-box"></i>
                            <div>
                                <div class="fw-semibold">Size and orientation</div>
                                <div class="small text-muted">Share width, height, and whether the banner is landscape or portrait.</div>
                            </div>
                        </div>
                        <div class="quote-checklist-item">
                            <i class="bi bi-cloud-sun"></i>
                            <div>
                                <div class="fw-semibold">Display environment</div>
                                <div class="small text-muted">Tell us if the banner is for indoor, outdoor, short-term, or permanent use.</div>
                            </div>
                        </div>
                        <div class="quote-checklist-item">
                            <i class="bi bi-tools"></i>
                            <div>
                                <div class="fw-semibold">Finishing requirements</div>
                                <div class="small text-muted">Include eyelets, hemming, stands, or hanging method if already decided.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>