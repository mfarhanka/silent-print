<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../../products/banners/');
    exit;
}

require_once dirname(__DIR__, 2) . '/includes/database.php';

$bannerOrderError = '';
$bannerForm = [
    'full_name' => trim((string) authFullName($currentUser ?? null)),
    'email' => trim((string) ($currentUser['email'] ?? '')),
    'phone' => '',
    'company' => '',
    'material' => 'tarpaulin380',
    'quantity' => '1',
    'width' => '',
    'height' => '',
    'finishing' => '',
    'environment' => '',
    'needed_by' => '',
    'notes' => '',
    'estimated_total' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bannerForm['full_name'] = trim((string) ($_POST['full_name'] ?? $bannerForm['full_name']));
    $bannerForm['email'] = trim((string) ($_POST['email'] ?? $bannerForm['email']));
    $bannerForm['phone'] = trim((string) ($_POST['phone'] ?? ''));
    $bannerForm['company'] = trim((string) ($_POST['company'] ?? ''));
    $bannerForm['material'] = trim((string) ($_POST['bannerMaterial'] ?? ''));
    $bannerForm['quantity'] = trim((string) ($_POST['bannerQuantity'] ?? '1'));
    $bannerForm['width'] = trim((string) ($_POST['bannerWidth'] ?? ''));
    $bannerForm['height'] = trim((string) ($_POST['bannerHeight'] ?? ''));
    $bannerForm['finishing'] = trim((string) ($_POST['bannerFinishing'] ?? ''));
    $bannerForm['environment'] = trim((string) ($_POST['bannerEnvironment'] ?? ''));
    $bannerForm['needed_by'] = trim((string) ($_POST['needed_by'] ?? ''));
    $bannerForm['notes'] = trim((string) ($_POST['notes'] ?? ''));
    $bannerForm['estimated_total'] = trim((string) ($_POST['estimated_total'] ?? ''));
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!authVerifyCsrfToken($csrfToken)) {
        $bannerOrderError = 'Your session expired. Please refresh and try again.';
    } elseif ($bannerForm['full_name'] === '' || $bannerForm['email'] === '') {
        $bannerOrderError = 'Full name and email are required so staff can follow up.';
    } elseif (!filter_var($bannerForm['email'], FILTER_VALIDATE_EMAIL)) {
        $bannerOrderError = 'Please provide a valid email address.';
    } elseif ($bannerForm['material'] !== 'tarpaulin380') {
        $bannerOrderError = 'Please choose a valid banner material.';
    } elseif (!in_array($bannerForm['finishing'], ['eyeletOnly', 'eyeletRope', 'cutToSize', 'ropeOnly', 'foldingEdges'], true)) {
        $bannerOrderError = 'Please choose a valid finishing option.';
    } elseif (!in_array($bannerForm['environment'], ['indoor', 'outdoor'], true)) {
        $bannerOrderError = 'Please choose where the banner will be displayed.';
    } elseif ((int) $bannerForm['quantity'] < 1 || (float) $bannerForm['width'] <= 0 || (float) $bannerForm['height'] <= 0) {
        $bannerOrderError = 'Quantity, width, and height must be greater than zero.';
    } else {
        $specificationParts = [
            'Material: Tarpaulin 380gsm',
            'Size: ' . $bannerForm['width'] . ' kaki x ' . $bannerForm['height'] . ' kaki',
            'Finishing: ' . str_replace(['eyeletOnly', 'eyeletRope', 'cutToSize', 'ropeOnly', 'foldingEdges'], ['Eyelet only', 'Eyelet + rope', 'Cut to size', 'Rope only', 'Folding edges'], $bannerForm['finishing']),
            'Environment: ' . ucfirst($bannerForm['environment']),
        ];

        if ($bannerForm['estimated_total'] !== '') {
            $specificationParts[] = 'Estimated total: ' . $bannerForm['estimated_total'];
        }

        if ($bannerForm['notes'] !== '') {
            $specificationParts[] = 'Notes: ' . $bannerForm['notes'];
        }

        dbCreateQuote(dbConnection(), [
            'full_name' => $bannerForm['full_name'],
            'email' => $bannerForm['email'],
            'phone' => $bannerForm['phone'],
            'company' => $bannerForm['company'],
            'product_name' => 'Banner Order',
            'quantity' => (int) $bannerForm['quantity'],
            'specifications' => implode(' | ', $specificationParts),
            'needed_by' => $bannerForm['needed_by'],
            'status' => 'new',
            'source' => 'banner-order',
        ]);

        authFlash('success', 'Your banner order has been sent to staff for review.');
        if (!empty($currentUser)) {
            authRedirect($basePath, '/account/quotes/');
        }

        authRedirect($basePath, '/products/banners/');
    }
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

<div class="bunting-floating-total" id="bannerFloatingTotal" aria-hidden="true">
    <div class="container">
        <div class="alert alert-info bunting-floating-total__alert mb-0" style="font-size:1.2em;">
            Total Price: <span id="bannerCalculatedPriceFloating">-</span>
        </div>
    </div>
</div>

