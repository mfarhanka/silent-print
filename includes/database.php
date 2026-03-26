<?php

function dbConfig(): array
{
    static $config;

    if ($config === null) {
        $config = require dirname(__DIR__) . '/config/database.php';
    }

    return $config;
}

function dbConnection(): mysqli
{
    static $connection;

    if ($connection instanceof mysqli) {
        return $connection;
    }

    $config = dbConfig();
    $bootstrapConnection = mysqli_init();
    $bootstrapConnection->real_connect(
        $config['host'],
        $config['username'],
        $config['password'],
        null,
        $config['port']
    );

    if ($bootstrapConnection->connect_errno) {
        throw new RuntimeException('Database connection failed: ' . $bootstrapConnection->connect_error);
    }

    $databaseName = preg_replace('/[^a-zA-Z0-9_]/', '', $config['database']);
    $charset = $config['charset'];
    $bootstrapConnection->query("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET {$charset} COLLATE {$charset}_unicode_ci");
    $bootstrapConnection->close();

    $connection = mysqli_init();
    $connection->real_connect(
        $config['host'],
        $config['username'],
        $config['password'],
        $databaseName,
        $config['port']
    );

    if ($connection->connect_errno) {
        throw new RuntimeException('Database connection failed: ' . $connection->connect_error);
    }

    $connection->set_charset($charset);
    dbEnsureSchema($connection);

    return $connection;
}

