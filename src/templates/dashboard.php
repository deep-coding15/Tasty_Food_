<?php $title = 'Tasty Food - Table des Plats'; ?>
<?php require_once __DIR__ . '/../include/SecureSession.php';
    $session = new SecureSession(); ?>
<?php if(($session->get('ROLE')) != null && $session->get('ROLE') === 'administrateur') : ?>
<?php
require_once __DIR__ . '/../models/plats.php';
require_once __DIR__ . '/../../config/config.php';
$platRepository = new PlatRepository();
?>
<?php ob_start(); ?>
<link rel="stylesheet" href="../../styles/dashboard.css">
<section class="h-[80%] flex">
    <!-- Sidebar (Nav) -->
    <section id="nav-links" class="bg-gray-800 text-white  w-fit fixed top-[1vh] bottom-[8vh] left-0 h-fit  z-10">
        <div class="flex flex-col items-center mb-2">
            <!-- <img src="" alt="Logo" class="w-8 h-8"> -->
            <p class="text-xl font-bold">Tasty Food</p>
        </div>
        <nav>
            <ul class="space-y-2">
                <li><a href="#" class="hover:text-yellow-400">Accueil</a></li>
                <li><a href="#" class="hover:text-yellow-400">Ingrédients</a></li>
                <li><a href="#" class="hover:text-yellow-400">Plats</a></li>
                <li><a href="#" class="hover:text-yellow-400">Repas</a></li>
                <li><a href="#" class="hover:text-yellow-400">Réservation</a></li>
                <li><a href="#" class="hover:text-yellow-400">Livraison</a></li>
                <li><a href="#" class="hover:text-yellow-400">Personnel</a></li>
                <li><a href="#" class="hover:text-yellow-400">Réglages</a></li>
                <li><a href="#" class="hover:text-yellow-400">Thèmes et images</a></li>
                <li><a href="#" class="hover:text-yellow-400">Déconnexion</a></li> 
            </ul>
        </nav>
    </section>

    <!-- Main Content -->
    <div id="content" class="w-[100%] mx-auto  overflow-auto relative mt-[5%] mb-[10%] pt-16 ml-[10%] -z-5">
        <!-- Table des plats -->
        <section class=" -mt-8 ml-8 flex-1">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <td class="px-6 py-3">Image</td>
                        <td class="px-6 py-3">Nom</td>
                        <td class="px-6 py-3">Type de Menu</td>
                        <td class="px-6 py-3">Prix du plat</td>
                        <td colspan="3" class="px-6 py-3 text-center">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $plats = $platRepository->getPlatsByUpdatedDate();
                    $nb = 0; $max = count($plats); $i = 1;
                    define('MAX_OF_PLATS', 5);
                    foreach($plats as $plat) : 
                        if($nb < MAX_OF_PLATS * $i) : ?>
                            <tr class="border-t border-gray-300">
                                <td class="px-6 py-4">
                                    <img src="<?=$plat->getImgPlat()?>" alt="Image de <?=$plat->getNomPlat()?>" 
                                        class="w-24 h-24 object-cover rounded-t-2xl">
                                </td>
                                <td class="px-6 py-4"><?=$plat->getNomPlat()?></td>
                                <td class="px-6 py-4"><?= $plat->getTypePlat()?></td>
                                <td class="px-6 py-4"><?=$plat->getPrixPlat()?> DH</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="?id=<?=$plat->getIdPlat()?>/#plat" class="text-blue-500 hover:text-blue-700">Détails</a>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?=BASE_URL.'/src/templates/modifier_plats.php'?>?id=<?=$plat->getIdPlat()?>" class="text-yellow-500 hover:text-yellow-700">Éditer</a>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?=BASE_URL.'/src/templates/supprimer_plats.php'?>?id=<?=$plat->getIdPlat()?>" class="text-red-500 hover:text-red-700">Supprimer</a>
                                </td>
                            </tr>
                        <?php $nb++; ?>
                        <?php endif; ?>
                    <?php endforeach;?>
                </tbody>
            </table>
        </section>
    </div>
</section>

<?php $id_cible = isset($_GET['id']) ? $_GET['id'] : null;?>
<?php if($id_cible) : ?>
<section id="detail" class="flex flex-col items-center justify-center mb-24">
    <div id="plat" class="bg-gray-300 rounded-3xl p-8 shadow-2xl w-fit mb-24 max-w-md space-y-6 flex-grow flex flex-col items-center justify-center-safe
            hidden opacity-0 translate-y-2 transition duration-500 hover:scale-105 ease-out">
        <?php $plat = $platRepository->getPlat((int) $id_cible); ?>
        <h2 class="text-center text-xl font-bold text-gray-800"><?= $plat->getNomPlat() ?></h2>
        <img src="<?= $plat->getImgPlat() ?>" alt="" class="w-full h-96 object-cover mx-auto  rounded-t-2xl">
        <p><?= $plat->getPrixPlat(); ?> DH</p>
        <p><?= $plat->getDescription() ?></p>
        <a href="<?=BASE_URL.'/src/templates/modifier_plats.php'?>?id=<?=$plat->getIdPlat()?>" class="bg-blue-600 text-white font-medium py-2 px-4 rounded
            transition hover:duration-700 hover:ease-in-out
            hover:bg-blue-700 hover:scale-125 
            hover:opacity-90 block justify-center"
        >
                Editez le plat
        </a>
    </div>
</section>
    <?php endif; ?>
<?php if ($id_cible > 0): ?>
    <script>
        const id = <?= (int) ($id_cible) ?>;
        const show_plat = document.getElementById("plat");
        if (show_plat) {
            show_plat.classList.remove("hidden");

            // Pour déclencher l'animation après l'affichage
            setTimeout(() => {
                show_plat.classList.remove("opacity-0", "translate-y-2");
            }, 10); // petit délai pour permettre l'application initiale
        }
    </script>
<?php endif; ?>
<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; ?>
<?php endif; ?>

