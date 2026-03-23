<?php
require_once dirname(__DIR__, 2) . '/includes/account-bootstrap.php';
require_once dirname(__DIR__, 2) . '/includes/account-data.php';

$connection = accountDbConnection();
$userEmail = authNormalizeEmail((string) ($currentUser['email'] ?? ''));
$quotes = accountRecentQuotes($connection, $userEmail, 20);
$quoteTableExists = accountQuoteTableExists($connection);

$pageTitle = 'My Quotes | SilentPrint';
$accountPage = 'quotes';

include dirname(__DIR__, 2) . '/includes/account-header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="content-card mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <span class="content-meta mb-3">Quote History</span>
                    <h1 class="fw-bold mb-2">My quotes</h1>
                    <p class="text-muted mb-0">Track the quote requests associated with your account email and monitor their current status.</p>
                </div>
                <a href="<?= $basePath ?>/quote/" class="btn btn-primary rounded-pill px-4">Request Another Quote</a>
            </div>
        </div>

        <div class="content-card">
            <?php if (!$quoteTableExists): ?>
                <div class="account-panel-stat">
                    <div class="fw-semibold">Quote tracking is not provisioned yet</div>
                    <div class="small text-muted">The client console is ready for quote history, but the quote storage table is not available in this environment.</div>
                </div>
            <?php elseif ($quotes === []): ?>
                <div class="account-panel-stat">
                    <div class="fw-semibold">No quote history yet</div>
                    <div class="small text-muted">Your account does not have any stored quote requests yet. Once public quote intake is connected, new requests will appear here.</div>
                </div>
            <?php else: ?>
                <div class="account-table-wrap">
                    <table class="table account-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Quote</th>
                                <th scope="col">Company</th>
                                <th scope="col">Needed by</th>
                                <th scope="col">Status</th>
                                <th scope="col">Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quotes as $quote): ?>
                                <?php $quoteStatus = strtolower((string) ($quote['status'] ?? 'new')); ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($quote['product_name'] ?? 'Unspecified quote') ?></div>
                                        <div class="small text-muted">
                                            <?= htmlspecialchars($quote['specifications'] ?? 'No additional specification provided.') ?>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($quote['company'] ?: 'Independent / not provided') ?></td>
                                    <td><?= !empty($quote['needed_by']) ? htmlspecialchars(date('d M Y', strtotime($quote['needed_by']))) : 'Flexible / not set' ?></td>
                                    <td>
                                        <span class="account-badge <?= accountQuoteBadgeClass($quoteStatus) ?>"><?= htmlspecialchars(accountQuoteLabel($quoteStatus)) ?></span>
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
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/account-footer.php'; ?>