<?php

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Nettoie l'URL
require_once __DIR__ .'/controllers/homepage.php';
switch (true) {
    case str_starts_with($url, '/contact'):
        include 'contact.php';
        break;

    case str_starts_with($url, '/about'):
        include 'about.php';
        break;
    case str_starts_with($url, '/add_receipe'):
        include 'about.php';
        break;
    default:
        homepage();
        /* include 'templates/homepage.php'; */
        break;
}