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
                    <h2 class="fw-bold mb-3">Customize your banner</h2>
                    <p class="text-muted mb-4">Live estimate is based on Tarpaulin 380gsm at RM1.50 per square kaki.</p>
                    <form action="#" method="post">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="alert alert-info" id="bannerPriceDisplay" style="font-size:1.2em;">
                                    Total Price: <span id="bannerCalculatedPrice">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerMaterial" class="form-label">Material Type</label>
                                <select class="form-select" id="bannerMaterial" name="bannerMaterial" required>
                                    <option value="">Select material</option>
                                    <option value="tarpaulin380" selected>Tarpaulin 380gsm (RM1.50 per sq kaki)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerQuantity" class="form-label">Quantity</label>
                                <input type="number" min="1" step="1" value="1" class="form-control" id="bannerQuantity" name="bannerQuantity" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerWidth" class="form-label">Width (kaki)</label>
                                <input type="number" min="1" step="0.1" class="form-control" id="bannerWidth" name="bannerWidth" placeholder="e.g. 4" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerHeight" class="form-label">Height (kaki)</label>
                                <input type="number" min="1" step="0.1" class="form-control" id="bannerHeight" name="bannerHeight" placeholder="e.g. 2" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerFinishing" class="form-label">Finishing</label>
                                <select class="form-select" id="bannerFinishing" name="bannerFinishing" required>
                                    <option value="">Select finishing</option>
                                    <option value="eyeletOnly">Eyelet only</option>
                                    <option value="eyeletRope">Eyelet + rope</option>
                                    <option value="cutToSize">Cut to size</option>
                                    <option value="ropeOnly">Rope only</option>
                                    <option value="foldingEdges">Folding edges</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerEnvironment" class="form-label">Display Environment</label>
                                <select class="form-select" id="bannerEnvironment" name="bannerEnvironment" required>
                                    <option value="">Select environment</option>
                                    <option value="indoor">Indoor</option>
                                    <option value="outdoor">Outdoor</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="bannerDesignFile" class="form-label">Upload Design (optional)</label>
                                <input class="form-control" type="file" id="bannerDesignFile" name="bannerDesignFile" accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">Submit Request</button>
                            </div>
                        </div>
                    </form>
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

<script>
const bannerRateTable = {
    tarpaulin380: 1.5
};

const bannerFinishingAdd = {
    eyeletOnly: 0,
    eyeletRope: 0,
    cutToSize: 0,
    ropeOnly: 0,
    foldingEdges: 0
};

function calculateBannerPrice() {
    const material = document.getElementById('bannerMaterial').value;
    const quantity = Number(document.getElementById('bannerQuantity').value);
    const width = Number(document.getElementById('bannerWidth').value);
    const height = Number(document.getElementById('bannerHeight').value);
    const finishing = document.getElementById('bannerFinishing').value;
    const environment = document.getElementById('bannerEnvironment').value;
    let price = '-';

    if (material && quantity > 0 && width > 0 && height > 0 && finishing && environment) {
        const rate = bannerRateTable[material] || 0;
        const areaPrice = width * height * rate;
        const total = (areaPrice + (bannerFinishingAdd[finishing] || 0)) * quantity;
        price = 'MYR ' + total.toFixed(2);
    }

    document.getElementById('bannerCalculatedPrice').textContent = price;
}

document.getElementById('bannerMaterial').addEventListener('change', calculateBannerPrice);
document.getElementById('bannerQuantity').addEventListener('input', calculateBannerPrice);
document.getElementById('bannerWidth').addEventListener('input', calculateBannerPrice);
document.getElementById('bannerHeight').addEventListener('input', calculateBannerPrice);
document.getElementById('bannerFinishing').addEventListener('change', calculateBannerPrice);
document.getElementById('bannerEnvironment').addEventListener('change', calculateBannerPrice);

calculateBannerPrice();
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>