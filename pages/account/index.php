<?php
require_once dirname(__DIR__, 2) . '/includes/account-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/account-data.php';

$connection = accountDbConnection();
$summary = accountConsoleSummary($connection, $currentUser ?? []);

$pageTitle = 'Client Console | SilentPrint';
$accountPage = 'overview';

include dirname(__DIR__, 2) . '/includes/account-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <span class="content-meta mb-3">Client Overview</span>
                    <h1 class="fw-bold mb-2">Welcome, <?= htmlspecialchars($currentUser['first_name'] ?? 'Customer') ?>.</h1>
                    <p class="text-muted mb-0">Your client console keeps quote activity, account details, and next actions in one focused workspace.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= $basePath ?>/quote/" class="btn btn-primary rounded-pill px-4">Start New Quote</a>
                    <a href="<?= $basePath ?>/products/" class="btn btn-outline-primary rounded-pill px-4">Browse Products</a>
                </div>
            </div>
        </div>

        <div class="account-dashboard-grid mb-4">
            <article class="account-metric account-metric--featured">
                <div class="account-metric__label">Total quote requests</div>
                <div class="account-metric__value"><?= number_format($summary['totalQuotes']) ?></div>
                <p class="text-muted mb-0">All quote requests currently associated with <?= htmlspecialchars($currentUser['email'] ?? '') ?>.</p>
            </article>
            <article class="account-metric">
                <div class="account-metric__label">Active quotes</div>
                <div class="account-metric__value"><?= number_format($summary['activeQuotes']) ?></div>
                <p class="text-muted mb-0">Requests still moving through review, contact, or quoting.</p>
            </article>
            <article class="account-metric">
                <div class="account-metric__label">Won quotes</div>
                <div class="account-metric__value"><?= number_format($summary['wonQuotes']) ?></div>
                <p class="text-muted mb-0">Quotes already converted into confirmed work.</p>
            </article>
        </div>

        <div class="account-summary-grid">
            <div class="content-card shadow-none border-0 bg-light">
                <h5 class="fw-bold mb-3">Account summary</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">Full name</div>
                            <div class="fw-semibold"><?= htmlspecialchars(authFullName($currentUser)) ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">Email address</div>
                            <div class="fw-semibold"><?= htmlspecialchars($currentUser['email'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">Member since</div>
                            <div class="fw-semibold"><?= htmlspecialchars($summary['memberSince']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="account-panel-stat">
                            <div class="small text-muted mb-1">Quote storage</div>
                            <div class="fw-semibold"><?= $summary['quoteTableExists'] ? 'Connected' : 'Not provisioned' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card shadow-none border-0 bg-light">
                <h5 class="fw-bold mb-3">Quick actions</h5>
                <div class="d-grid gap-3">
                    <a href="<?= $basePath ?>/account/quotes/" class="btn btn-outline-primary rounded-pill">Open My Quotes</a>
                    <a href="<?= $basePath ?>/account/profile/" class="btn btn-outline-primary rounded-pill">Review Profile</a>
                    <?php if (authHasBackofficeAccess($currentUser)): ?>
                        <a href="<?= $basePath . authBackofficePath($currentUser) ?>" class="btn btn-dark rounded-pill">Open Management Console</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="content-card mt-4">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                <div>
                    <span class="content-meta mb-3">Recent Quote Activity</span>
                    <h5 class="fw-bold mb-2">Latest requests</h5>
                    <p class="text-muted mb-0">A quick view of the most recent quote records tied to your account.</p>
                </div>
                <a href="<?= $basePath ?>/account/quotes/" class="btn btn-outline-primary rounded-pill">View Full Quote List</a>
            </div>

            <?php if ($summary['recentQuotes'] === []): ?>
                <div class="account-panel-stat">
                    <div class="fw-semibold">No quote requests yet</div>
                    <div class="small text-muted">Use the quote page to start your first request. Once submissions are connected, they will appear here automatically.</div>
                </div>
            <?php else: ?>
                <div class="account-access-list">
                    <?php foreach ($summary['recentQuotes'] as $quote): ?>
                        <?php $quoteStatus = strtolower((string) ($quote['status'] ?? 'new')); ?>
                        <div class="account-access-row">
                            <div>
                                <div class="fw-semibold"><?= htmlspecialchars($quote['product_name'] ?? 'Unspecified quote') ?></div>
                                <div class="small text-muted">
                                    Submitted <?= htmlspecialchars(date('d M Y, H:i', strtotime($quote['created_at'] ?? 'now'))) ?>
                                    <?php if (!empty($quote['quantity'])): ?>
                                        • Qty <?= number_format((int) $quote['quantity']) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="account-badge <?= accountQuoteBadgeClass($quoteStatus) ?>"><?= htmlspecialchars(accountQuoteLabel($quoteStatus)) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/account-footer.php'; ?>