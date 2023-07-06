<?php
require 'bootstrap/init.php';


if (isLoggedIn()) {
    redirect('index.php');
}

deleteExpiredTokens();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'];
    $params = $_POST;

    if ($action == 'register') {
        #validation data
        if (empty($params['name']) or empty($params['email']) or empty($params['phone']))
            setErrorAndRedirect('please enter all input parameters!', 'auth.php?action=register');

        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL))
            setErrorAndRedirect('enter the valid email address!', 'auth.php?action=register');

        if (!preg_match("/^[0-9]{11}$/", $params['phone']))
            setErrorAndRedirect('enter the valid phone number!', 'auth.php?action=register');

        if (isUserExists($params['email'], $params['phone']))
            setErrorAndRedirect('this user is exists!', 'auth.php?action=register');


        # requested data is ok!
        # insert new user
        if (createUser($params)) {
            // die("ok");
            $_SESSION['email'] = $params['email'];
            redirect('auth.php?action=verify');
        }
    }

    if ($action == 'login') {
        #validation data
        if (empty($params['email']))
            setErrorAndRedirect('Email is Required!', 'auth.php?action=login');
        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL))
            setErrorAndRedirect('enter the valid email address!', 'auth.php?action=login');
        if (!isUserExists($params['email']))
            setErrorAndRedirect('this user is not exists! : ', 'auth.php?action=login');


        $_SESSION['email'] = $params['email'];
        redirect('auth.php?action=verify');
    }

    if ($action == 'verify') {
        $token = findTokenByHash($_SESSION['hash'])->token;
        if ($token === $params['token']) {
            $session = bin2hex(random_bytes(32));
            changeLoginSession($_SESSION['email'], $session);
            setcookie('auth', $session, time() + 1728000, '/');
            deleteTokenByHash($_SESSION['hash']);
            unset($_SESSION['hash'], $_SESSION['email']);
            redirect('index.php');
        } else {
            setErrorAndRedirect('the entered token is wrong!', 'auth.php?action=verify');
        }
    }
}





# include files with action methods
if (isset($_GET['action']) and $_GET['action'] == 'register') {
    include 'views/register.view.php';
} elseif (isset($_GET['action']) and $_GET['action'] == 'verify' and isset($_SESSION['email']) and !empty($_SESSION['email'])) {
    if (!isUserExists($_SESSION['email']))
        setErrorAndRedirect('user not exists with this data!', 'auth.php?action=login');
    if (isset($_SESSION['hash']) and isAliveToken($_SESSION['hash'])) {
        # send old token
        sendTokenByMail($_SESSION['email'], findTokenByHash($_SESSION['hash'])->token);
        $_SESSION['success'] = 'Token again sent  successfully!';
    } else {
        $tokenResult = createLoginToken();
        sendTokenByMail($_SESSION['email'], $tokenResult['token']);
        $_SESSION['hash'] = $tokenResult['hash'];
        $_SESSION['success'] = 'Token sent successfully!';
    }

    include 'views/verify.view.php';
} else {
    include 'views/login.view.php';
}
