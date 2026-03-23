<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../account/');
    exit;
}

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/database.php';

authRequireUser($currentUser ?? null, $basePath);
