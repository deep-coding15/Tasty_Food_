<?php
    require_once __DIR__ ."/../include/SecureSession.php"; //A mettre en place apres avoir fini les plats
    require_once __DIR__ ."/../../config/config.php";
    require_once __DIR__ ."/../../config/database.php";
class Plat{
    private int $id_plat;
    private string $nom_plat;
    private string $img_plat;
    private string $description;
    private DateTime $created_at;
    private DateTime $updated_at;
    private DateTime $deleted_at;
    private string $type_plats;
    private float $prix_plat;

    private static int $nb_plats = 0;

    /**
     * Summary of __construct
     * @param string $nom_plat
     * @param string $img_plat contient le chemin ou se trouve l'image du plat. Il est stocke dans le dossier upload qui se trouve dans le dossier data
     * @param string $type_menu : entree, plat de resistance, accompagnements, desserts
     * @param float $prix_plat
     */
    public function __construct(int $id_plat, string $nom_plat, string $description, string $img_plats, DateTime $created_at, DateTime $updated_at, DateTime $deleted_at, string $type_plats, Float $prix_plats){
        $this->id_plat = $id_plat;
        $this->nom_plat = $nom_plat;
        $this->description = $description;
        $this->img_plat = BASE_URL . '/data/Plats/Images/' . $img_plats;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->deleted_at = $deleted_at;
        $this->type_plats = $type_plats;
        $this->prix_plat = $prix_plats;
        self::$nb_plats++;
    }    

   /*  // 🧹 Destructeur (facultatif)
    public function __destruct() {
        self::$nb_plats--;
        // Exemple : log ou nettoyage
        echo "Le plat '{$this->nom_plat}' a été supprimé.";
    } */
 
    //Setters && Getters
    // id_plat
    public function getIdPlat(): int {
        return $this->id_plat;
    }

    public function setIdPlat(int $id_plat): void {
        $this->id_plat = $id_plat;
    }

    // nom_plat
    public function getNomPlat(): string {
        return $this->nom_plat;
    }

    public function setNomPlat(string $nom_plat): void {
        $this->nom_plat = $nom_plat;
    }

    // img_plat
    public function getImgPlat(): string {
        return $this->img_plat;
    }

    public function setImgPlat(string $img_plat): void {
        $this->img_plat = $img_plat;
    }

    public function getRealImgPlat(){
        return BASE_URL . '/data/Plats/Images/' . $this->img_plat;
    }

    // description
    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    // created_at
    public function getCreatedAt(): DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void {
        $this->created_at = $created_at;
    }

    // updated_at
    public function getUpdatedAt(): DateTime {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): void {
        $this->updated_at = $updated_at;
    }

    // deleted_at
    public function getDeletedAt(): DateTime {
        return $this->deleted_at;
    }

    public function setDeletedAt(DateTime $deleted_at): void {
        $this->deleted_at = $deleted_at;
    }

    // type_plats
    public function getTypePlats(): string {
        return $this->type_plats;
    }

    public function setTypePlats(string $type_plats): void {
        $this->type_plats = $type_plats;
    }

    // prix_plat
    public function getPrixPlat(): float {
        return $this->prix_plat;
    }

    public function setPrixPlat(float $prix_plat): void {
        $this->prix_plat = $prix_plat;
    }

    public static function getNombrePlats(){
        return self::$nb_plats;
    }
}

/* enum Statut {
    case en_attente;
    case en_cours;
    case livree;
    case annulee;
}


 */class Commandes{
    private int $id_commande;
    private int $id_client;
    private DateTime $date_commande;
    //private Statut $statut; 
    private float $montant_total;
}

class PanierPlats{
    private int $id_commande;
    private int $id_client;
    private array $plats;
}

require_once __DIR__ . '/../../config/api_images.php';
class PlatRepository
{
    /**
     * Elle sert à accéder à la connexion partagée dans chaque instance de PlatRepository.
     * @var 
     */
    public ?Database $database = null; 

    /**
     * Pour utiliser une connexion partagée (singleton) dans PlatRepository, 
     * Il faut déclarer une propriété statique pour la base de données et l’utiliser dans le constructeur.
     * @var 
     */
    private static ?Database $sharedDatabase = null; // Ajoute cette ligne

