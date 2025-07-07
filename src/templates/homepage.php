<?php $title = 'Tasty Food - Accueil'; ?>
<?php 
    require_once __DIR__ . '/../models/plats.php'; 
    require_once __DIR__ .'/../config.php';
    $platRepository = new PlatRepository();
?>

<?php ob_start(); ?>


<section id="links">
    <nav>
        <ul>
            <li>Accompagnements</li>
            <li>Desserts</li>
            <li>Entrees</li>
            <li>Plat de resistance</li>
            <li>Boissons</li>
        </ul>
    </nav>
</section>

<section>
    <h2 class="text-2xl font-bold">Retrouvez les plats d'accompagnements pour vos repas et savourez notre cuisine !</h2>

    <div class="carts grid grid-cols-3">
        <?php 
            $plats = $platRepository->getPlats(); 
            foreach ($plats as $plat) : 
        ?>
            <div class="cart min-w-1/4 min-h-64">
                <img src="<?=$plat->getImgPlat()?>" alt="">
                <p><?=$plat->getNomPlat()?></p>
                <p><?=$plat->getPrixPlat()?> DH</p>
                <a href="#">See Profile</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; ?>