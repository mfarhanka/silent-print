<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../admin/');
    exit;
}

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/database.php';

authRequireAdmin($currentUser ?? null, $basePath);
