<?php

function accountDbConnection(): mysqli
{
    return dbConnection();
}

function accountQuoteTableExists(mysqli $connection): bool
{
    $statement = $connection->prepare('SELECT COUNT(*) AS total FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?');
    $tableName = 'quotes';
    $statement->bind_param('s', $tableName);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result instanceof mysqli_result ? $result->fetch_assoc() : ['total' => 0];
    $statement->close();

    return (int) ($row['total'] ?? 0) > 0;
}

function accountQuoteCount(mysqli $connection, string $email): int
{
    if (!accountQuoteTableExists($connection)) {
        return 0;
    }

    $statement = $connection->prepare('SELECT COUNT(*) AS total FROM quotes WHERE email = ?');
    $statement->bind_param('s', $email);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result instanceof mysqli_result ? $result->fetch_assoc() : ['total' => 0];
    $statement->close();

    return (int) ($row['total'] ?? 0);
}

function accountQuoteCountByStatus(mysqli $connection, string $email, string $status): int
{
    if (!accountQuoteTableExists($connection)) {
        return 0;
    }

    $statement = $connection->prepare('SELECT COUNT(*) AS total FROM quotes WHERE email = ? AND status = ?');
    $statement->bind_param('ss', $email, $status);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result instanceof mysqli_result ? $result->fetch_assoc() : ['total' => 0];
    $statement->close();

    return (int) ($row['total'] ?? 0);
}

function accountRecentQuotes(mysqli $connection, string $email, int $limit = 12): array
{
    if (!accountQuoteTableExists($connection)) {
        return [];
    }

    $quotes = [];
    $limit = max(1, $limit);
    $statement = $connection->prepare("SELECT id, product_name, quantity, status, source, created_at, responded_at, company, specifications, needed_by FROM quotes WHERE email = ? ORDER BY created_at DESC, id DESC LIMIT {$limit}");
    $statement->bind_param('s', $email);
    $statement->execute();
    $result = $statement->get_result();

    if ($result instanceof mysqli_result) {
        while ($row = $result->fetch_assoc()) {
            $quotes[] = $row;
        }
    }

    $statement->close();

    return $quotes;
}

function accountQuoteBadgeClass(string $status): string
{
    return match ($status) {
        'new' => 'is-quote-new',
        'contacted' => 'is-quote-contacted',
        'quoted' => 'is-quote-quoted',
        'won' => 'is-quote-won',
        'archived' => 'is-quote-archived',
        default => 'is-account-neutral',
    };
}

function accountQuoteLabel(string $status): string
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

function accountConsoleSummary(mysqli $connection, array $user): array
{
    $email = authNormalizeEmail((string) ($user['email'] ?? ''));
    $quoteTableExists = accountQuoteTableExists($connection);
    $totalQuotes = $email !== '' ? accountQuoteCount($connection, $email) : 0;

    return [
        'quoteTableExists' => $quoteTableExists,
        'totalQuotes' => $totalQuotes,
        'activeQuotes' => $email !== '' ? accountQuoteCountByStatus($connection, $email, 'new') + accountQuoteCountByStatus($connection, $email, 'contacted') + accountQuoteCountByStatus($connection, $email, 'quoted') : 0,
        'wonQuotes' => $email !== '' ? accountQuoteCountByStatus($connection, $email, 'won') : 0,
        'recentQuotes' => $email !== '' ? accountRecentQuotes($connection, $email, 6) : [],
        'memberSince' => date('d M Y', strtotime((string) ($user['created_at'] ?? 'now'))),
    ];
}
