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
    $result = $connection->query("SELECT first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT {$limit}");

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $row['resolved_role'] = authUserRole($row);
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
        $statement = $connection->prepare("SELECT first_name, last_name, email, role, created_at FROM users WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? ORDER BY created_at DESC, id DESC LIMIT {$limit}");
        $searchTerm = '%' . $searchQuery . '%';
        $statement->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
        $statement->execute();
        $result = $statement->get_result();

        if ($result instanceof mysqli_result) {
            while ($row = $result->fetch_assoc()) {
                $row['resolved_role'] = authUserRole($row);
                $directoryUsers[] = $row;
            }
        }

        $statement->close();

        return $directoryUsers;
    }

    $result = $connection->query("SELECT first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC, id DESC LIMIT {$limit}");

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $row['resolved_role'] = authUserRole($row);
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
    return 'Backoffice access is controlled by stored user roles. The SILENT_PRINT_ADMIN_EMAILS fallback remains available so the original admin account can still bootstrap local environments.';
}

function adminAuthMode(): string
{
    return 'Stored roles with legacy admin fallback';
}

function adminResolvedRoleLabel(string $role): string
{
    return match ($role) {
        'admin' => 'Admin',
        'staff' => 'Staff',
        default => 'Customer',
    };
}

function adminResolvedRoleBadgeClass(string $role): string
{
    return match ($role) {
        'admin' => 'is-admin',
        'staff' => 'is-staff',
        default => 'is-user',
    };
}

function adminRoleCounts(mysqli $connection): array
{
    $counts = [
        'admin' => 0,
        'staff' => 0,
        'customer' => 0,
    ];
    $result = $connection->query('SELECT first_name, last_name, email, role, created_at FROM users');

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $role = authUserRole($row);
            if (!array_key_exists($role, $counts)) {
                $role = 'customer';
            }
            $counts[$role]++;
        }
    }

    return $counts;
}

function adminBackofficeUsers(mysqli $connection): array
{
    $users = [];
    $result = $connection->query('SELECT first_name, last_name, email, role, created_at FROM users ORDER BY created_at ASC, id ASC');

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $resolvedRole = authUserRole($row);
            if (!in_array($resolvedRole, ['admin', 'staff'], true)) {
                continue;
            }

            $row['resolved_role'] = $resolvedRole;
            $users[] = $row;
        }
    }

    return $users;
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
    $statement = $connection->prepare('SELECT COUNT(*) AS total FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?');
    $statement->bind_param('s', $tableName);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result instanceof mysqli_result ? $result->fetch_assoc() : ['total' => 0];
    $statement->close();

    return (int) ($row['total'] ?? 0) > 0;
}

function adminQuoteStatus(mysqli $connection, string $basePath = ''): array
{
    $quotePageExists = is_file(dirname(__DIR__) . '/pages/quote.php');
    $quoteTableExists = adminTableExists($connection, 'quotes');
    $totalQuotes = $quoteTableExists ? adminQuoteTotal($connection) : 0;

    return [
        'publicRoute' => ($basePath !== '' ? $basePath : '') . '/quote/',
        'quotePageExists' => $quotePageExists,
        'quoteTableExists' => $quoteTableExists,
        'totalQuotes' => $totalQuotes,
        'submissionMode' => !$quoteTableExists
            ? 'Informational page only'
            : ($totalQuotes > 0 ? 'Stored submissions available' : 'Storage provisioned, waiting for intake'),
        'storageMode' => $quoteTableExists ? 'MySQL quotes table ready' : 'No quotes table detected',
        'nextAction' => $quoteTableExists
            ? ($totalQuotes > 0
                ? 'Extend the admin page with workflow states, ownership, and response tracking.'
                : 'Connect the public quote page to this table so new requests appear in the admin queue.')
            : 'Add quote submission handling and persist requests before building operational workflow tools.',
    ];
}

function adminQuoteTotal(mysqli $connection): int
{
    return (int) (($connection->query('SELECT COUNT(*) AS total FROM quotes')->fetch_assoc()['total'] ?? 0));
}

function adminQuoteCountByStatus(mysqli $connection, string $status): int
{
    $statement = $connection->prepare('SELECT COUNT(*) AS total FROM quotes WHERE status = ?');
    $statement->bind_param('s', $status);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result instanceof mysqli_result ? $result->fetch_assoc() : ['total' => 0];
    $statement->close();

    return (int) ($row['total'] ?? 0);
}

function adminQuoteActiveCount(mysqli $connection): int
{
    $statuses = ['new', 'contacted', 'quoted'];
    $placeholders = implode(',', array_fill(0, count($statuses), '?'));
    $statement = $connection->prepare("SELECT COUNT(*) AS total FROM quotes WHERE status IN ({$placeholders})");
    $statement->bind_param(str_repeat('s', count($statuses)), ...$statuses);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result instanceof mysqli_result ? $result->fetch_assoc() : ['total' => 0];
    $statement->close();

    return (int) ($row['total'] ?? 0);
}

function adminRecentQuotes(mysqli $connection, int $limit = 20): array
{
    $quotes = [];
    $limit = max(1, $limit);
    $result = $connection->query("SELECT id, full_name, email, phone, company, product_name, quantity, status, source, created_at, responded_at FROM quotes ORDER BY created_at DESC, id DESC LIMIT {$limit}");

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $quotes[] = $row;
        }
    }

    return $quotes;
}

function adminQuoteBadgeClass(string $status): string
{
    return match ($status) {
        'new' => 'is-quote-new',
        'contacted' => 'is-quote-contacted',
        'quoted' => 'is-quote-quoted',
        'won' => 'is-quote-won',
        'archived' => 'is-quote-archived',
        default => 'is-user',
    };
}

function adminQuoteLabel(string $status): string
{
    return match ($status) {
        'new' => 'New',
        'contacted' => 'Contacted',
        'quoted' => 'Quoted',
        'won' => 'Won',
        'archived' => 'Archived',
        default => ucfirst($status),
    };
}
