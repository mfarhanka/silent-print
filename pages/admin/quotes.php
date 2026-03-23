<?php
require_once dirname(__DIR__, 2) . '/includes/admin-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-data.php';

$connection = adminDbConnection();
$quoteStatus = adminQuoteStatus($connection, $basePath);

$pageTitle = 'Admin Quotes | SilentPrint';
$adminPage = 'quotes';

include dirname(__DIR__, 2) . '/includes/admin-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <span class="content-meta mb-3">Quote Operations</span>
                    <h1 class="fw-bold mb-2">Quote intake status</h1>
                    <p class="text-muted mb-0">This page tracks whether the public quote route is informational only or already backed by persistent quote submissions.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= htmlspecialchars($quoteStatus['publicRoute']) ?>" class="btn btn-outline-primary rounded-pill px-4">Open Public Quote Page</a>
                    <a href="<?= $basePath ?>/admin/system/" class="btn btn-primary rounded-pill px-4">System Context</a>
                </div>
            </div>
        </div>

        <div class="admin-stats-grid mb-4">
            <article class="admin-stat-card admin-stat-card-featured">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Submission mode</div>
                        <div class="admin-stat-value"><?= $quoteStatus['quoteTableExists'] ? 'Live' : 'Draft' ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-journal-check"></i></div>
                </div>
                <p class="text-muted mb-4"><?= htmlspecialchars($quoteStatus['submissionMode']) ?></p>
                <div class="admin-stat-footer">
                    <span class="admin-stat-chip"><?= htmlspecialchars($quoteStatus['storageMode']) ?></span>
                </div>
            </article>

            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Public route</div>
                        <div class="admin-stat-value"><?= $quoteStatus['quotePageExists'] ? 'Ready' : 'Missing' ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-globe2"></i></div>
                </div>
                <p class="text-muted mb-0">The public quote entry point currently resolves to <?= htmlspecialchars($quoteStatus['publicRoute']) ?>.</p>
            </article>

            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Storage</div>
                        <div class="admin-stat-value"><?= $quoteStatus['quoteTableExists'] ? 'Present' : 'None' ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-database-check"></i></div>
                </div>
                <p class="text-muted mb-0">Quote submissions <?= $quoteStatus['quoteTableExists'] ? 'can be persisted and reviewed.' : 'are not persisted yet because no quotes table exists.' ?></p>
            </article>
        </div>

        <div class="account-grid">
            <div class="content-card shadow-none border-0 bg-light">
                <h5 class="fw-bold mb-3">Current implementation state</h5>
                <div class="admin-system-list">
                    <div class="admin-system-row">
                        <span class="text-muted">Public quote page file</span>
                        <strong><?= $quoteStatus['quotePageExists'] ? 'Present' : 'Missing' ?></strong>
                    </div>
                    <div class="admin-system-row">
                        <span class="text-muted">Public route</span>
                        <strong><?= htmlspecialchars($quoteStatus['publicRoute']) ?></strong>
                    </div>
                    <div class="admin-system-row">
                        <span class="text-muted">Submission mode</span>
                        <strong><?= htmlspecialchars($quoteStatus['submissionMode']) ?></strong>
                    </div>
                    <div class="admin-system-row">
                        <span class="text-muted">Storage mode</span>
                        <strong><?= htmlspecialchars($quoteStatus['storageMode']) ?></strong>
                    </div>
                </div>
            </div>

            <div class="content-card shadow-none border-0 bg-light">
                <h5 class="fw-bold mb-3">Recommended build order</h5>
                <div class="d-grid gap-3">
                    <div class="account-stat">
                        <div class="fw-semibold mb-1">1. Capture real submissions</div>
                        <div class="small text-muted">Turn the public quote page into a working form with validation, CSRF protection, and persistence.</div>
                    </div>
                    <div class="account-stat">
                        <div class="fw-semibold mb-1">2. Add quote storage</div>
                        <div class="small text-muted">Introduce a MySQL quotes table so requests can be listed, assigned, and audited from admin.</div>
                    </div>
                    <div class="account-stat">
                        <div class="fw-semibold mb-1">3. Track operational workflow</div>
                        <div class="small text-muted">Once quotes exist, add statuses such as new, contacted, quoted, won, and archived.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card mt-4">
            <span class="content-meta mb-3">Next Action</span>
            <h5 class="fw-bold mb-2">What should happen next</h5>
            <p class="text-muted mb-0"><?= htmlspecialchars($quoteStatus['nextAction']) ?></p>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>