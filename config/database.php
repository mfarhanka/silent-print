<?php

return [
    'host' => getenv('SILENT_PRINT_DB_HOST') ?: '127.0.0.1',
    'port' => (int) (getenv('SILENT_PRINT_DB_PORT') ?: 3306),
    'database' => getenv('SILENT_PRINT_DB_NAME') ?: 'silent_print',
    'username' => getenv('SILENT_PRINT_DB_USER') ?: 'root',
    'password' => getenv('SILENT_PRINT_DB_PASSWORD') ?: '',
    'charset' => 'utf8mb4',
];