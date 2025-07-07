<?php $title = 'Tasty Food - Accueil'; ?>
<?php
require_once __DIR__ . '/../models/plats.php';
require_once __DIR__ . '/../config.php';
$platRepository = new PlatRepository();
?>

<?php ob_start(); ?>


<section id="links">
    <nav>
        <ul>
            <li><a href="">Accompagnements</a></li>
            <li><a href="">Desserts</a></li>
            <li><a href="">Entrees</a></li>
            <li><a href="">Plat de resistance</a></li>
            <li><a href="">Boissons</a></li>
        </ul>
    </nav>
</section>

<section>
    <h2 class="text-2xl font-bold">Retrouvez les plats d'accompagnements pour vos repas et savourez notre cuisine !
    </h2>

    <div class="carts grid grid-cols-3">
        <?php
        $plats = $platRepository->getPlats();
        foreach ($plats as $plat):
            ?>
            <div class="cart min-w-1/4 min-h-64">
                <img src="<?= $plat->getImgPlat() ?>" alt="<?= 'image du plat' . $plat->getNomPlat(); ?>"
                    class="rounded-lg">
                <p><?= $plat->getNomPlat() ?></p>
                <p><?= $plat->getPrixPlat() ?> DH</p>
                <a href="?id=<?= $plat->getIdPlat() ?>">See
                    Profile</a><!-- J'ai envie d'utiliser un display:hidden et avec un toggle le rendre visible -->
            </div>
        <?php endforeach; ?>
    </div>
</section>


<?php
$id_cible = isset($_GET['id']) ? $_GET['id'] : null;
?>
<section class="flex flex-col items-center justify-center">
    <div id="plat" class="bg-gray-300 p-8 rounded-3xl shadow-2xl w-fit max-w-md space-y-6 flex-grow flex flex-col items-center justify-center-safe
                    hidden opacity-0 translate-y-2 transition duration-500 ease-out">
        <?php $plat = $platRepository->getPlat($id_cible); ?>
        <h2 class="text-center"><?= $plat->getNomPlat() ?></h2>
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