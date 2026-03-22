<div class="collapse navbar-collapse order-lg-0" id="navbarNav">
    <ul class="navbar-nav small">
        <li class="nav-item"><a class="nav-link <?= ($currentNav ?? '') === 'home' ? 'is-active' : '' ?>" href="<?= $basePath ?>/">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= ($currentNav ?? '') === 'products' ? 'is-active' : '' ?>" href="<?= $basePath ?>/products/">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Latest Features</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Packages</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Process</a></li>
    </ul>
</div>