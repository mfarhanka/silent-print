<?php
define('APP_BOOTSTRAPPED', true);

session_start();
require __DIR__ . '/includes/auth.php';

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
	'' => [
		'file' => __DIR__ . '/pages/index.php',
		'currentNav' => 'home',
	],
	'products' => [
		'file' => __DIR__ . '/pages/products/index.php',
		'currentNav' => 'products',
	],
	'products/business-card' => [
		'file' => __DIR__ . '/pages/products/business-card.php',
		'currentNav' => 'products',
	],
	'quote' => [
		'file' => __DIR__ . '/pages/quote.php',
	],
	'login' => [
		'file' => __DIR__ . '/pages/login.php',
	],
	'forgot-password' => [
		'file' => __DIR__ . '/pages/forgot-password.php',
	],
	'reset-password' => [
		'file' => __DIR__ . '/pages/reset-password.php',
	],
	'signup' => [
		'file' => __DIR__ . '/pages/signup.php',
	],
	'account' => [
		'file' => __DIR__ . '/pages/account.php',
	],
	'logout' => [
		'file' => __DIR__ . '/pages/logout.php',
	],
	'blog/services-features-update' => [
		'file' => __DIR__ . '/pages/blog/article.php',
		'article' => [
			'category' => 'Guides',
			'title' => 'Services & Features Update',
			'image' => '/img/blog/guides.png',
			'published' => 'March 2026',
			'intro' => 'SilentPrint has expanded its service flow to reduce approval time, simplify product discovery, and make repeat ordering easier for busy teams.',
			'sections' => [
				[
					'heading' => 'A faster path from idea to print',
					'body' => 'The product journey now prioritizes quick comparisons, clearer customization paths, and cleaner calls to action so customers can move from browsing to ordering without friction.',
				],
				[
					'heading' => 'Smarter category discovery',
					'body' => 'Popular products, feature sections, and category anchors now guide users toward the most common print decisions, helping first-time buyers find the right format sooner.',
				],
				[
					'heading' => 'Next focus',
					'body' => 'The next iteration will expand quote workflows and content pages so marketing teams can compare printing options before requesting production support.',
				],
			],
		],
	],
	'blog/logistics-partners-worldwide' => [
		'file' => __DIR__ . '/pages/blog/article.php',
		'article' => [
			'category' => 'Shipping',
			'title' => 'Logistics Partners Worldwide',
			'image' => '/img/blog/shipping.png',
			'published' => 'March 2026',
			'intro' => 'Reliable delivery matters as much as print quality, which is why SilentPrint coordinates fulfillment through logistics partners that can handle both local and regional volume.',
			'sections' => [
				[
					'heading' => 'Coverage built for business demand',
					'body' => 'Orders are planned around destination, lead time, and print type to reduce delays and keep shipment handling aligned with production requirements.',
				],
				[
					'heading' => 'Visibility across every stage',
					'body' => 'From confirmation to dispatch, customers need predictable updates. Clear tracking checkpoints help teams coordinate launches, events, and outlet replenishment.',
				],
				[
					'heading' => 'Why fulfillment planning matters',
					'body' => 'Strong logistics partnerships reduce handoff errors, improve deadline confidence, and support larger campaigns without adding operational complexity to the customer side.',
				],
			],
		],
	],
	'blog/comprehensive-signage-guide' => [
		'file' => __DIR__ . '/pages/blog/article.php',
		'article' => [
			'category' => 'Products',
			'title' => 'Comprehensive Signage Guide',
			'image' => '/img/blog/products.png',
			'published' => 'March 2026',
			'intro' => 'Signage works best when format, placement, and viewing distance are planned together. A strong signage brief avoids expensive reprints and weak visibility.',
			'sections' => [
				[
					'heading' => 'Start with context',
					'body' => 'Indoor and outdoor signage do different jobs. Material selection, color contrast, and finishing should match the environment where the design will actually be seen.',
				],
				[
					'heading' => 'Design for legibility first',
					'body' => 'Large headlines, disciplined spacing, and limited messaging usually outperform crowded layouts. Clarity creates better recall than trying to say everything at once.',
				],
				[
					'heading' => 'Build a production-ready file',
					'body' => 'Before printing, confirm dimensions, bleed, safe zones, and output intent. Production mistakes usually originate in the file stage, not on press.',
				],
			],
		],
	],
	'blog/marketing-material-success' => [
		'file' => __DIR__ . '/pages/blog/article.php',
		'article' => [
			'category' => 'Trends',
			'title' => 'Marketing Material Success',
			'image' => '/img/blog/trends.png',
			'published' => 'March 2026',
			'intro' => 'Good marketing materials are consistent, useful, and built for the actual moment of contact, whether that is in-store, event-based, or delivered by hand.',
			'sections' => [
				[
					'heading' => 'Consistency beats novelty',
					'body' => 'Campaign assets perform better when print pieces echo the same message, typography, and offer structure seen in digital channels and in-person presentations.',
				],
				[
					'heading' => 'Format shapes response',
					'body' => 'Brochures, flyers, inserts, and premium business cards all create different expectations. Matching the format to the sales context improves the chance of follow-up.',
				],
				[
					'heading' => 'Measure what happens next',
					'body' => 'The best print campaigns are tied to action: scans, calls, sign-ups, or visits. Success is easier to repeat when the material points to a measurable next step.',
				],
			],
		],
	],
];

if (!array_key_exists($normalizedPath, $routes)) {
	http_response_code(404);
	include __DIR__ . '/pages/404.php';
	exit;
}

$route = $routes[$normalizedPath];
$currentNav = $route['currentNav'] ?? '';
$article = $route['article'] ?? null;
$currentUser = authCurrentUser();
$flash = authPullFlash();

include $route['file'];