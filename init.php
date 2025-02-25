<?php

if (php_sapi_name() != "cli") {
    http_response_code(403);
    exit();
}

$sql = new SQLite3("database.db");

$query = <<<SQL
    CREATE TABLE "users" (
        `id` INTEGER PRIMARY KEY AUTOINCREMENT,
        `username` TEXT UNIQUE,
        `email` TEXT UNIQUE,
        `avatar` TEXT DEFAULT "default.jpg",
        `session` TEXT UNIQUE,
        `time` INTEGER DEFAULT (unixepoch()))
SQL;

$sql->exec($query);