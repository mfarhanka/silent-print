<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../account/');
    exit;
}

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/database.php';

authRequireUser($currentUser ?? null, $basePath);

if (authHasBackofficeAccess($currentUser ?? null)) {
    authFlash('info', 'Backoffice accounts use the management console instead of the client console.');
    authRedirect($basePath, authBackofficePath($currentUser ?? null));
}
