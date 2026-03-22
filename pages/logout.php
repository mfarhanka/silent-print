<?php
if (!defined('APP_BOOTSTRAPPED')) {
    header('Location: ../');
    exit;
}

authLogoutUser();
header('Location: ' . $basePath . '/');
exit;