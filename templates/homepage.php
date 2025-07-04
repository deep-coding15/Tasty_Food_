<?php $title = 'Tasty Food - Accueil'; ?>

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
    <div class="carts grid">
        <div class="cart">
            <img src="" alt="">
            <p>Pattes</p>
            <p>Prix</p>
            <a href="#">See Profile</a>
        </div>
        <div class="cart">
            <img src="" alt="">
            <p>Pattes</p>
            <p>Prix</p>
            <a href="#">See Profile</a>
        </div>
        <div class="cart">
            <img src="" alt="">
            <p>Pattes</p>
            <p>Prix</p>
            <a href="#">See Profile</a>
        </div>
        <div class="cart">
            <img src="" alt="">
            <p>Pattes</p>
            <p>Prix</p>
            <a href="#">See Profile</a>
        </div>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'layout.php'; 