<?php $title = 'Tasty Food - Accueil'; ?>
<?php
require_once __DIR__ . '/../models/plats.php';
require_once __DIR__ . '/../config.php';
$platRepository = new PlatRepository();
?>

<?php ob_start(); ?>

<?php
$page = $_GET['page'] ?? 'accompagnement'; // valeur par défaut
?>
<section id="links">
    <nav>
        <ul class="flex flex-row justify-between w-full">
            <li class="p-6 hover:bg-white rounded-lg">
                <a href="?page=accompagnement"
                    class="<?= $page === 'accompagnement' ? 'bg-white text-gray-800 p-6 rounded font-semibold' : 'hover:text-gray-300' ?>">Accompagnements
                </a>
            </li>
            <li class="p-6 hover:bg-white rounded-lg">
                <a href="?page=dessert"
                    class="<?= $page === 'dessert' ? 'w-1/6 bg-white text-gray-800 p-6 rounded font-semibold' : 'hover:text-gray-300' ?>">Desserts
                </a>
            </li>
            <li class="p-6 hover:bg-white rounded-lg">
                <a href="?page=entree"
                    class="<?= $page === 'entree' ? 'w-1/6 bg-white text-gray-800 p-6 rounded font-semibold' : 'hover:text-gray-300' ?>">Entrées
                </a>
            </li>
            <li class="p-6 hover:bg-white rounded-lg">
                <a href="?page=resistance"
                    class="<?= $page === 'resistance' ? 'w-1/6 bg-white text-gray-800 p-6 rounded font-semibold' : 'hover:text-gray-300' ?>">Plat de résistance
                </a>
            </li>
            <li class="p-6 hover:bg-white rounded-lg">
                <a href="?page=boisson"
                    class="<?= $page === 'boisson' ? 'w-1/6 bg-white text-gray-800 p-6 rounded font-semibold' : 'hover:text-gray-300' ?>">Boissons
                </a>
            </li>
        </ul>
        <div class="w-7/9 h-px bg-white"></div>
    </nav>
</section>

<section class="mb-24 mt-12">
    <h2 class="text-3xl font-bold text-center">Retrouvez les plats d'accompagnements <br> pour vos repas et savourez notre cuisine !
    </h2>

    <div class="carts grid grid-cols-3 mt-6">
        <?php
        $plats = $platRepository->getPlats();
        foreach ($plats as $plat):
            ?>
            <div
                class="max-w-sm max-h-fit pb-8 bg-white rounded-2xl overflow-hidden shadow-lg transition hover:scale-105 hover:shadow-xl duration-300">
                <img src="<?= $plat->getImgPlat() ?>" alt="<?= 'image du plat' . $plat->getNomPlat(); ?>"
                    class="w-full h-48 object-cover">
                <div class="p-6 space-y-4">
                    <p class="text-xl font-bold text-gray-800"><?= $plat->getNomPlat() ?></p>
                    <p><?= $plat->getPrixPlat() ?> DH</p>
                    <!-- J'ai envie d'utiliser un display:hidden et avec un toggle le rendre visible -->
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-green-600 md:flex-1"><?= $plat->getPrixPlat() ?> DH</span>
                        <a href="?id=<?= $plat->getIdPlat() ?>#plat"
                            class="bg-blue-600 text-white text-sm font-medium md:flex-1 px-4 py-2 rounded-lg transition hover:bg-blue-700 hover:scale-105">
                            See profile
        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    

</section>


<?php
$id_cible = isset($_GET['id']) ? $_GET['id'] : null;
if ($id_cible):
    ?>
    <section class="flex flex-col items-center justify-center">
        <div id="plat" class="bg-gray-300 p-8 rounded-3xl shadow-2xl w-fit max-w-md space-y-6 flex-grow flex flex-col items-center justify-center-safe
                    hidden opacity-0 translate-y-2 transition duration-500 ease-out">
            <?php $plat = $platRepository->getPlat($id_cible); ?>
            <h2 class="text-center text-xl font-bold text-gray-800"><?= $plat->getNomPlat() ?></h2>
            <img src="<?= $plat->getImgPlat() ?>" alt="">
            <p><?= $plat->getPrixPlat(); ?> DH</p>
            <p><?= $plat->getDescription() ?></p>
            <button class="bg-blue-600 text-white font-medium py-2 px-4 rounded
                transition duration-300 ease-in-out
                hover:bg-blue-700 hover:scale-105 
                hover:opacity-90 block justify-center">
                Acheter maintenant
            </button>
        </div>
    </section>
<?php endif; ?>







<?php if ($id_cible > 0): ?>
    <script>
        const id = <?= (int) ($id_cible) ?>;
        const el = document.getElementById("plat");
        if (el) {
            el.classList.remove("hidden");

            // Pour déclencher l'animation après l'affichage
            setTimeout(() => {
                el.classList.remove("opacity-0", "translate-y-2");
            }, 10); // petit délai pour permettre l'application initiale
        }
    </script>
<?php endif; ?>


<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; ?>