    public function __construct(){
        if (self::$sharedDatabase === null) {
            self::$sharedDatabase = new Database();
        }
        $this->database = self::$sharedDatabase;
    }

    public function setImagesByAPI(){
        $imagesApi = ImagesApi::getInstance();
        $imagesApi->getImagesPlat();
    }

    public function getPlat(int $identifier) : Plat|null {
        $sql = "SELECT id_plat, nom_plat, description, img_plats, created_at, updated_at, deleted_at, prix_plats, type_plats 
                FROM plats 
                WHERE id_plat = ?";

        $pdo = $this->database->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $identifier
        ]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return self::fetchData($data);
        }

        return null;

    }

    public function getPlats() : array 
    {

        $sql = "SELECT id_plat, nom_plat, description, img_plats, created_at, updated_at, deleted_at, prix_plats, type_plats 
                FROM plats";

        $pdo = $this->database->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->execute([]);


        $plats = [];
        while (($data = $statement->fetch(PDO::FETCH_ASSOC))) {
            $plat = self::fetchData($data);

            $plats[] = $plat;
        }
        $this->setImagesByAPI();
        return $plats;
    }

    /**
     * This function return an array of plats that it sorted by the id of the type of the plat
     * 1 - Accompagnements
     * 2 - Desserts
     * 3 - Entrees
     * 4 - Plat de resistance
     * 5 - Boissons
     * 6 - Default
     */
    function getPlatsByType(int $type_id)
    {
        $sql = "SELECT * FROM plats p JOIN type_plat tp ON  p.type_plats = tp.type_plat_id WHERE tp.type_plat_id = :type_id";
        
        $pdo = $this->database->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ":type_id"=> $type_id
        ]);
        
        $plats = [];
        while (($data = $statement->fetch(PDO::FETCH_ASSOC))) {
            $plat = self::fetchData($data);
            $plats[] = $plat;
        }
        return $plats;
    }

    /**
     * This function return an array of plats that it sorted by the name of the type of the plat
     * 1 - Accompagnements
     * 2 - Desserts
     * 3 - Entrees
     * 4 - Plat de résistance
     * 5 - Boissons
     * 6 - Default
     */
    function getPlatsByTypeName(string $type_name)
    {
        $sql = "SELECT * FROM plats p JOIN type_plat tp ON  p.type_plats = tp.type_plat_id WHERE tp.type_plat_nom = :type_nom";
        
        $pdo = $this->database->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ":type_nom"=> trim($type_name),
        ]);
        
        $plats = [];
        while (($data = $statement->fetch(PDO::FETCH_ASSOC))) {
            $plat = self::fetchData($data);
            $plats[] = $plat;
        }
        return $plats;
    }
    

    /**
     * This function is to fetch a single data from the result of the database query
     * @param array $data
     * @return Plat
     */
    private function fetchData(array $data){
        //$description = ($data["description"]) ? $data["description"] : '';
        $nom_plat = !empty($data['nom_plat']) ? $data['nom_plat'] : 'Unnamed Plat';
        $description = !empty($data["description"]) ? $data["description"] : '';
        $img_plats = !empty($data["img_plats"]) ? $data["img_plats"] : 'default.jpg';

        // Gestion des dates nulles ou vides
        $created_at = !empty($data['created_at']) ? new DateTime($data['created_at']) : new DateTime();
        $updated_at = !empty($data['updated_at']) ? new DateTime($data['updated_at']) : new DateTime();
        $deleted_at = !empty($data['deleted_at']) ? new DateTime($data['deleted_at']) : new DateTime();

        $type_plats = !empty($data['type_plats']) ? $data['type_plats'] : '';
        $prix_plats = isset($data['prix_plats']) ? (float)$data['prix_plats'] : 0.0;


        $plat = new Plat(
            (int)$data['id_plat'],
            $data['nom_plat'],
            $description,
            $img_plats,
            $created_at,
            $updated_at,
            $deleted_at,
            $type_plats,
            $prix_plats,
        );
        return $plat;
    }

}

