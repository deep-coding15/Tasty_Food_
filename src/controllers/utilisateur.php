<?php $content = ob_get_clean(); ?>
<?php 
require_once __DIR__ ."/layout.php";
require_once __DIR__ .'/../../config/database.php';
require __DIR__ .'/../models/utilisateur.php';
$database = new Database();
$pdo = $database->getConnection();
$utilisateurRepository = new UtilisateurRepository();

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
            $login = $utilisateurRepository->genererLoginUnique($firstname, $lastname, $pdo);

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

            if($utilisateurRepository->validerSignup($email, $password)){
                echo "<p>Vos informations de connection sont corrects</p>";
            } else {
                echo "Vos informations de connection ne sont pas corrects";
            }
        }
    }
}



