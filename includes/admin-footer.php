            </main>

            <footer class="admin-footer">
                <div class="container admin-footer__inner">
                    <div>
                        <div class="admin-footer__title">SilentPrint Admin</div>
                        <div class="admin-footer__text">Operational dashboard for account activity, password reset traffic, and environment status.</div>
                    </div>
                    <div class="admin-footer__actions">
                        <a href="<?= $basePath . authBackofficePath($currentUser ?? null) ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Console Home</a>
                        <a href="<?= $basePath ?>/" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Open Storefront</a>
                    </div>
                </div>
            </footer>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>