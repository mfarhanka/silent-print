<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../../products/bunting/');
    exit;
}

$pageTitle = 'Custom Bunting | SilentPrint';

include dirname(__DIR__, 2) . '/includes/header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <span class="content-meta mb-3">Event Display Print</span>
                    <h1 class="fw-bold mb-3">Custom buntings for promotions, launches, and on-site wayfinding.</h1>
                    <p class="text-muted mb-4">Create vertical promotional buntings for retail campaigns, expo booths, storefront announcements, and event traffic flow.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?= $basePath ?>/quote/" class="btn btn-primary rounded-pill px-4">Request a Quote</a>
                        <a href="<?= $basePath ?>/products/" class="btn btn-outline-primary rounded-pill px-4">Back to Catalog</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="<?= $basePath ?>/img/products/buntings.png" class="article-image" alt="Custom bunting by SilentPrint">
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
                    <h2 class="fw-bold mb-3">Bunting applications</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">Retail promotions</div>
                                <div class="small text-muted">Use buntings to highlight store openings, promotions, and seasonal sales at high visibility points.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">Roadshows and booths</div>
                                <div class="small text-muted">Portable vertical signage that works well around exhibition spaces and event registration zones.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">Directional signage</div>
                                <div class="small text-muted">Guide visitors toward entrances, counters, launch areas, or campaign touchpoints.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="account-stat h-100">
                                <div class="fw-semibold mb-2">Custom production</div>
                                <div class="small text-muted">Specify size, finishing, and installation method based on where the bunting will be displayed.</div>
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
                            <i class="bi bi-arrows-vertical"></i>
                            <div>
                                <div class="fw-semibold">Final size</div>
                                <div class="small text-muted">Share the bunting width and height, plus whether you need a standard or custom ratio.</div>
                            </div>
                        </div>
                        <div class="quote-checklist-item">
                            <i class="bi bi-pin-map"></i>
                            <div>
                                <div class="fw-semibold">Display location</div>
                                <div class="small text-muted">Tell us if it will be used indoors, outdoors, roadside, or in a covered event space.</div>
                            </div>
                        </div>
                        <div class="quote-checklist-item">
                            <i class="bi bi-hammer"></i>
                            <div>
                                <div class="fw-semibold">Mounting method</div>
                                <div class="small text-muted">Include rope, pole, eyelet, or any installation preference if you already know it.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>