<?php
$title = 'Tasty Food - Réservation';

ob_start();
?>

<section>
    <h1 class="text-4xl md:text-5xl font-semibold text-gray-800 tracking-wide text-center"
        style="font-family: 'Playfair Display', serif;">
        Bienvenue chez Tasty Food !
    </h1>
    <br>
    <p>Découvrez une expérience culinaire inoubliable – réservez dès maintenant et laissez-vous séduire par des saveurs
        qui danseront sur vos papilles ! 🍽️✨</p>
    <form action="" method="post" class="max-w-4xl mx-auto p-6 bg-white rounded shadow-md space-y-6">
        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 tracking-wide text-center underline">
            Salle de réservation</h2>
        <!-- Ligne nom + email -->
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex flex-col flex-1">
                <label for="name" class="mb-1 font-semibold text-gray-700">Votre nom :</label>
                <input type="text" name="name" id="name"
                    class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex flex-col flex-1">
                <label for="email" class="mb-1 font-semibold text-gray-700">Votre email :</label>
                <input type="email" name="email" id="email"
                    class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- Téléphone -->
        <div class="flex flex-col">
            <label for="telephone" class="mb-1 font-semibold text-gray-700">Votre numéro de téléphone :</label>
            <input type="tel" name="telephone" id="telephone"
                class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Réservation -->
        <div class="flex flex-col md:flex-row gap-6">
            <label for="reservation" class="mb-1 font-semibold text-gray-700">Vous réservez <br> une table pour
                :</label>
            <div class="flex items-center flex-1 gap-2">
                <input type="number" name="reservation" id="reservation"
                    class="border border-gray-300 rounded px-4 py-2 w-24 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span class="text-gray-600">personnes ?</span>
            </div>
            <div class="flex flex-col flex-1">
                <label for="jour" class="mb-1 font-semibold text-gray-700">Quel jour :</label>
                <input type="date" name="jour" id="jour"
                    class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex flex-col flex-1">
                <label for="heure" class="mb-1 font-semibold text-gray-700">Quelle heure :</label>
                <input type="time" name="heure" id="heure"
                    class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

        </div>
        <div class="flex flex-col md:flex-row gap-6"></div>

        <!-- Bouton -->
        <div class="">
            <input type="submit" value="ENVOYER"
                class="block w-1/4 mx-auto bg-blue-600 text-white font-semibold py-2 px-6 rounded hover:bg-blue-700 hover:scale-105 transition-all duration-300">
        </div>
    </form>

</section>
<?php $content = ob_get_clean();
require_once __DIR__ . '/layout.php' ?>
