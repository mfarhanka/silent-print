document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    const toTop = document.getElementById('toTop');

    navLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);

            if (!target) {
                return;
            }

            event.preventDefault();
            const nav = document.querySelector('.navbar');
            const offset = nav ? nav.offsetHeight + 8 : 0;
            const targetTop = target.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top: targetTop, behavior: 'smooth' });
        });
    });

    if (toTop) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 350) {
                toTop.classList.add('show');
            } else {
                toTop.classList.remove('show');
            }
        });

        toTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
