<?php

const FLASH_BAG_KEY = 'flashBag';

const ERRORS = 'errors';
const WARNINGS = 'warnings';
const SUCCESS = 'success';

function addToFlashBag(string $level, string $message) {
    $_SESSION[FLASH_BAG_KEY][$level][] = $message;
}

function addWarning(string $msg) {
    addToFlashBag(WARNINGS, $msg);
}

function addError(string $msg) {
    addToFlashBag(ERRORS, $msg);
}

function addSuccess(string $msg) {
    addToFlashBag(SUCCESS, $msg);
}

function getWarnings(): array
{
    return $_SESSION[FLASH_BAG_KEY][WARNINGS] ?? [];
}

function getErrors(): array
{
    return $_SESSION[FLASH_BAG_KEY][ERRORS] ?? [];
}

function getSuccess(): array
{
    return $_SESSION[FLASH_BAG_KEY][SUCCESS] ?? [];
}