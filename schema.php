<?php

$sql = new SQLite3("database.db");

$query = <<<SQL
    CREATE TABLE "users" (
        `id` INTEGER PRIMARY KEY AUTOINCREMENT,
        `username` TEXT UNIQUE,
        `email` TEXT UNIQUE,
        `session` TEXT UNIQUE,
        `time` INTEGER DEFAULT (CURRENT_TIMESTAMP)
    )
SQL;

$sql->exec($query);