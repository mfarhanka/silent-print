<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../../');
    exit;
}

if (!is_array($article ?? null)) {
    http_response_code(404);
    include dirname(__DIR__) . '/404.php';
    return;
}

include dirname(__DIR__, 2) . '/includes/header.php';
?>

<section class="content-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content-card">
                    <div class="mb-4">
                        <span class="content-meta mb-3"><?= htmlspecialchars($article['category']) ?> • <?= htmlspecialchars($article['published']) ?></span>
                        <h1 class="fw-bold mb-3"><?= htmlspecialchars($article['title']) ?></h1>
                        <p class="lead text-muted mb-0"><?= htmlspecialchars($article['intro']) ?></p>
                    </div>
                    <img src="<?= $basePath . htmlspecialchars($article['image']) ?>" class="article-image mb-4" alt="<?= htmlspecialchars($article['title']) ?>" loading="lazy">
                    <div class="row g-4">
                        <?php foreach ($article['sections'] as $section): ?>
                            <div class="col-md-4">
                                <div class="content-card h-100 shadow-none bg-light border-0">
                                    <h5 class="fw-bold mb-3"><?= htmlspecialchars($section['heading']) ?></h5>
                                    <p class="text-muted mb-0"><?= htmlspecialchars($section['body']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4 pt-4 border-top d-flex flex-wrap gap-3">
                        <a href="<?= $basePath ?>/" class="btn btn-outline-primary rounded-pill px-4">Back to Home</a>
                        <a href="<?= $basePath ?>/quote/" class="btn btn-primary rounded-pill px-4">Request a Quote</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>