<section class="pb-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="content-card h-100">
                    <h2 class="fw-bold mb-3">Customize your banner</h2>
                    <p class="text-muted mb-4">Live estimate is based on Tarpaulin 380gsm at RM1.50 per square kaki.</p>
                    <?php if ($bannerOrderError !== ''): ?>
                        <div class="alert alert-danger auth-alert" role="alert"><?= htmlspecialchars($bannerOrderError) ?></div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(authCsrfToken()) ?>">
                        <input type="hidden" id="bannerEstimatedTotalInput" name="estimated_total" value="<?= htmlspecialchars($bannerForm['estimated_total']) ?>">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="alert alert-info bunting-price-sticky" id="bannerPriceDisplay" style="font-size:1.2em;">
                                    Total Price: <span id="bannerCalculatedPrice">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($bannerForm['full_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($bannerForm['email']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($bannerForm['phone']) ?>" placeholder="Optional contact number">
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="company" name="company" value="<?= htmlspecialchars($bannerForm['company']) ?>" placeholder="Optional company name">
                            </div>
                            <div class="col-md-6">
                                <label for="bannerMaterial" class="form-label">Material Type</label>
                                <select class="form-select" id="bannerMaterial" name="bannerMaterial" required>
                                    <option value="">Select material</option>
                                    <option value="tarpaulin380" <?= $bannerForm['material'] === 'tarpaulin380' ? 'selected' : '' ?>>Tarpaulin 380gsm (RM1.50 per sq kaki)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerQuantity" class="form-label">Quantity</label>
                                <input type="number" min="1" step="1" value="<?= htmlspecialchars($bannerForm['quantity']) ?>" class="form-control" id="bannerQuantity" name="bannerQuantity" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerWidth" class="form-label">Width (kaki)</label>
                                <input type="number" min="1" step="0.1" class="form-control" id="bannerWidth" name="bannerWidth" placeholder="e.g. 4" value="<?= htmlspecialchars($bannerForm['width']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerHeight" class="form-label">Height (kaki)</label>
                                <input type="number" min="1" step="0.1" class="form-control" id="bannerHeight" name="bannerHeight" placeholder="e.g. 2" value="<?= htmlspecialchars($bannerForm['height']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerFinishing" class="form-label">Finishing</label>
                                <select class="form-select" id="bannerFinishing" name="bannerFinishing" required>
                                    <option value="">Select finishing</option>
                                    <option value="eyeletOnly" <?= $bannerForm['finishing'] === 'eyeletOnly' ? 'selected' : '' ?>>Eyelet only</option>
                                    <option value="eyeletRope" <?= $bannerForm['finishing'] === 'eyeletRope' ? 'selected' : '' ?>>Eyelet + rope</option>
                                    <option value="cutToSize" <?= $bannerForm['finishing'] === 'cutToSize' ? 'selected' : '' ?>>Cut to size</option>
                                    <option value="ropeOnly" <?= $bannerForm['finishing'] === 'ropeOnly' ? 'selected' : '' ?>>Rope only</option>
                                    <option value="foldingEdges" <?= $bannerForm['finishing'] === 'foldingEdges' ? 'selected' : '' ?>>Folding edges</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="bannerEnvironment" class="form-label">Display Environment</label>
                                <select class="form-select" id="bannerEnvironment" name="bannerEnvironment" required>
                                    <option value="">Select environment</option>
                                    <option value="indoor" <?= $bannerForm['environment'] === 'indoor' ? 'selected' : '' ?>>Indoor</option>
                                    <option value="outdoor" <?= $bannerForm['environment'] === 'outdoor' ? 'selected' : '' ?>>Outdoor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="needed_by" class="form-label">Needed By</label>
                                <input type="date" class="form-control" id="needed_by" name="needed_by" value="<?= htmlspecialchars($bannerForm['needed_by']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="1" placeholder="Installation or delivery notes"><?= htmlspecialchars($bannerForm['notes']) ?></textarea>
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
    document.getElementById('bannerCalculatedPriceFloating').textContent = price;
    document.getElementById('bannerEstimatedTotalInput').value = price === '-' ? '' : price;
}

function toggleFloatingBannerPrice() {
    const inlinePrice = document.getElementById('bannerPriceDisplay');
    const floatingBar = document.getElementById('bannerFloatingTotal');

    if (!inlinePrice || !floatingBar) {
        return;
    }

    const inlinePriceTop = inlinePrice.getBoundingClientRect().top;
    if (inlinePriceTop <= 96) {
        floatingBar.classList.add('is-visible');
        floatingBar.setAttribute('aria-hidden', 'false');
    } else {
        floatingBar.classList.remove('is-visible');
        floatingBar.setAttribute('aria-hidden', 'true');
    }
}

document.getElementById('bannerMaterial').addEventListener('change', calculateBannerPrice);
document.getElementById('bannerQuantity').addEventListener('input', calculateBannerPrice);
document.getElementById('bannerWidth').addEventListener('input', calculateBannerPrice);
document.getElementById('bannerHeight').addEventListener('input', calculateBannerPrice);
document.getElementById('bannerFinishing').addEventListener('change', calculateBannerPrice);
document.getElementById('bannerEnvironment').addEventListener('change', calculateBannerPrice);

window.addEventListener('scroll', toggleFloatingBannerPrice, { passive: true });
window.addEventListener('resize', toggleFloatingBannerPrice);

calculateBannerPrice();
toggleFloatingBannerPrice();
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>