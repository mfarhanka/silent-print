<?php

function authUsersFilePath(): string
{
    return dirname(__DIR__) . '/data/users.json';
}

function authEnsureUsersFile(): void
{
    $filePath = authUsersFilePath();
    $directory = dirname($filePath);

    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }

    if (!file_exists($filePath)) {
        file_put_contents($filePath, json_encode([], JSON_PRETTY_PRINT));
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

function authFullName(?array $user): string
{
    if (!$user) {
        return '';
    }

    return trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
}