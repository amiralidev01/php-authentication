<?php


$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

if($pageWasRefreshed ) {
  echo 'do something because page was refreshed';
} else {
  echo 'do nothing';
}