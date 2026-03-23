<?php
require_once dirname(__DIR__, 2) . '/includes/admin-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/admin-data.php';

$connection = adminDbConnection();
$quoteStatus = adminQuoteStatus($connection, $basePath);
$newQuotes = $quoteStatus['quoteTableExists'] ? adminQuoteCountByStatus($connection, 'new') : 0;
$activeQuotes = $quoteStatus['quoteTableExists'] ? adminQuoteActiveCount($connection) : 0;
$wonQuotes = $quoteStatus['quoteTableExists'] ? adminQuoteCountByStatus($connection, 'won') : 0;
$recentQuotes = $quoteStatus['quoteTableExists'] ? adminRecentQuotes($connection, 20) : [];

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
                        <div class="admin-stat-label">Total quotes</div>
                        <div class="admin-stat-value"><?= number_format($quoteStatus['totalQuotes']) ?></div>
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
                        <div class="admin-stat-label">New quotes</div>
                        <div class="admin-stat-value"><?= number_format($newQuotes) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-inbox-fill"></i></div>
                </div>
                <p class="text-muted mb-0">Requests that still need the first response or triage step.</p>
            </article>

            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Active pipeline</div>
                        <div class="admin-stat-value"><?= number_format($activeQuotes) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-arrow-repeat"></i></div>
                </div>
                <p class="text-muted mb-0">Quotes currently in progress across new, contacted, and quoted states.</p>
            </article>

            <article class="admin-stat-card">
                <div class="admin-stat-head">
                    <div>
                        <div class="admin-stat-label">Won quotes</div>
                        <div class="admin-stat-value"><?= number_format($wonQuotes) ?></div>
                    </div>
                    <div class="admin-stat-icon"><i class="bi bi-trophy-fill"></i></div>
                </div>
                <p class="text-muted mb-0">Quotes that have already converted and can be handed to fulfillment.</p>
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
                    <div class="admin-system-row">
                        <span class="text-muted">Stored quote records</span>
                        <strong><?= number_format($quoteStatus['totalQuotes']) ?></strong>
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
                        <div class="fw-semibold mb-1">2. Add assignment and response ownership</div>
                        <div class="small text-muted">Once intake is connected, extend the quotes table with assignee and workflow notes for daily operations.</div>
                    </div>
                    <div class="account-stat">
                        <div class="fw-semibold mb-1">3. Track operational workflow</div>
                        <div class="small text-muted">Once quotes exist, add statuses such as new, contacted, quoted, won, and archived.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card mt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <span class="content-meta mb-3">Quote Queue</span>
                    <h5 class="fw-bold mb-2">Recent quote records</h5>
                    <p class="text-muted mb-0">Operational view of the latest quote submissions stored in the database.</p>
                </div>
                <div class="admin-note">
                    <strong><?= number_format(count($recentQuotes)) ?></strong> rows shown
                </div>
            </div>

            <?php if ($recentQuotes === []): ?>
                <div class="account-stat">
                    <div class="fw-semibold">No quotes stored yet</div>
                    <div class="small text-muted">The quotes table is ready, but the public quote page still needs submission handling before records will appear here.</div>
                </div>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Request</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Company</th>
                                <th scope="col">Status</th>
                                <th scope="col">Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentQuotes as $quote): ?>
                                <?php $quoteStatusValue = strtolower((string) ($quote['status'] ?? 'new')); ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($quote['product_name'] ?? 'Unspecified quote') ?></div>
                                        <div class="small text-muted">
                                            <?= htmlspecialchars($quote['full_name'] ?? 'Unknown requester') ?>
                                            <?php if (!empty($quote['quantity'])): ?>
                                                • Qty <?= number_format((int) $quote['quantity']) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div><?= htmlspecialchars($quote['email'] ?? '') ?></div>
                                        <?php if (!empty($quote['phone'])): ?>
                                            <div class="small text-muted"><?= htmlspecialchars($quote['phone']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($quote['company'] ?? 'Independent / not provided') ?></td>
                                    <td>
                                        <span class="admin-badge <?= adminQuoteBadgeClass($quoteStatusValue) ?>">
                                            <?= htmlspecialchars(adminQuoteLabel($quoteStatusValue)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div><?= htmlspecialchars(date('d M Y, H:i', strtotime($quote['created_at'] ?? 'now'))) ?></div>
                                        <div class="small text-muted">Source: <?= htmlspecialchars($quote['source'] ?? 'web') ?></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="content-card mt-4">
            <span class="content-meta mb-3">Next Action</span>
            <h5 class="fw-bold mb-2">What should happen next</h5>
            <p class="text-muted mb-0"><?= htmlspecialchars($quoteStatus['nextAction']) ?></p>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>