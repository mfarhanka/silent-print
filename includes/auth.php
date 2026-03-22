<?php

function authUsersFilePath(): string
{
    return dirname(__DIR__) . '/data/users.json';
}

function authEnsureUsersFile(): void
{
    $filePath = authUsersFilePath();
    authEnsureDataDirectory();

    if (!file_exists($filePath)) {
        file_put_contents($filePath, json_encode([], JSON_PRETTY_PRINT));
    }
}

function authEnsureDataDirectory(): void
{
    $directory = dirname(authUsersFilePath());

    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }
}

function authLoadUsers(): array
{
    authEnsureUsersFile();

    $content = file_get_contents(authUsersFilePath());
    if ($content === false || trim($content) === '') {
        return [];
    }

    $users = json_decode($content, true);
    return is_array($users) ? $users : [];
}

function authSaveUsers(array $users): void
{
    authEnsureUsersFile();
    file_put_contents(authUsersFilePath(), json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function authPasswordResetsFilePath(): string
{
    return dirname(__DIR__) . '/data/password_resets.json';
}

function authEnsurePasswordResetsFile(): void
{
    $filePath = authPasswordResetsFilePath();
    authEnsureDataDirectory();

    if (!file_exists($filePath)) {
        file_put_contents($filePath, json_encode([], JSON_PRETTY_PRINT));
    }
}

function authLoadPasswordResets(): array
{
    authEnsurePasswordResetsFile();

    $content = file_get_contents(authPasswordResetsFilePath());
    if ($content === false || trim($content) === '') {
        return [];
    }

    $resets = json_decode($content, true);
    return is_array($resets) ? $resets : [];
}

function authSavePasswordResets(array $resets): void
{
    authEnsurePasswordResetsFile();
    file_put_contents(authPasswordResetsFilePath(), json_encode(array_values($resets), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function authFindUserByEmail(string $email): ?array
{
    $normalizedEmail = strtolower(trim($email));

    foreach (authLoadUsers() as $user) {
        if (($user['email'] ?? '') === $normalizedEmail) {
            return $user;
        }
    }

    return null;
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
    $users = authLoadUsers();
    $user = [
        'first_name' => trim($data['first_name']),
        'last_name' => trim($data['last_name']),
        'email' => strtolower(trim($data['email'])),
        'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
        'created_at' => date('c'),
    ];

    $users[] = $user;
    authSaveUsers($users);

    return $user;
}

function authUpdateUserPassword(string $email, string $password): void
{
    $normalizedEmail = strtolower(trim($email));
    $users = authLoadUsers();

    foreach ($users as &$user) {
        if (($user['email'] ?? '') === $normalizedEmail) {
            $user['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            break;
        }
    }

    authSaveUsers($users);
}

function authFullName(?array $user): string
{
    if (!$user) {
        return '';
    }

    return trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
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
        authRedirect($basePath, '/account/');
    }
}

function authRequireUser(?array $currentUser, string $basePath): void
{
    if (empty($currentUser)) {
        authRedirect($basePath, '/login/');
    }
}

function authPurgeExpiredPasswordResets(): void
{
    $now = time();
    $resets = array_values(array_filter(authLoadPasswordResets(), function (array $reset) use ($now): bool {
        return strtotime($reset['expires_at'] ?? '') > $now;
    }));

    authSavePasswordResets($resets);
}

function authCreatePasswordReset(string $email): string
{
    authPurgeExpiredPasswordResets();

    $normalizedEmail = strtolower(trim($email));
    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $resets = array_values(array_filter(authLoadPasswordResets(), function (array $reset) use ($normalizedEmail): bool {
        return ($reset['email'] ?? '') !== $normalizedEmail;
    }));

    $resets[] = [
        'email' => $normalizedEmail,
        'token_hash' => $tokenHash,
        'created_at' => date('c'),
        'expires_at' => date('c', time() + 3600),
    ];

    authSavePasswordResets($resets);

    return $token;
}

function authFindPasswordReset(string $token): ?array
{
    authPurgeExpiredPasswordResets();
    $tokenHash = hash('sha256', $token);

    foreach (authLoadPasswordResets() as $reset) {
        if (($reset['token_hash'] ?? '') === $tokenHash) {
            return $reset;
        }
    }

    return null;
}

function authConsumePasswordReset(string $token, string $newPassword): bool
{
    $reset = authFindPasswordReset($token);
    if (!$reset) {
        return false;
    }

    authUpdateUserPassword($reset['email'], $newPassword);
    $tokenHash = hash('sha256', $token);
    $resets = array_values(array_filter(authLoadPasswordResets(), function (array $entry) use ($tokenHash): bool {
        return ($entry['token_hash'] ?? '') !== $tokenHash;
    }));
    authSavePasswordResets($resets);

    return true;
}