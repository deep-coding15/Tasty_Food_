<?php
http_response_code(404); // Indique au navigateur que c'est une erreur 404
?>
<?php
include __DIR__ . "/src/include/init.php";
$title = "Page non trouvée - Erreur 404";
require_once __DIR__ . "/config/config.php";
ob_start();

?>

<div class="flex flex-col items-center justify-center min-h-screen  text-center text-gray-700 font-sans">
    <h1 class="text-8xl font-bold text-red-500 mb-4">404</h1>
    <p class="text-lg mb-4">Oups ! La page que vous cherchez n'existe pas.</p>
    <a href="<?= BASE_URL . '/index.php' ?>" class="text-blue-600 hover:underline">
        Retour à l'accueil
    </a>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/src/templates/layout.php';