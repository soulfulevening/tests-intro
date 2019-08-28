<?php

const STORAGE_FILE = __DIR__ . '/../subscription.txt';

function isExists(string $email): bool {
    return in_array($email, explode(PHP_EOL, file_get_contents(STORAGE_FILE)));
}

function add(string $email) {
    return file_put_contents(STORAGE_FILE, $email . PHP_EOL, FILE_APPEND);
}