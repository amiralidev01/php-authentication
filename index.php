<?php
include 'bootstrap/init.php';
if (!isLoggedIn()) {
    redirect('auth.php?action=login');
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
    <ul>
        <?php foreach (getAuthenticateUserBySession($_COOKIE['auth']) as $key => $val) : ?>
            <li><?= "$key : $val"; ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>