<?php

function addWarning(string $msg) {
    $_SESSION['flashBag']['warnings'][] = $msg;
}

function addError(string $msg) {
    $_SESSION['flashBag']['errors'][] = $msg;
}

function addSuccess(string $msg) {
    $_SESSION['flashBag']['success'][] = $msg;
}