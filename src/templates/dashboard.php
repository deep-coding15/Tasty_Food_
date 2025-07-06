<?php $title = 'Tasty Food - Table des Plats'; ?>

<?php ob_start(); ?>
<link rel="stylesheet" href="../../styles/dashboard.css">
<main>
    <section id="nav-links">
        <div>
            <img src="" alt="">
            <p>Tasty Food</p>
        </div>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Ingrédients</a></li>
                <li><a href="#">Plats</a></li>
                <li><a href="#">Repas</a></li>
                <li><a href="#">Réservation</a></li>
                <li><a href="#">Livraison</a></li>
                <li><a href="#">Personnel</a></li>
                <li><a href="#">Réglages</a></li>
                <li><a href="#">Thèmes et images</a></li>
                <li><a href="#">Déconnexion</a></li>
            </ul>
        </nav>
    </section>

    <div id="content">
        <h1>Table des Plats</h1>

        <button>Ajouter un nouveau plat</button>

        <table>
            <thead>
                <tr>
                    <td>Image</td>
                    <td>Nom</td>
                    <td>Type de Menu</td>
                    <td>Prix du plat</td>
                    <td colspan="3">Action</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>im</td>
                    <td>pattes</td>
                    <td>accompagnements</td>
                    <td>30.00 DH</td>
                    <td class="details"><a href="">Details</a></td>
                    <td class="editer"><a href="">Editer</a></td>
                    <td class="supprimer"><a href="">Supprimer</a></td>
                </tr>
                <tr>
                    <td>im</td>
                    <td>pattes</td>
                    <td>accompagnements</td>
                    <td>30.00 DH</td>
                    <td><a href="">Details</a></td>
                    <td><a href="">Editer</a></td>
                    <td><a href="">Supprimer</a></td>
                </tr>
                <tr>
                    <td>im</td>
                    <td>pattes</td>
                    <td>accompagnements</td>
                    <td>30.00 DH</td>
                    <td><a href="">Details</a></td>
                    <td><a href="">Editer</a></td>
                    <td><a href="">Supprimer</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</main>


<?php $content = ob_get_clean(); ?>

<?php require 'layout.php';