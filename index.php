<?php
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Nettoie l'URL

switch (true) {
    case str_starts_with($url, '/menu'):
        require_once __DIR__ . '/src/controllers/menu.php';
        menu(); // Assurez-vous que cette fonction existe dans menu.php
        break;
        
    case str_starts_with($url, '/contact'):
        require __DIR__ . '/src/controllers/contact.php';
        contact();
        break;

    case str_starts_with($url, '/about'):
        require __DIR__ . '/src/templates/about.php'; // Chemin complet
        break;
        
    case str_starts_with($url, '/add_receipe'): // Note: "receipe" devrait être "recipe"
    case str_starts_with($url, '/ajouter_plat'): // Alternative en français
        require __DIR__ . '/src/templates/ajouter_plats.php';
        break;
        
    case str_starts_with($url, '/connexion'):
    case str_starts_with($url, '/login'): // Alternative en anglais
        require __DIR__ . '/src/templates/connexion.php';
        break;
        
    default:
        // Soit rediriger vers la homepage
        require_once __DIR__ . '/src/controllers/menu.php';
        menu();
        exit();
        // Soit afficher une vraie homepage
        // require __DIR__ . '/src/templates/homepage.php';
        //break;
}