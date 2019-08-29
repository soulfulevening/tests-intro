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

require_once __DIR__ . '/_inc/_session.php';

session_start();

function redirect(string $location) {
    session_commit();
    header("Location: " . $location);
    exit();
}

if (isset($_POST['subscribe_form'])) {

    $email = $_POST['email'] ?? null;

    if (strlen($email) <= 0) {
        addWarning('Email must be specified!');
        redirect('/');
    }

    $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!$isValid) {
        addError('Email is invalid!');
        redirect('/');
    }

    $emails = explode(PHP_EOL, file_get_contents(__DIR__ . '/subscription.txt'));

    if (in_array($email, $emails)) {
        addWarning('This email is already subscribed!');
        redirect('/');
    }

    $result = file_put_contents(__DIR__ . '/subscription.txt', $email . PHP_EOL, FILE_APPEND);

    if ($result) {
        addSuccess('Email successfully subscribed!');
        redirect('/');
    }

    addError('An error occurred while saving email to subscription list!');
    redirect('/');
}


$alerts = '';

foreach (getErrors() as $error) {
    $alerts .= '<p style="background-color: red; color: white" class="error">' . $error . '</p>';
}

foreach (getSuccess() as $success) {
    $alerts .= '<p style="background-color: green; color: white" class="success">' . $success . '</p>';
}

foreach (getWarnings() as $warning) {
    $alerts .= '<p style="background-color: orange; color: white" class="warning">' . $warning . '</p>';
}

unset($_SESSION[FLASH_BAG_KEY]);

echo <<<HTML
<div style="text-align: center">
<h3>Subscribe! And at least someone will write to you ... </h3>
<form action="/" method="POST" onsubmit="submitHandler(this)">
$alerts
<p><input type="email" name="email" required></p>
<p><input type="submit" name="subscribe_form" id=""></p>
</form>
</div>
HTML;

echo <<<HTML
<script>
function submitHandler(e) {
  if (confirm('Are you really want to subscribe?')) {
      e.submit;
  }
}
</script>
</body>
</html>
HTML;
