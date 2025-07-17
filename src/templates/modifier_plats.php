<?php $title = "Modifiez une recette !"; ?>

<?php
require_once __DIR__ . '/../include/SecureSession.php';
$session = new SecureSession();

if (($session->get('ROLE')) != null && $session->get('ROLE') === 'administrateur') : 
    
    require_once __DIR__ . '/../models/plats.php';
    $platRepository = new PlatRepository();

    $id = $_GET['id']; //id recupere lorsque l'admin clique sur modifier plat d'un plat
    $plat = $platRepository->getPlat($id);

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        
        $result = $platRepository->modifier_plat($id, $_POST, $_FILES);

        require_once __DIR__ . '/../include/Utils.php';
        if ($result) {
            $session->set('MESSAGE', "Plat modifié avec succès.");
        } else {
            $session->set('MESSAGE', "Echec de la modification du plat.");
        }
        (new Utils())->redirect(BASE_URL . "/src/templates/dashboard.php");

        //echo "<script>console.log(" . json_encode($result) . ");</script>";
    }
?>
    <?php ob_start(); ?>

    <div class=" flex flex-col items-center justify-center min-h-screen mt-6 mb-64">

        <form action="" class="bg-gray-300 p-8 rounded-3xl mt-16 mb-24 shadow-2xl w-fit max-w-md space-y-6 flex-grow
        transition duration-700 ease-in-out
                hover:bg-gray-400 hover:scale-105 
                hover:opacity-90" method="post" enctype="multipart/form-data">
            <h2 class="text-3xl font-bold text-center text-green-500">Modifiez un plat !</h2>
            <div>
                <label for="name_plat" class="block text-sm font-medium text-black-300">Nom du plat : </label>
                <input type="text" name="name_plat" id="name_plat" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?= $plat->getNomPlat() ?>" required>
            </div>
            <div>
                <label for="description" class="text-black-300">Description du plat : </label>
                <br />
                <textarea name="description" id="description" cols="50" rows="10" class="bg-gray-200 border-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"><?= $plat->getDescription() ?></textarea>
            </div>
            <div>
                <label for="image_plat" class="block text-sm font-medium text-black-300 mb-1">
                    Image du plat :
                </label>
                <input
                    type="file"
                    name="image_plat"
                    id="image_plat"
                    accept="image/*"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                        text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                        file:rounded-2xl file:border-1 file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        focus:outline-none focus:ring-2 focus:ring-blue-500"

                    required />
            </div>
            <div>
                <label for="prix_plat" class="text-black-300">Prix du plat en DH: </label>
                <br>
                <input type="number" name="prix_plat" id="prix_plat" class="bg-gray-200 rounded-lg p-2 w-full" value="<?= $plat->getPrixPlat() ?>">
            </div>
            <div>
                <label for="type_plat" class="block text-sm font-medium text-black-300">Type du plat : </label>
                <select name="type_plat" id="type_plat" required class="border rounded-lg text-gray-800 p-2 bg-gray-100 w-full text-center" value="<?= $plat->getTypePlat() ?>">
                    <option value="6" name="type_plat" disabled>--Selectionner un type de plat--</option>
                    <option value="1" name="type_plat">Accompagnements</option>
                    <option value="2" name="type_plat">Dessert</option>
                    <option value="3" name="type_plat">Plat d'entrée</option>
                    <option value="4" name="type_plat">Plat de résistance</option>
                    <option value="5" name="type_plat">Boissons</option>
                </select>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-4 rounded
                transition duration-300 ease-in-out
                hover:bg-blue-700 hover:scale-105 
                hover:opacity-90 block justify-center">
                    Confirmer les changements
                </button>
            </div>


        </form>
    </div>
    <?php $content = ob_get_clean(); ?>

    <?php require 'layout.php'; ?>
<?php endif; ?>