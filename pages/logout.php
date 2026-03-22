<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';

authRequireUser($currentUser ?? null, $basePath);
authLogoutUser();
authRedirect($basePath, '/');