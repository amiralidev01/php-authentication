<?php
include 'bootstrap/init.php';
if (!isLoggedIn()) {
    redirect('auth.php?action=login');
}
$userData = getAuthenticateUserBySession($_COOKIE['auth']);
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout($userData->email);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
</head>

<body>
    <a href="?action=logout">Logout</a>
    <ul>
        <?php foreach ($userData as $key => $val) : ?>
            <li><?= "$key : $val"; ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>