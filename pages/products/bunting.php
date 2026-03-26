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
                    <h2 class="fw-bold mb-3">Customize your bunting</h2>
                    <p class="text-muted mb-4">Live estimate is based on the standard bunting sizes and prices you listed.</p>
                    <form action="#" method="post">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="alert alert-info" id="buntingPriceDisplay" style="font-size:1.2em;">
                                    Total Price: <span id="buntingCalculatedPrice">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="buntingSize" class="form-label">Bunting Size</label>
                                <select class="form-select" id="buntingSize" name="buntingSize" required>
                                    <option value="">Select size</option>
                                    <option value="3.00">2 x 1 - RM3.00</option>
                                    <option value="6.00">2 x 2 - RM6.00</option>
                                    <option value="9.00">2 x 3 - RM9.00</option>
                                    <option value="12.00">2 x 4 - RM12.00</option>
                                    <option value="15.00">2 x 5 - RM15.00</option>
                                    <option value="18.00">2 x 6 - RM18.00</option>
                                    <option value="21.00">2 x 7 - RM21.00</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="buntingQuantity" class="form-label">Quantity</label>
                                <input type="number" min="1" step="1" value="1" class="form-control" id="buntingQuantity" name="buntingQuantity" required>
                            </div>
                            <div class="col-md-6">
                                <label for="buntingEnvironment" class="form-label">Display Environment</label>
                                <select class="form-select" id="buntingEnvironment" name="buntingEnvironment" required>
                                    <option value="">Select environment</option>
                                    <option value="indoor">Indoor</option>
                                    <option value="outdoor">Outdoor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="buntingUse" class="form-label">Primary Use</label>
                                <select class="form-select" id="buntingUse" name="buntingUse" required>
                                    <option value="">Select use case</option>
                                    <option value="promotion">Promotion</option>
                                    <option value="roadshow">Roadshow</option>
                                    <option value="wayfinding">Wayfinding</option>
                                    <option value="event">Event display</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="buntingDesignFile" class="form-label">Upload Design (optional)</label>
                                <input class="form-control" type="file" id="buntingDesignFile" name="buntingDesignFile" accept=".jpg,.jpeg,.png,.pdf">
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

<script>
function calculateBuntingPrice() {
    const sizePrice = Number(document.getElementById('buntingSize').value);
    const quantity = Number(document.getElementById('buntingQuantity').value);
    const environment = document.getElementById('buntingEnvironment').value;
    const useCase = document.getElementById('buntingUse').value;
    let price = '-';

    if (sizePrice > 0 && quantity > 0 && environment && useCase) {
        price = 'MYR ' + (sizePrice * quantity).toFixed(2);
    }

    document.getElementById('buntingCalculatedPrice').textContent = price;
}

document.getElementById('buntingSize').addEventListener('change', calculateBuntingPrice);
document.getElementById('buntingQuantity').addEventListener('input', calculateBuntingPrice);
document.getElementById('buntingEnvironment').addEventListener('change', calculateBuntingPrice);
document.getElementById('buntingUse').addEventListener('change', calculateBuntingPrice);

calculateBuntingPrice();
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>