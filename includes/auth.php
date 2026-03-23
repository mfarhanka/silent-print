<?php

require_once __DIR__ . '/database.php';

function authNormalizeRole(string $role): string
{
    $normalizedRole = strtolower(trim($role));

    return in_array($normalizedRole, ['customer', 'staff', 'admin'], true) ? $normalizedRole : 'customer';
}

function authNormalizeEmail(string $email): string
{
    return strtolower(trim($email));
}

function authFindUserByEmail(string $email): ?array
{
    $normalizedEmail = authNormalizeEmail($email);
    $connection = dbConnection();
    $statement = $connection->prepare('SELECT first_name, last_name, email, password_hash, role, created_at FROM users WHERE email = ? LIMIT 1');
    $statement->bind_param('s', $normalizedEmail);
    $statement->execute();
    $result = $statement->get_result();
    $user = $result ? $result->fetch_assoc() : null;
    $statement->close();

    return is_array($user) ? $user : null;
}

function authCurrentUser(): ?array
{
    if (empty($_SESSION['user_email'])) {
        return null;
    }

    return authFindUserByEmail($_SESSION['user_email']);
}

function authLoginUser(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_email'] = $user['email'];
}

function authLogoutUser(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

function authCreateUser(array $data): array
{
    $user = [
        'first_name' => trim($data['first_name']),
        'last_name' => trim($data['last_name']),
        'email' => authNormalizeEmail($data['email']),
        'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
        'role' => authNormalizeRole((string) ($data['role'] ?? 'customer')),
        'created_at' => date('c'),
    ];

    $connection = dbConnection();
    $statement = $connection->prepare('INSERT INTO users (first_name, last_name, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, ?, ?)');
    $createdAt = date('Y-m-d H:i:s', strtotime($user['created_at']));
    $statement->bind_param('ssssss', $user['first_name'], $user['last_name'], $user['email'], $user['password_hash'], $user['role'], $createdAt);
    $statement->execute();
    $statement->close();

    return $user;
}

function authUpdateUserRole(string $email, string $role): void
{
    $normalizedEmail = authNormalizeEmail($email);
    $normalizedRole = authNormalizeRole($role);
    $connection = dbConnection();
    $statement = $connection->prepare('UPDATE users SET role = ? WHERE email = ?');
    $statement->bind_param('ss', $normalizedRole, $normalizedEmail);
    $statement->execute();
    $statement->close();
}

function authUpdateUserPassword(string $email, string $password): void
{
    $normalizedEmail = authNormalizeEmail($email);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $connection = dbConnection();
    $statement = $connection->prepare('UPDATE users SET password_hash = ? WHERE email = ?');
    $statement->bind_param('ss', $passwordHash, $normalizedEmail);
    $statement->execute();
    $statement->close();
}

function authFullName(?array $user): string
{
    if (!$user) {
        return '';
    }

    return trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
}

function authAdminEmails(): array
{
    static $emails;

    if (is_array($emails)) {
        return $emails;
    }

    $configuredEmails = preg_split('/[;,\s]+/', (string) (getenv('SILENT_PRINT_ADMIN_EMAILS') ?: ''));
    $normalizedEmails = [];

    foreach ($configuredEmails as $configuredEmail) {
        $email = authNormalizeEmail((string) $configuredEmail);
        if ($email !== '') {
            $normalizedEmails[$email] = $email;
        }
    }

    if ($normalizedEmails !== []) {
        $emails = array_values($normalizedEmails);

        return $emails;
    }

    $connection = dbConnection();
    $result = $connection->query('SELECT email FROM users ORDER BY created_at ASC, id ASC LIMIT 1');
    $row = $result ? $result->fetch_assoc() : null;
    $fallbackEmail = authNormalizeEmail((string) ($row['email'] ?? ''));

    $emails = $fallbackEmail !== '' ? [$fallbackEmail] : [];

    return $emails;
}

function authUserRole(?array $user): string
{
    if (!$user || empty($user['email'])) {
        return 'guest';
    }

    $storedRole = authNormalizeRole((string) ($user['role'] ?? 'customer'));

    if ($storedRole !== 'customer') {
        return $storedRole;
    }

    return in_array(authNormalizeEmail((string) $user['email']), authAdminEmails(), true) ? 'admin' : 'customer';
}

function authIsAdmin(?array $user): bool
{
    return authUserRole($user) === 'admin';
}

function authIsStaff(?array $user): bool
{
    return authUserRole($user) === 'staff';
}

function authHasBackofficeAccess(?array $user): bool
{
    return in_array(authUserRole($user), ['admin', 'staff'], true);
}

function authBackofficePath(?array $user): string
{
    if (authIsAdmin($user)) {
        return '/admin/';
    }

    if (authIsStaff($user)) {
        return '/admin/quotes/';
    }

    return '/account/';
}

function authLoginDestination(?array $user): string
{
    if (authHasBackofficeAccess($user)) {
        return authBackofficePath($user);
    }

    return '/account/';
}

function authIsCustomer(?array $user): bool
{
    return authUserRole($user) === 'customer';
}

function authRoleLabel(?array $user): string
{
    return match (authUserRole($user)) {
        'admin' => 'Admin',
        'staff' => 'Staff',
        'customer' => 'Customer',
        default => 'Guest',
    };
}

function authCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function authVerifyCsrfToken(?string $token): bool
{
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if (!is_string($token) || $token === '' || !is_string($sessionToken) || $sessionToken === '') {
        return false;
    }

    return hash_equals($sessionToken, $token);
}

function authRedirect(string $basePath, string $path): void
{
    header('Location: ' . $basePath . $path);
    exit;
}

function authRequireGuest(?array $currentUser, string $basePath): void
{
    if (!empty($currentUser)) {
        authRedirect($basePath, authLoginDestination($currentUser));
    }
}

function authRequireGuestForBackoffice(?array $currentUser, string $basePath): void
{
    if (!empty($currentUser)) {
        authRedirect($basePath, authLoginDestination($currentUser));
    }
}

function authRequireUser(?array $currentUser, string $basePath): void
{
    if (empty($currentUser)) {
        authRedirect($basePath, '/login/');
    }
}

function authRequireAdmin(?array $currentUser, string $basePath): void
{
    authRequireUser($currentUser, $basePath);

    if (!authIsAdmin($currentUser)) {
        authFlash('danger', 'Admin access is restricted to approved accounts.');
        authRedirect($basePath, '/account/');
    }
}

function authRequireBackoffice(?array $currentUser, string $basePath): void
{
    if (empty($currentUser)) {
        authRedirect($basePath, '/admin/login/');
    }

    if (!authHasBackofficeAccess($currentUser)) {
        authFlash('danger', 'Backoffice access is restricted to admin and staff accounts.');
        authRedirect($basePath, '/account/');
    }
}

function authRequireAdminPrivileges(?array $currentUser, string $basePath): void
{
    authRequireBackoffice($currentUser, $basePath);

    if (!authIsAdmin($currentUser)) {
        authFlash('danger', 'Only admins can access that management section.');
        authRedirect($basePath, authBackofficePath($currentUser));
    }
}

function authPurgeExpiredPasswordResets(): void
{
    $connection = dbConnection();
    $connection->query("DELETE FROM password_resets WHERE expires_at <= NOW()");
}

function authCreatePasswordReset(string $email): string
{
    authPurgeExpiredPasswordResets();

    $normalizedEmail = authNormalizeEmail($email);
    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $connection = dbConnection();

    $deleteStatement = $connection->prepare('DELETE FROM password_resets WHERE email = ?');
    $deleteStatement->bind_param('s', $normalizedEmail);
    $deleteStatement->execute();
    $deleteStatement->close();

    $insertStatement = $connection->prepare('INSERT INTO password_resets (email, token_hash, created_at, expires_at) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 HOUR))');
    $insertStatement->bind_param('ss', $normalizedEmail, $tokenHash);
    $insertStatement->execute();
    $insertStatement->close();

    return $token;
}

function authFindPasswordReset(string $token): ?array
{
    authPurgeExpiredPasswordResets();
    $tokenHash = hash('sha256', $token);
    $connection = dbConnection();
    $statement = $connection->prepare('SELECT email, token_hash, created_at, expires_at FROM password_resets WHERE token_hash = ? LIMIT 1');
    $statement->bind_param('s', $tokenHash);
    $statement->execute();
    $result = $statement->get_result();
    $reset = $result ? $result->fetch_assoc() : null;
    $statement->close();

    return is_array($reset) ? $reset : null;
}

function authConsumePasswordReset(string $token, string $newPassword): bool
{
    $reset = authFindPasswordReset($token);
    if (!$reset) {
        return false;
    }

    authUpdateUserPassword($reset['email'], $newPassword);
    $tokenHash = hash('sha256', $token);
    $connection = dbConnection();
    $statement = $connection->prepare('DELETE FROM password_resets WHERE token_hash = ?');
    $statement->bind_param('s', $tokenHash);
    $statement->execute();
    $statement->close();

    return true;
}

function authFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function authPullFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return is_array($flash) ? $flash : null;
}