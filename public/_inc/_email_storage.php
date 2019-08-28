<?php

function isExists(string $email): bool {
    return in_array($email, explode(PHP_EOL, file_get_contents(__DIR__ . '/../subscription.txt')));
}

function add(string $email) {
    return file_put_contents(__DIR__ . '/../subscription.txt', $email . PHP_EOL, FILE_APPEND);
}