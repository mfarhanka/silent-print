<?php
define('APP_BOOTSTRAPPED', true);

$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($basePath === '/' || $basePath === '\\') {
	$basePath = '';
}

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (!is_string($requestPath) || $requestPath === '') {
	$requestPath = '/';
}

if ($basePath !== '' && str_starts_with($requestPath, $basePath)) {
	$requestPath = substr($requestPath, strlen($basePath));
}

$normalizedPath = trim($requestPath, '/');

$redirects = [
	'index.php' => '/',
	'products.php' => '/products/',
	'business-card.php' => '/products/business-card/',
	'pages' => '/',
	'pages/' => '/',
	'pages/index.php' => '/',
	'pages/products' => '/products/',
	'pages/products/' => '/products/',
	'pages/products/index.php' => '/products/',
	'pages/products/business-card' => '/products/business-card/',
	'pages/products/business-card.php' => '/products/business-card/',
];

if (array_key_exists($normalizedPath, $redirects)) {
	header('Location: ' . $basePath . $redirects[$normalizedPath], true, 301);
	exit;
}

$routes = [
	'' => __DIR__ . '/pages/index.php',
	'products' => __DIR__ . '/pages/products/index.php',
	'products/business-card' => __DIR__ . '/pages/products/business-card.php',
];

if (!array_key_exists($normalizedPath, $routes)) {
	http_response_code(404);
	include __DIR__ . '/pages/404.php';
	exit;
}

include $routes[$normalizedPath];