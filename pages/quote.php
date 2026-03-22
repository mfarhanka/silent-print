<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../quote/');
    exit;
}

include dirname(__DIR__) . '/includes/header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content-card">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <span class="content-meta mb-3">Custom Quote</span>
                            <h1 class="fw-bold mb-3">Request a quote for bulk or custom printing.</h1>
                            <p class="text-muted mb-4">Tell the team what you need, your volume, and your deadline. SilentPrint will review the scope and suggest the best production route for your job.</p>
                            <div class="quote-checklist mb-4">
                                <div class="quote-checklist-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <div>
                                        <div class="fw-semibold">Share your specs</div>
                                        <div class="text-muted small">Product type, size, quantity, finish, and delivery target.</div>
                                    </div>
                                </div>
                                <div class="quote-checklist-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <div>
                                        <div class="fw-semibold">Upload or describe artwork</div>
                                        <div class="text-muted small">Reference files, brand guidelines, or mockups help speed up review.</div>
                                    </div>
                                </div>
                                <div class="quote-checklist-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <div>
                                        <div class="fw-semibold">Get a tailored recommendation</div>
                                        <div class="text-muted small">The team can advise on materials, turnaround, and budget-fit options.</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= $basePath ?>/products/" class="btn btn-primary rounded-pill px-4">Explore Products First</a>
                        </div>
                        <div class="col-lg-6">
                            <div class="content-card h-100 shadow-none border-0 bg-light">
                                <h5 class="fw-bold mb-3">Quote request checklist</h5>
                                <ul class="text-muted ps-3 mb-0">
                                    <li class="mb-2">Product or campaign name</li>
                                    <li class="mb-2">Estimated quantity or monthly volume</li>
                                    <li class="mb-2">Preferred material and finishing</li>
                                    <li class="mb-2">Needed-by date and delivery location</li>
                                    <li class="mb-0">Any packaging or installation notes</li>
                                </ul>
                                <hr class="my-4">
                                <p class="small text-muted mb-0">For now this page is an information route. If you want, the next step is to add a real quote submission form and email handling.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>