function dbEnsureSchema(mysqli $connection): void
{
    static $initialized = false;

    if ($initialized) {
        return;
    }

    $connection->query(
        'CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(190) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            role VARCHAR(32) NOT NULL DEFAULT "customer",
            created_at DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    if (!dbColumnExists($connection, 'users', 'role')) {
        $connection->query('ALTER TABLE users ADD COLUMN role VARCHAR(32) NOT NULL DEFAULT "customer" AFTER password_hash');
    }

    $connection->query(
        'CREATE TABLE IF NOT EXISTS password_resets (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(190) NOT NULL,
            token_hash VARCHAR(64) NOT NULL UNIQUE,
            created_at DATETIME NOT NULL,
            expires_at DATETIME NOT NULL,
            INDEX idx_password_resets_email (email),
            INDEX idx_password_resets_expires_at (expires_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $connection->query(
        'CREATE TABLE IF NOT EXISTS quotes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(190) NOT NULL,
            email VARCHAR(190) NOT NULL,
            phone VARCHAR(50) DEFAULT NULL,
            company VARCHAR(190) DEFAULT NULL,
            product_name VARCHAR(190) NOT NULL,
            quantity INT UNSIGNED DEFAULT NULL,
            specifications TEXT DEFAULT NULL,
            needed_by DATE DEFAULT NULL,
            status VARCHAR(32) NOT NULL DEFAULT "new",
            source VARCHAR(32) NOT NULL DEFAULT "web",
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            responded_at DATETIME DEFAULT NULL,
            INDEX idx_quotes_email (email),
            INDEX idx_quotes_status (status),
            INDEX idx_quotes_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    dbMigrateLegacyJson($connection);
    $initialized = true;
}

function dbColumnExists(mysqli $connection, string $tableName, string $columnName): bool
{
    $statement = $connection->prepare('SELECT COUNT(*) AS total FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?');
    $statement->bind_param('ss', $tableName, $columnName);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result instanceof mysqli_result ? $result->fetch_assoc() : ['total' => 0];
    $statement->close();

    return (int) ($row['total'] ?? 0) > 0;
}

function dbMigrateLegacyJson(mysqli $connection): void
{
    static $migrated = false;

    if ($migrated) {
        return;
    }

    $usersCountResult = $connection->query('SELECT COUNT(*) AS total FROM users');
    $usersCountRow = $usersCountResult ? $usersCountResult->fetch_assoc() : ['total' => 0];
    $usersCount = (int) ($usersCountRow['total'] ?? 0);

    if ($usersCount === 0) {
        $legacyUsersFile = dirname(__DIR__) . '/data/users.json';
        if (is_file($legacyUsersFile)) {
            $legacyUsers = json_decode((string) file_get_contents($legacyUsersFile), true);
            if (is_array($legacyUsers)) {
                $statement = $connection->prepare('INSERT INTO users (first_name, last_name, email, password_hash, created_at) VALUES (?, ?, ?, ?, ?)');
                foreach ($legacyUsers as $legacyUser) {
                    $firstName = (string) ($legacyUser['first_name'] ?? '');
                    $lastName = (string) ($legacyUser['last_name'] ?? '');
                    $email = strtolower(trim((string) ($legacyUser['email'] ?? '')));
                    $passwordHash = (string) ($legacyUser['password_hash'] ?? '');
                    $createdAt = date('Y-m-d H:i:s', strtotime((string) ($legacyUser['created_at'] ?? 'now')));

                    if ($email === '' || $passwordHash === '') {
                        continue;
                    }

                    $statement->bind_param('sssss', $firstName, $lastName, $email, $passwordHash, $createdAt);
                    $statement->execute();
                }
                $statement->close();
            }
        }
    }

    $resetCountResult = $connection->query('SELECT COUNT(*) AS total FROM password_resets');
    $resetCountRow = $resetCountResult ? $resetCountResult->fetch_assoc() : ['total' => 0];
    $resetCount = (int) ($resetCountRow['total'] ?? 0);

    if ($resetCount === 0) {
        $legacyResetsFile = dirname(__DIR__) . '/data/password_resets.json';
        if (is_file($legacyResetsFile)) {
            $legacyResets = json_decode((string) file_get_contents($legacyResetsFile), true);
            if (is_array($legacyResets)) {
                $statement = $connection->prepare('INSERT INTO password_resets (email, token_hash, created_at, expires_at) VALUES (?, ?, ?, ?)');
                foreach ($legacyResets as $legacyReset) {
                    $email = strtolower(trim((string) ($legacyReset['email'] ?? '')));
                    $tokenHash = (string) ($legacyReset['token_hash'] ?? '');
                    $createdAt = date('Y-m-d H:i:s', strtotime((string) ($legacyReset['created_at'] ?? 'now')));
                    $expiresAt = date('Y-m-d H:i:s', strtotime((string) ($legacyReset['expires_at'] ?? 'now')));

                    if ($email === '' || $tokenHash === '') {
                        continue;
                    }

                    $statement->bind_param('ssss', $email, $tokenHash, $createdAt, $expiresAt);
                    $statement->execute();
                }
                $statement->close();
            }
        }
    }

    $migrated = true;
}

function dbCreateQuote(mysqli $connection, array $quoteData): void
{
    $statement = $connection->prepare(
        'INSERT INTO quotes (full_name, email, phone, company, product_name, quantity, specifications, needed_by, status, source, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())'
    );

    $fullName = trim((string) ($quoteData['full_name'] ?? ''));
    $email = strtolower(trim((string) ($quoteData['email'] ?? '')));
    $phone = trim((string) ($quoteData['phone'] ?? ''));
    $company = trim((string) ($quoteData['company'] ?? ''));
    $productName = trim((string) ($quoteData['product_name'] ?? ''));
    $quantity = isset($quoteData['quantity']) && $quoteData['quantity'] !== '' ? max(1, (int) $quoteData['quantity']) : null;
    $specifications = trim((string) ($quoteData['specifications'] ?? ''));
    $neededBy = trim((string) ($quoteData['needed_by'] ?? ''));
    $status = trim((string) ($quoteData['status'] ?? 'new'));
    $source = trim((string) ($quoteData['source'] ?? 'web'));

    $phone = $phone !== '' ? $phone : null;
    $company = $company !== '' ? $company : null;
    $specifications = $specifications !== '' ? $specifications : null;
    $neededBy = $neededBy !== '' ? $neededBy : null;

    $statement->bind_param('sssssissss', $fullName, $email, $phone, $company, $productName, $quantity, $specifications, $neededBy, $status, $source);
    $statement->execute();
    $statement->close();
}