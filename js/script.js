document.addEventListener('DOMContentLoaded', function () {
    // Replace broken image URLs with a local placeholder.
    const fallbackSrc = 'img/placeholder.svg';

    document.querySelectorAll('img').forEach(function (img) {
        img.addEventListener('error', function () {
            if (img.dataset.fallbackApplied === 'true') {
                return;
            }

            img.dataset.fallbackApplied = 'true';
            img.src = fallbackSrc;
            img.alt = img.alt || 'Placeholder image';
        });
    });
});
