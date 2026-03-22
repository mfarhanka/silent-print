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

    const homeSectionIds = ['home', 'latest-features', 'process', 'packages'];
    const pageSections = homeSectionIds
        .map(function (id) {
            return document.getElementById(id);
        })
        .filter(Boolean);

    if (pageSections.length === homeSectionIds.length) {
        const menuLinks = Array.from(document.querySelectorAll('.nav-link'));
        const sectionLinkMap = new Map();

        homeSectionIds.forEach(function (id) {
            const matchingLink = menuLinks.find(function (link) {
                return link.hash === '#' + id;
            });

            if (matchingLink) {
                sectionLinkMap.set(id, matchingLink);
            }
        });

        const setActiveSection = function (activeId) {
            sectionLinkMap.forEach(function (link, id) {
                link.classList.toggle('is-active', id === activeId);
            });

            menuLinks.forEach(function (link) {
                if (!link.hash) {
                    link.classList.remove('is-active');
                }
            });
        };

        const updateActiveSection = function () {
            const offset = 140;
            let activeId = 'home';

            pageSections.forEach(function (section) {
                if (window.scrollY + offset >= section.offsetTop) {
                    activeId = section.id;
                }
            });

            setActiveSection(activeId);
        };

        updateActiveSection();
        document.addEventListener('scroll', updateActiveSection, { passive: true });
    }
});
