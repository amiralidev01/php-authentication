<?php

# checked  Existence of user in the database amirAuth table users
function isUserExists(string $email = null, string $phone = null): bool
{
    global $pdo;
    $sql = 'SELECT * FROM `users` WHERE `email` = :email or `phone` = :phone';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email ?? '', ':phone' => $phone ?? '']);
    $record = $stmt->fetch(PDO::FETCH_OBJ);
    return $record ? true : false;
}

function createUser(array $userData): bool
{
    global $pdo;
    $sql = 'INSERT INTO `users` (name,email,phone) VALUES (:name,:email,:phone);';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $userData['name'], 'email' => $userData['email'], 'phone' => $userData['phone']]);
    return $stmt->rowCount() ? true : false;
}


# generate a token
function createLoginToken(): array
{
    global $pdo;
    $hash = bin2hex(random_bytes(8));
    $token = rand(100000, 999999);
    $expired_at = time() + 600;
    $sql = "INSERT INTO `tokens` (token,hash,expired_at) VALUES (:token,:hash,:expired_at);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['token' => $token, 'hash' => $hash, 'expired_at' => date("Y-m-d H:i:s", $expired_at)]);
    return [
        'token' => $token,
        'hash' => $hash
    ];
}


function isAliveToken(string $hash): bool
{
    $record = findTokenByHash($hash);
    if (!$record)
        return false;
    return strtotime($record->expired_at) > time() + 120;
}

function findTokenByHash(string $hash): object|bool
{
    global $pdo;
    $sql = 'SELECT * FROM `tokens` WHERE `hash` = :hash';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['hash' => $hash]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}


function sendTokenByMail(string $email, string $token): bool
{
    global $mail;
    $mail->isHTML(true);
    $mail->addAddress($email);
    $mail->Subject = 'amirAuth Verification Token<br>';
    $mail->Body    = '<h1>Your Token Is:</h1>' . "<h3>$token<h3>";
    return $mail->send();
}
