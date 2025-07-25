<?php
require_once __DIR__ . '/config/config.php';
include __DIR__ . "/src/include/init.php";
http_response_code(403); // Indique au navigateur que c'est une erreur 404
?>
<?php
$title = "Permissions insuffissantes - Erreur 403";
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . '/src/include/SecureSession.php';
ob_start();

?>

<div class="flex flex-col items-center justify-center min-h-screen  text-center text-gray-700 font-sans">
    <h1 class="text-8xl font-bold text-red-500 mb-4">403</h1>
    <p class="text-lg mb-4">Oups ! Vous n'avez pas les permissions pour afficher cette page que vous cherchez .</p>
    <a href="<?= BASE_URL . '/index.php' ?>" class="text-blue-600 hover:underline">
        Retour à l'accueil
    </a>
    <p><?php echo $_session->get('utilisateur')['role']; ?>
    </p>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/src/templates/layout.php';
