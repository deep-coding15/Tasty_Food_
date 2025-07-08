<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once __DIR__ . "/../config.php";
  /* ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL); */
  ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL . '/src/style.css' ?>">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <title>
    <?= $title ?>
  </title>
</head>


<body class="flex flex-col space-y-4 scroll-smooth">
  <header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <nav class="space-x-6 hidden md:flex">
        <a href="index.html" class="text-gray-600 hover:text-blue-600 flex-1">Accueil</a>
        <a href="menu.html" class="text-gray-600 hover:text-blue-600 flex-1">Menu</a>
        <a href="reservation.html" class="text-gray-600 hover:text-blue-600 flex-1">Réservation</a>
        <a href="livraison.html" class="text-gray-600 hover:text-blue-600 flex-1">Livraison</a>
        <a href="contact.html" class="text-gray-600 hover:text-blue-600 flex-1">Contact</a>
        <a id="connexion" class="text-gray-600 hover:text-blue-600 flex-1" href="connexion.html">Connexion</a>
      </nav>
      <!-- bouton hamburger visible sur mobile (petits écrans)-->
      <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>

    <!-- uniquement visible sur mobile -->
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 space-y-2">
      <a href="index.html" class="block text-gray-700 hover:text-blue-600">Accueil</a>
      <a href="menu.html" class="block text-gray-700 hover:text-blue-600">Menu</a>
      <a href="reservation.html" class="block text-gray-700 hover:text-blue-600">Réservation</a>
      <a href="livraison.html" class="block text-gray-700 hover:text-blue-600">Livraison</a>
      <a href="contact.html" class="block text-gray-700 hover:text-blue-600">Contact</a>
      <a id="connexion" class="block text-gray-700 hover:text-blue-600" href="connexion.html">Connexion</a>
    </div>

  </header>

  <main class="pb-48">
    <?= $content ?>
  </main>

  <!-- <footer class="bg-gray-800 text-white py-3 h-fit fixed bottom-0 left-0
     w-full "> -->
  <footer class="bg-gray-800 text-white py-3 h-fit fixed bottom-0 left-0 w-full shadow-inner border-t border-gray-700">

    <div class="max-w-6xl mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">

        <!-- Logo ou titre -->
        <div class="text-lg font-semibold">Tasty Food</div>

        <!-- Liens -->
        <div class="flex space-x-6 text-sm">
          <a href="#" class="hover:text-gray-300 transition">Accueil</a>
          <a href="#" class="hover:text-gray-300 transition">À propos</a>
          <a href="#" class="hover:text-gray-300 transition">Contact</a>
          <a href="#" class="hover:text-gray-300 transition">FAQ</a>
        </div>

        <!-- Réseaux sociaux --><!-- remplace ce path par une vraie icône -->
        <!-- <div class="flex space-x-4">
        <a href="#" aria-label="Facebook" class="hover:text-blue-400">
          <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
            <path d="M22 12...Z" /> 
          </svg>
        </a>
        <a href="#" aria-label="Twitter" class="hover:text-blue-300">
          <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
            <path d="M24 4.5...Z" />
          </svg>
        </a>
      </div> -->
      </div>

      <!-- Copyright -->
      <div class="text-center mt-6 text-sm text-gray-400">
        © 2025 Tasty Food. Tous droits réservés.
      </div>
    </div>
  </footer>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Toggle le menu mobile
    const toggleButton = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    toggleButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</body>
<!-- <footer class="bg-gray-800 text-white py-8">
      Tasty - Food Tous droits reserves
  </footer> -->
<!-- fixed bottom-0 left-0 -->



</html>