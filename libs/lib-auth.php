<?php

# checked  Existence of user in the database amirAuth table users
function isUserExists(string $email = null, string $phone = null): bool
{
    global $pdo;
    $sql = 'SELECT * FROM `users` WHERE `email` = :email or `phone` = :phone';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email, ':phone' => $phone]);
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
