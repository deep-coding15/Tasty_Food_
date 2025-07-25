<?php $title = "Modifiez une recette !"; ?>
<?php 
include __DIR__ . "/../include/init.php";
if (($session->get('ROLE')) != null && $session->get('ROLE') === 'administrateur') : 

    require_once __DIR__ . '/../models/plats.php';
    require_once __DIR__ . '/../include/Utils.php';
    $platRepository = new PlatRepository();
    $id = $_GET['id'];
    $plat = $platRepository->getPlat($id); 
    
    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($id)) {

        $result = $platRepository->supprimer_plat($id);

        if ($result) {
            $session->set('MESSAGE', "Plat supprimé avec succès.");
        } else {
            $session->set('MESSAGE', "Echec de la suppression du plat.");
        }
        (new Utils())->redirect(BASE_URL . "/src/templates/dashboard.php", 301);

    } ?>
    <?php ob_start(); ?>

    <div class=" flex flex-col items-center justify-center min-h-screen mt-6 mb-64">

        <form action="" class="bg-gray-300 p-8 rounded-3xl mt-16 mb-24 shadow-2xl w-fit max-w-md space-y-6 flex-grow
        transition duration-700 ease-in-out
                hover:bg-gray-400 hover:scale-105 
                hover:opacity-90" method="post" enctype="multipart/form-data">
            <h2 class="text-3xl font-bold text-center text-green-500">Supprimer un plat !</h2>
            <div>
                <label class="text-black-300">Nom du plat : </label>
                <span>&nbsp;&nbsp;&nbsp;<?= $plat->getNomPlat() ?></span>
            </div>
            <div>
                <label class="text-black-300">Description du plat : </label>
                <br />
                <p class="bg-gray-200 border-2 text-justify rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"><?= $plat->getDescription() ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-black-300 mb-1">
                    Image du plat :
                </label>
                <img src="<?=$plat->getImgPlat()?>" alt="image de <?=$plat->getNomPlat()?>" class="w-full h-96 object-cover mx-auto rounded-2xl">
            </div>
            <div>
                <label class="text-black-300">Prix du plat en DH: &nbsp;&nbsp;&nbsp;</label>
                <span class="bg-gray-200 rounded-lg p-2 w-full"> <?= $plat->getPrixPlat() ?></span>
            </div>
            <div>
                <label  class="text-sm font-medium text-black-300">Type du plat : &nbsp;&nbsp;&nbsp;</label> 
                <span><?=$plat->getTypePlat()?></span>
            </div>

            <div class="flex justify-center gap-12">
                <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-4 rounded
                transition duration-300 ease-in-out flex-1
                hover:bg-blue-700 hover:scale-105 
                hover:opacity-90 block justify-center">
                    <a href="<?=BASE_URL.'/src/templates/modifier_plats.php'?>?id=<?=$plat->getIdPlat()?>" class="text-yellow-500 hover:text-yellow-700">
                        Editer le plat
                    </a>    
                </button>
                <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-4 rounded
                transition duration-300 ease-in-out flex-1
                hover:bg-blue-700 hover:scale-105 
                hover:opacity-90 block justify-center">
                    Supprimer le plat
                </button>
            </div>


        </form>
    </div>
    <?php $content = ob_get_clean(); ?>

    <?php require 'layout.php'; ?>
    
<?php endif; ?>