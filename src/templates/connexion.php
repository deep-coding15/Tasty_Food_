<?php
$title = "Tasty Food - CONNEXION";
ob_start();
?>


<?php
$choixJs = "login";
$autreJs = ($choixJs === "login") ? "signup" : "login";
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const bouton = document.getElementById('choix');
    const login = document.getElementsByClassName('login')[0];
    const signup = document.getElementsByClassName('signup')[0];

    bouton.addEventListener("click", function () {
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
});
</script>




<section class="flex justify-end text-2xl">
    <!-- Au debut, log in est visible -->
    <input type="button" id="choix" value="SIGNUP" class="cursor-pointer rounded px-3 py-2 bg-gray-500 transition duration-500 ease-out hover:scale-105 hover:bg-blue-500"/>
</section>
<section class="w-4/6 mx-auto login">
    
  <div class="flex flex-col items-center justify-center m-12 w-full">
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

<section class="w-4/6 mx-auto hidden signup">
    
  <div class="flex flex-col items-center justify-center m-12 w-full">
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
require_once __DIR__ ."/layout.php";
require_once __DIR__ .'/../../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $postData = $_POST;
    if ($postData["objectif"] == "login") {
        

        if(isset($postData["firstname"]) && trim($postData["firstname"]) != ""
            && isset($postData["lastname"]) && trim($postData['lastname']) != ""
            && isset($postData["password"]) && trim($postData["password"]) != ""
            && isset($postData["email"]) && trim($postData["email"]) != ""
            && isset($postData["telephone"]) && trim($postData["telephone"]) != ""
        ) {
            $lastname = trim($postData["lastname"]);
            $firstname = trim($postData["firstname"]);
            $password = trim($postData["password"]);
            $email = trim($postData["email"]);
            $telephone = trim($postData["telephone"]);

            $database = new Database();
            $pdo = $database->getConnection();
            $image = 'default_profile_photo.jpg';
            $login = genererLoginUnique($firstname, $lastname, $pdo);

            $sql = "INSERT INTO utilisateur(nom, prenom, login, password, img_profil, email, telephone, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $resultStatus = $stmt->execute([
                $lastname,
                $firstname,
                $login,
                password_hash($password, PASSWORD_DEFAULT),
                $image,
                $email, 
                $telephone,
                false
            ]);

            if($resultStatus) {
                echo "Vos informations de connection ont été enregistré avec succès";
            } else {
                echo "L'enregistrement a échoué";
            }
        }
    }
    else if ($postData["objectif"] == "signup") {
        if (isset($postData["password"]) && trim($postData["password"]) != ""
            && isset($postData["email"]) && trim($postData["email"]) != "") {
            $password = trim($postData["password"]);
            $email = trim($postData["email"]);

            if(validerSignup($email, $password)){
                echo "Vos informations de connection sont corrects";
            } else {
                echo "Vos informations de connection ne sont pas corrects";
            }
        }
    }
}



function genererLogin($prenom, $nom) {
    // Nettoyage de l’entrée : suppression des espaces, accents, etc.
    $prenom = strtolower(supprimerCaracteresSpeciaux($prenom));
    $nom = strtolower(supprimerCaracteresSpeciaux($nom));
    
    // Création du login : initiale du prénom + nom
    $login = substr($prenom, 0, 1) . $nom;

    return $login;
}
function supprimerCaracteresSpeciaux($texte) {
    $texte = iconv('UTF-8', 'ASCII//TRANSLIT', $texte); // Enlève les accents
    $texte = preg_replace('/[^a-zA-Z0-9]/', '', $texte); // Enlève caractères spéciaux
    return $texte;
}
function genererLoginUnique($prenom, $nom, $conn) {
    $baseLogin = genererLogin($prenom, $nom);
    $login = $baseLogin;
    $i = 1;

    // Vérifie dans la base si le login existe déjà
    while (loginExiste($login, $conn)) {
        $login = $baseLogin . $i;
        $i++;
    }

    return $login;
}

function loginExiste($login, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM utilisateur WHERE login = ?");
    $stmt->execute([$login]);
    return $stmt->fetchColumn() > 0;
}

function validerSignup($email, $password) {
    $sql = "SELECT password FROM utilisateur WHERE email = :email";
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":email" => $email
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    
    //password_verify
    if ($result && password_verify($password, $result["password"])) {
        $sql_verify = "UPDATE utilisateur SET is_active = 1 WHERE email = :email";
        $stmt_update = $pdo->prepare($sql_verify);
        $stmt_update->execute([
            ":email" => $email,
        ]);
        return true;
    }
    return false;
}