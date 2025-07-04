<?php

$url = $_SERVER['REQUEST_URI'];

if (strpos($url, '/contact') !== false) {
    // Code pour la page de contact
    include('contact.php');
} elseif (strpos($url, '/about') !== false) {
    // Code pour la page "À propos"
    include('about.php');
} else {
    // Page par défaut (accueil)
    include('home.php');
}