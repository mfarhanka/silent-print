<?php

function adminDbConnection(): mysqli
{
    return dbConnection();
}

function adminDatabaseConfig(): array
{
    return dbConfig();
}

function adminTotalUsers(mysqli $connection): int
{
    return (int) (($connection->query('SELECT COUNT(*) AS total FROM users')->fetch_assoc()['total'] ?? 0));
}

function adminUsersThisWeek(mysqli $connection): int
{
    return (int) (($connection->query("SELECT COUNT(*) AS total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['total'] ?? 0));
}

function adminUsersThisMonth(mysqli $connection): int
{
    return (int) (($connection->query("SELECT COUNT(*) AS total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetch_assoc()['total'] ?? 0));
}

function adminActiveResets(mysqli $connection): int
{
    return (int) (($connection->query('SELECT COUNT(*) AS total FROM password_resets WHERE expires_at > NOW()')->fetch_assoc()['total'] ?? 0));
}

function adminExpiredResets(mysqli $connection): int
{
    return (int) (($connection->query('SELECT COUNT(*) AS total FROM password_resets WHERE expires_at <= NOW()')->fetch_assoc()['total'] ?? 0));
}

function adminRecentUsers(mysqli $connection, int $limit = 8): array
{
    $recentUsers = [];
    $limit = max(1, $limit);
    $result = $connection->query("SELECT first_name, last_name, email, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT {$limit}");

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $recentUsers[] = $row;
        }
    }

    return $recentUsers;
}

function adminDirectoryUsers(mysqli $connection, string $searchQuery = '', int $limit = 20): array
{
    $directoryUsers = [];
    $limit = max(1, $limit);

    if ($searchQuery !== '') {
        $statement = $connection->prepare("SELECT first_name, last_name, email, created_at FROM users WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? ORDER BY created_at DESC, id DESC LIMIT {$limit}");
        $searchTerm = '%' . $searchQuery . '%';
        $statement->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
        $statement->execute();
        $result = $statement->get_result();

        if ($result instanceof mysqli_result) {
            while ($row = $result->fetch_assoc()) {
                $directoryUsers[] = $row;
            }
        }

        $statement->close();

        return $directoryUsers;
    }

    $result = $connection->query("SELECT first_name, last_name, email, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT {$limit}");

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $directoryUsers[] = $row;
        }
    }

    return $directoryUsers;
}

function adminRecentResets(mysqli $connection, int $limit = 10): array
{
    $recentResets = [];
    $limit = max(1, $limit);
    $result = $connection->query("SELECT email, created_at, expires_at FROM password_resets ORDER BY created_at DESC, id DESC LIMIT {$limit}");

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $recentResets[] = $row;
        }
    }

    return $recentResets;
}

function adminPolicySummary(): string
{
    return getenv('SILENT_PRINT_ADMIN_EMAILS')
        ? 'Admin access is controlled by the SILENT_PRINT_ADMIN_EMAILS environment variable.'
        : 'Admin access currently falls back to the earliest registered account for local development.';
}

function adminAuthMode(): string
{
    return getenv('SILENT_PRINT_ADMIN_EMAILS') ? 'Explicit environment configuration' : 'Local fallback mode';
}

function adminSystemStatus(array $databaseConfig): array
{
    return [
        'databaseHost' => (string) ($databaseConfig['host'] ?? '127.0.0.1'),
        'databaseName' => (string) ($databaseConfig['database'] ?? 'silent_print'),
        'legacyUsersJsonExists' => is_file(dirname(__DIR__) . '/data/users.json'),
        'legacyResetsJsonExists' => is_file(dirname(__DIR__) . '/data/password_resets.json'),
    ];
}

function adminTableExists(mysqli $connection, string $tableName): bool
{
    $statement = $connection->prepare('SHOW TABLES LIKE ?');
    $statement->bind_param('s', $tableName);
    $statement->execute();
    $result = $statement->get_result();
    $exists = $result instanceof mysqli_result && $result->num_rows > 0;
    $statement->close();

    return $exists;
}

function adminQuoteStatus(mysqli $connection, string $basePath = ''): array
{
    $quotePageExists = is_file(dirname(__DIR__) . '/pages/quote.php');
    $quoteTableExists = adminTableExists($connection, 'quotes');

    return [
        'publicRoute' => ($basePath !== '' ? $basePath : '') . '/quote/',
        'quotePageExists' => $quotePageExists,
        'quoteTableExists' => $quoteTableExists,
        'submissionMode' => $quoteTableExists ? 'Stored submissions available' : 'Informational page only',
        'storageMode' => $quoteTableExists ? 'MySQL quotes table present' : 'No quotes table detected',
        'nextAction' => $quoteTableExists
            ? 'Extend the admin page with workflow states, ownership, and response tracking.'
            : 'Add quote submission handling and persist requests before building operational workflow tools.',
    ];
}
