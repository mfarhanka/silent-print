<div class="collapse navbar-collapse order-lg-0" id="navbarNav">
    <ul class="navbar-nav small">
        <li class="nav-item"><a class="nav-link <?= ($currentNav ?? '') === 'home' ? 'is-active' : '' ?>" href="<?= $basePath ?>/#home">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= ($currentNav ?? '') === 'products' ? 'is-active' : '' ?>" href="<?= $basePath ?>/products/">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $basePath ?>/#latest-features">Latest Features</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $basePath ?>/#packages">Packages</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $basePath ?>/#process">Process</a></li>
    </ul>
</div>