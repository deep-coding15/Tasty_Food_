<?php
require_once __DIR__.'/database.php';

class ImagesApi{
    private ?Database $database;
    // Clé API Unsplash
    private const CLIENT_ID = 'sv9znS0LDJPMBZCi0oJZ3WyuWOQDEcV_QREt4K8lisk';
    /**
     * Contient le resultat de la connexion avec la base de données en utilisant la classe PDO
     * @var 
     */
    private ?PDO $pdo;
    private static ?ImagesApi $instance = null; // Singleton
   
    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct() {
        $this->database = new Database();
        $this->pdo = $this->database->getConnection();
    }

    // Méthode statique pour obtenir l'instance unique
    public static function getInstance(): ImagesApi {
        if (self::$instance === null) {
            self::$instance = new ImagesApi();
        }
        return self::$instance;
    }

    /**
     * Cette function permet de rmemplir la base de donnees avec des images contenu dans une API : API d'unplash pour developpeurs
     * @return void
     */
    public function getImagesPlat()  {
        $sql = "SELECT id_plat, nom_plat FROM plats WHERE img_plats IS NULL OR img_plats = '' OR img_plats = 'default.jpg'";
        
        // Récupération des plats sans image
        $plats = $this->pdo->query($sql)->fetchAll();

        foreach ($plats as $plat) {
            self::fetchData($plat);
        } 
    }

    /**
     * Cette fonction permet de rechercher une image d'un plat specifique dans une API : l'API d'unplash pour developpeurs
     * @param int $id : represente l'id du plat
     * @return void
     */
    public function getImagePlatById(int $id) {
        $sql = "SELECT id_plat, nom_plat FROM plats WHERE (img_plats IS NULL OR img_plats = '' OR img_plats = 'default.jpg') AND id_plat = :id";
        
        // Récupération du plat par son id
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ":id"=> $id,
        ]);
        $plat = $statement->fetch();
        if ($plat) {
            self::fetchData($plat);
        }
    }

    private function fetchData(array $plat){
        $nom = $plat['nom_plat'];
        $id = $plat['id_plat'];

        // Préparation du nom du fichier
        $fileName = strtolower(str_replace(' ', '_', $nom)) . '.jpg';
        $filePath = __DIR__ . "/../data/Plats/Images/" . $fileName;

        // Skip si déjà téléchargé
        if (file_exists($filePath)) {
            //echo " $fileName existe déjà<br>";
            return;
        }

        // Requête vers Unsplash API
        $query = urlencode($nom);
        $clientId = self::CLIENT_ID;
        $url = "https://api.unsplash.com/search/photos?query=$query&client_id=$clientId&per_page=1";

        $json = json_decode(file_get_contents($url), true);

        if (isset($json['results'][0]['urls']['regular'])) {
            $imageUrl = $json['results'][0]['urls']['regular'];

            // Télécharger et enregistrer l'image
            file_put_contents($filePath, file_get_contents($imageUrl));

            // Mettre à jour la BDD
            $stmt = $this->pdo->prepare("UPDATE plats SET img_plats = ? WHERE id_plat = ?");
            $stmt->execute([$fileName, $id]);

            //echo " Image enregistrée pour '$nom' → $fileName<br>";
        } else {
            //echo " Aucune image trouvée pour '$nom'<br>";
        }

        // Pause légère pour respecter l’API (facultatif mais recommandé)
        sleep(2);
        
    }

}
?>
<?php
/* <!-- Application key : 775119 -->
<!-- Accès key : sv9znS0LDJPMBZCi0oJZ3WyuWOQDEcV_QREt4K8lisk -->
<!-- Secret key : ZD5tsn5jBFe1jRBUbbEQ4PvtizSIwiv7717kgpHM-_g --> */