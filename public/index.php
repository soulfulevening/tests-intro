<?php

echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription</title>
</head>
<body>
HTML;

session_start();

if (isset($_POST['subscribe_form'])) {

    $email = $_POST['email'] ?? null;

    if (strlen($email) <= 0) {
        $_SESSION['flashBag']['warnings'][] = 'Email must be specified!';
        session_commit();
        header("Location: /");
        exit();
    }

    $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!$isValid) {
        $_SESSION['flashBag']['errors'][] = 'Email is invalid';
        session_commit();
        header("Location: /");
        exit();
    }

    $emails = explode(PHP_EOL, file_get_contents(__DIR__ . '/subscription.txt'));

    if (in_array($email, $emails)) {
        $_SESSION['flashBag']['warnings'][] = 'This email is already subscribed!';
        session_commit();
        header("Location: /");
        exit();
    }

    $result = file_put_contents(__DIR__ . '/subscription.txt', $email . PHP_EOL, FILE_APPEND);

    if ($result) {
        $_SESSION['flashBag']['success'][] = 'Email successfully subscribed!';
        session_commit();
        header("Location: /");
        exit();
    }

    $_SESSION['flashBag']['errors'][] = 'An error occurred while saving email to subscription list!';
    session_commit();
    header("Location: /");
    exit();
}


$alerts = '';

if (!empty($_SESSION['flashBag'] ?? [])) {
    foreach ($_SESSION['flashBag']['errors'] ?? [] as $error) {
        $alerts .= '<p style="background-color: red; color: white">' . $error . '</p>';
    }

    foreach ($_SESSION['flashBag']['success'] ?? [] as $success) {
        $alerts .= '<p style="background-color: green; color: white">' . $success . '</p>';
    }

    foreach ($_SESSION['flashBag']['warnings'] ?? [] as $warning) {
        $alerts .= '<p style="background-color: orange; color: white">' . $warning . '</p>';
    }

    unset($_SESSION['flashBag']);
}

echo <<<HTML
<div style="text-align: center">
<h3>Subscribe! And at least someone will write to you ... </h3>
<form action="/" method="POST">
$alerts
<p><input type="email" name="email" required></p>
<p><input type="submit" name="subscribe_form" id=""></p>
</form>
</div>
HTML;

echo <<<HTML
</body>
</html>
HTML;
