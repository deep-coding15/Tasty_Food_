<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/database.php";

class Utilisateur
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $login;
    private string $password;
    private bool $is_active;
    private string $img_profil;
    private int $telephone;
    private DateTime $created_at;
    private DateTime $updated_at;
    private static int $nb_person = 0;

    public function __construct(int $id, string $firstname, string $lastname, string $email, string $login, string $password, bool $is_active, string $img_profil, int $telephone, DateTime $created_at, DateTime $updated_at)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->login = $login;
        $this->password = $password;
        $this->is_active = $is_active;
        $this->img_profil = BASE_URL . '/data/Profile/Images/' . $img_profil;
        //$this->img_profil = $img_profil;
        $this->telephone = $telephone;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        self::$nb_person++;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getLogin(): string
    {
        return $this->login;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function is_active(): bool
    {
        return $this->is_active;
    }
    public function getImgProfil(): string
    {
        return $this->img_profil;
    }
    public function getTelephone(): string
    {
        return $this->telephone;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }
    public function setImgProfil(string $img_profil): void
    {
        $this->img_profil = $img_profil;
    }
    public function setTelephone(int $telephone): void
    {
        $this->telephone = $telephone;
    }
    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt(DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * This functions return a complete path of the profile image for a specific person
     * @param string $img_profil the name of a file
     * @return string
     */
    public function getRealImgProfile(string $img_profil) : string {
        return BASE_URL . '/data/Profile/Images/' . $img_profil;
    }
}
include __DIR__ . "/../include/init.php";
require_once __DIR__ . "/../../config/config.php";

class UtilisateurRepository
{
    /**
     * Elle sert à accéder à la connexion partagée dans chaque instance de UtilisateurRepository.
     * @var 
     */
    public ?Database $database = null;

    /**
     * Pour utiliser une connexion partagée (singleton) dans UtilisateurRepository, 
     * Il faut déclarer une propriété statique pour la base de données et l’utiliser dans le constructeur.
     * @var 
     */
    private static ?Database $sharedDatabase = null; // Ajoute cette ligne
    private ?PDO $pdo = null;

    
    public function getPDO()
    {
        return $this->pdo;
    }
    public function __construct()
    {
        if (self::$sharedDatabase === null) {
            self::$sharedDatabase = new Database();
            $this->pdo = self::$sharedDatabase->getConnection();
        }
        //$this->session = $_session;
        $this->database = self::$sharedDatabase;
    }
    function genererLogin($prenom, $nom)
    {
        // Nettoyage de l’entrée : suppression des espaces, accents, etc.
        $prenom = strtolower(self::supprimerCaracteresSpeciaux($prenom));
        $nom = strtolower(self::supprimerCaracteresSpeciaux($nom));

        // Création du login : initiale du prénom + nom
        $login = substr($prenom, 0, 1) . $nom;

        return $login;
    }
    function supprimerCaracteresSpeciaux($texte)
    {
        $texte = iconv('UTF-8', 'ASCII//TRANSLIT', $texte); // Enlève les accents
        $texte = preg_replace('/[^a-zA-Z0-9]/', '', $texte); // Enlève caractères spéciaux
        return $texte;
    }
    function genererLoginUnique($prenom, $nom, $conn)
    {
        $baseLogin = self::genererLogin($prenom, $nom);
        $login = $baseLogin;
        $i = 1;

        // Vérifie dans la base si le login existe déjà
        while (self::loginExiste($login, $conn)) {
            $login = $baseLogin . $i;
            $i++;
        }

        return $login;
    }

    function loginExiste($login, $conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM utilisateur WHERE login = ?");
        $stmt->execute([$login]);
        return $stmt->fetchColumn() > 0;
    }



    /**
     * Permmet d'inserer un utilisateur dans la base de donnees lorsqu'on clique sur le formulaire de login
     * @param array $postData : table renvoyé par le formulaire
     * @return void
     */
    public function logIn(array $postData): bool
    {
        global $_session;
        echo 'hi';
        if (
            isset($postData["firstname"]) && trim($postData["firstname"]) != ""
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
            $login = self::genererLoginUnique($firstname, $lastname, $pdo);

            $sql = "INSERT INTO utilisateur(nom, prenom, login, password, img_profil, email, telephone, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $resultStatus = $this->database->executeSqlStatement($sql, [
                $lastname,
                $firstname,
                $login,
                password_hash($password, PASSWORD_DEFAULT),
                $image,
                $email,
                $telephone,
                false
            ]);

            $lastid = $this->database->connection->lastInsertId();
            //$this->connection->lastInsertId();

            if ($resultStatus) {
                $re = $resultStatus->fetch();
                echo $re;
                echo $lastid;
                $this->initialiserSessionUtilisateur($email);
                echo "Vos informations de connection ont été enregistré avec succès";
                return true;
            } else {
                echo "L'enregistrement a échoué";
                return false;
            }
        }
        return false;
    }

    function validerLogin($email, $password)
    {
        global $_session;
        $sql = "SELECT id_utilisateur, role, password, email FROM utilisateur WHERE email = :email";
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result || !password_verify($password, $result["password"])) {
            return false; // Échec de la connexion
        }

        // Récupération des informations
        $role = $result['role'];
        $id = $result['id_utilisateur'];
        $email = $result['email'];

        // Mise à jour du statut actif
        $sql_verify = "UPDATE utilisateur SET is_active = 1 WHERE email = :email";
        $stmt_update = $pdo->prepare($sql_verify);
        $stmt_update->execute([":email" => $email]);

        $_session->destroy();
        $_session = new SecureSession();
        $this->initialiserSessionUtilisateur($email);
        /* $_session->set('utilisateur', ['role' => $role]);
        $_session->set('utilisateur', ['email' =>  $email]);
        $_session->set('utilisateur', ['id' => $id]);
 */
        // Redirection en fonction du rôle
        global $_utilisateur;
        switch ($role) {
            case 'administrateur':
                $_utilisateur['role'] = 'administrateur';
                $_session->get('utilisateur')['role'] = 'administrateur';
                //$_utilisateur->set('role', 'administrateur');
                header('Location: ' . BASE_URL . '/src/templates/dashboard.php');
                exit();
                break;
            case 'visiteur':
                $_session->get('utilisateur')['role'] = 'visiteur';                
                //$_utilisateur->set('role', 'visiteur');
                header('Location: ' . BASE_URL . '/src/templates/menu.php');
                exit();
                break;
            case 'client':
                header('Location: ' . BASE_URL . '/src/templates/dashboard.php');
                exit();
                break;
            default:
                header('Location: ' . BASE_URL . '/src/templates/dashboard.php');
                exit();
                break;
        }

        exit(); // Important pour arrêter l'exécution après la redirection
    }
    public function signUp(array $postData)
    {
        //echo 'hi';
        global $_session;
        var_dump($_session);
        if (
            isset($postData["password"]) && trim($postData["password"]) != ""
            && isset($postData["email"]) && trim($postData["email"]) != ""
        ) {
            $password = trim($postData["password"]);
            $email = trim($postData["email"]);

            if ($this->validerLogin($email, $password)) {
                // La redirection est gérée dans la fonction
            } else {
                // Afficher un message d'erreur
                echo "Email ou mot de passe incorrect";
            }
            /* if (self::validerSignup($email, $password)) {
                $message = "Vos informations de connection sont corrects";
            } else {
                $message =  "Vos informations de connection ne sont pas corrects";
            } */
            /* $_session->set('MESSAGE', $message);
            SecureSession::getMessage($message);
 */
            /* if ($this->session->role()) {
                # code...
            } */
            //var_dump($this->session);
            //$this->redirectByRole();
            /* if ($this->session === 'visiteur') {
                (new Utils())->redirect(BASE_URL . '/index.php', 301);
            } else if ($this->session === 'admin') {
                (new Utils())->redirect(BASE_URL . '/src/templates/dashboard.php', 301);
            } */
        }
    }
    /* $this->session->set('utilisateur', [
            'id'         => $utilisateur['id_utilisateur']
 */
    public function redirectByRole(): void
    {
        global $_session;
        $roleRoutes = [
            'visiteur' => BASE_URL . '/index.php',
            'administrateur'    => BASE_URL . '/src/templates/dashboard.php',
        ];

        $user = $_session->get('utilisateur');
        $role = $user['role'] ?? 'visiteur';

        echo $role;
        echo "Redirection vers : " . $roleRoutes[$role];
        die();
        if (isset($roleRoutes[$role])) {
            (new Utils())->redirect($roleRoutes[$role], 301);
        } else {
            (new Utils())->redirect(BASE_URL . '/index.php', 301);
        }
    }

    function validerSignup($email, $password)
    {
        global $_session;
        $sql = "SELECT id_utilisateur, role, password, email FROM utilisateur WHERE email = :email";
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":email" => $email
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $role = $result['role'];
        $id = $result['id_utilisateur'];
        $email = $result['email'];

        //password_verify
        if ($result && password_verify($password, $result["password"])) {
            $sql_verify = "UPDATE utilisateur SET is_active = 1 WHERE email = :email";
            $stmt_update = $pdo->prepare($sql_verify);
            $stmt_update->execute([
                ":email" => $email,
            ]);
            $_session->destroy();
            try {
                $_session = new SecureSession();
                $this->initialiserSessionUtilisateur($email);
                $_session->role($role);
            } catch (RuntimeException $exception) {
                echo 'Utilisateur introuvable avec l\'email' . $email;
            }
            /* $this->initialiserSessionUtilisateur($id);
            $_session->role($role);
 */
            return true;
        }
        return false;
    }

    public function initialiserSessionUtilisateur(string $email): void
    {
        global $_session;
        $sql = "SELECT 
                id_utilisateur, 
                nom, 
                prenom, 
                login, 
                email, 
                is_active, 
                img_profil, 
                telephone, 
                role 
            FROM utilisateur 
            WHERE email = ?";

        $database = new Database();
        $pdo = $database->executeSqlStatement($sql, [$email]);
        $utilisateur = $pdo->fetch();

        if (!$utilisateur) {
            throw new RuntimeException("Utilisateur introuvable avec l'email : $email");
        }

        /* $roleID = self::role($utilisateur['role']);
        $_session = new SecureSession($roleID);
         */// Stocker toutes les données nécessaires sous une seule clé
        $_session->set('utilisateur', [
            'id'         => $utilisateur['id_utilisateur'],
            'nom'        => $utilisateur['nom'],
            'prenom'     => $utilisateur['prenom'],
            'login'      => $utilisateur['login'],
            'email'      => $utilisateur['email'],
            'is_active'  => (bool) $utilisateur['is_active'],
            'img_profil' => $utilisateur['img_profil'],
            'telephone'  => $utilisateur['telephone'],
            'role'       => $utilisateur['role'],
        ]);
    }

    public function reinitialiserSessionUtilisateur(string $email){
        global $_session;
        $sql = "SELECT 
                id_utilisateur, 
                nom, 
                prenom, 
                login, 
                email, 
                is_active, 
                img_profil, 
                telephone, 
                role 
            FROM utilisateur 
            WHERE email = ?";

        $database = new Database();
        $pdo = $database->executeSqlStatement($sql, [$email]);
        $utilisateur = $pdo->fetch();

        if (!$utilisateur) {
            throw new RuntimeException("Utilisateur introuvable avec l'email : $email");
        }

        /* $roleID = self::role($utilisateur['role']);
        $_session = new SecureSession($roleID);
         */// Stocker toutes les données nécessaires sous une seule clé
        $_session->destroy();
        $_session = new SecureSession();
        $_session->set('utilisateur', [
            'id'         => $utilisateur['id_utilisateur'],
            'nom'        => $utilisateur['nom'],
            'prenom'     => $utilisateur['prenom'],
            'login'      => $utilisateur['login'],
            'email'      => $utilisateur['email'],
            'is_active'  => (bool) $utilisateur['is_active'],
            'img_profil' => $utilisateur['img_profil'],
            'telephone'  => $utilisateur['telephone'],
            'role'       => $utilisateur['role'],
        ]);
    }

    private function role(string $role): int
    {
        switch ($role) {
            case 'visiteur':
                return 0;
            case 'client':
                return 1;
            case 'personnel':
                return 2;
            case 'administrateur':
                return 3;
            default:
                return 0;
        }
    }
}
