<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../');
    exit;
}

require_once dirname(__DIR__) . '/includes/auth.php';

authRequireUser($currentUser ?? null, $basePath);
$_SESSION = [];
session_regenerate_id(true);
authFlash('success', 'You have been logged out.');
authLogoutUser();
authRedirect($basePath, '/');