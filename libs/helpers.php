<?php

# It's used for addressing frontend files
function assets(string $path): string
{
    return siteUrl('/assets/' . $path);
}
# BASE URL is http://localhost:8000
# this function get your uri and return your BASE_URL + url  
function siteUrl(string $uri = null): string
{
    return BASE_URL . $uri;
}

# redirection function
function redirect(string $target = BASE_URL): void
{
    header('Location: ' . $target);
    die;
}

# this function set error message in a session and redirect to the your page : autn.php?action=register || login
function setErrorAndRedirect(string $msg, string $target)
{
    $_SESSION['error'] = $msg;
    redirect(siteUrl($target));
}
