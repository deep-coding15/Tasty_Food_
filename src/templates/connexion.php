<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$title = "Tasty Food - CONNEXION";
ob_start();
?>
<?php
require_once __DIR__ . '/../models/utilisateur.php';
require_once __DIR__ . "/../include/Utils.php";
$utilisateurRepository = new UtilisateurRepository();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $postData = $_POST;
  if ($postData["objectif"] == "login") {
    $result = $utilisateurRepository->logIn($postData);
    $choixJs = "signup";
  } else if ($postData["objectif"] == "signup") {
    $utilisateurRepository->signUp($postData);
    /* if ($result) {
          Utils::redirect(BASE_URL . '../index.php', 301);
    } */
  }
}
?>

<?php
$choixJs = "login";
$autreJs = ($choixJs === "login") ? "signup" : "login";
?>
<script>
  //pour attendre le chargement du DOM
  document.addEventListener("DOMContentLoaded", function() {
    const bouton = document.getElementById('choix');
    const login = document.getElementsByClassName('login')[0];
    const signup = document.getElementsByClassName('signup')[0];

    bouton.addEventListener("click", function() {
      // Si on est actuellement sur LOGIN (signup caché)
      const isLoginVisible = !login.classList.contains('hidden');

      if (isLoginVisible) {
        // Cacher login
        login.classList.add("opacity-0", "translate-y-2");
        setTimeout(() => {
          login.classList.add("hidden");
        }, 300);

        // Afficher signup
        signup.classList.remove("hidden");
        setTimeout(() => {
          signup.classList.remove("opacity-0", "translate-y-2");
        }, 10);

        // Changer texte bouton
        bouton.value = "LOGIN";
      } else {
        // Cacher signup
        signup.classList.add("opacity-0", "translate-y-2");
        setTimeout(() => {
          signup.classList.add("hidden");
        }, 300);

        // Afficher login
        login.classList.remove("hidden");
        setTimeout(() => {
          login.classList.remove("opacity-0", "translate-y-2");
        }, 10);

        // Changer texte bouton
        bouton.value = "SIGNUP";
      }
    });

    //empeche le rechargement de la page qui est le comportement par defaut lors de la soumission d'un formulaire
    /* const forms = document.getElementsByTagName("form");

    for (let form of forms) {
      form.addEventListener("submit", function(e) {
        e.preventDefault();
        //console.log("Formulaire intercepté !");
      });
    } */
  });
</script>

<script>

</script>

<section class="flex justify-end text-2xl ">
  <!-- Au debut, log in est visible -->
  <input type="button" id="choix" value="SIGNUP" class="mt-14 ursor-pointer rounded px-3 py-2 bg-gray-500 transition duration-500 ease-out hover:scale-105 hover:bg-blue-500" />
</section>
<section class="w-4/6 mx-auto login">

  <div class="flex flex-col items-center justify-center mb-24 w-full">
    <h1 class="text-center text-2xl font-medium text-gray-800 mb-6">LOG IN</h1>
    <form action="" method="post"
      class="bg-gray-300 p-8 rounded-3xl shadow-2xl w-full max-w-md space-y-6 transition duration-500 ease-out hover:scale-105
      flex flex-col justify-center">

      <div>
        <label for="firstname" class="block text-center w-full">First Name:</label>
        <input type="text" name="firstname" id="firstname" required
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <div>
        <label for="lastname" class="block text-center w-full">Last Name:</label>
        <input type="text" name="lastname" id="lastname" required
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <div>
        <label for="password" class="block text-center w-full">Password:</label>
        <input type="password" name="password" id="password" required
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <!-- <div>
        <label for="image" class="block text-center w-full">Upload Profile Photo:</label>
        <input type="file" name="image" id="image" required
          class="bg-white rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div> -->
      <div>
        <label for="email" class="block text-center w-full">Email:</label>
        <input type="email" name="email" id="email"
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <div>
        <label for="telephone" class="block text-center w-full">Telephone:</label>
        <input type="telephone" name="telephone" id="telephone"
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <input type="text" name="objectif" id="objectif" value="login" hidden>

      <button type="submit"
        class="bg-blue-600 text-white font-medium py-2 px-6 rounded transition hover:duration-700
            hover:ease-in-out hover:bg-blue-700 hover:scale-110 hover:opacity-90 block w-lg">
        ENVOYER
      </button>
    </form>
  </div>
</section>

<!-- <button id="loginBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
  Login
</button>

!-- Overlay modale cachée --
<div id="signupOverlay" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg p-6 w-80 relative shadow-lg">
    <button id="closeSignup" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
    <h2 class="text-xl font-semibold mb-4">Sign Up</h2>
    <form id="signupForm" class="space-y-4">
      <input type="text" placeholder="Nom" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <input type="email" placeholder="Email" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
        S'inscrire
      </button>
    </form>
  </div>
</div> -->


<section class="w-4/6 mx-auto hidden signup">

  <div class="flex flex-col items-center justify-center m-12 w-full mb-24">
    <h1 class="text-center text-2xl font-medium text-gray-800 mb-6">SIGN UP</h1>
    <form action="" method="post"
      class="bg-gray-300 p-8 rounded-3xl shadow-2xl w-full max-w-md space-y-6 transition duration-500 ease-out hover:scale-105
      flex flex-col justify-center">

      <div>
        <label for="email" class="block text-center w-full">Email:</label>
        <input type="email" name="email" id="email"
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <div>
        <label for="password" class="block text-center w-full">Password:</label>
        <input type="password" name="password" id="password" required
          class="rounded block w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>
      <input type="text" name="objectif" id="objectif" value="signup" hidden>
      <button type="submit"
        class="bg-blue-600 text-white font-medium py-2 px-6 rounded transition hover:duration-700
            hover:ease-in-out hover:bg-blue-700 hover:scale-110 hover:opacity-90 block w-lg">
        ENVOYER
      </button>
    </form>
  </div>
</section>

<?php $content = ob_get_clean(); ?>
<?php
require_once __DIR__ . "/layout.php";
