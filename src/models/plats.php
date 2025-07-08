<?php

    require_once __DIR__ ."/../config.php";
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
        $this->img_plat = BASE_URL . '/data/Plats/' . $img_plats;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->deleted_at = $deleted_at;
        $this->type_menu = $type_plats;
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
        return BASE_URL . '/data/Plats/' . $this->img_plat;
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

class PlatRepository
{
    public ?PDO $database = null;

    public function dbConnect()
    {
        if( $this->database === null ) {
            $this->database = new PDO('mysql:host=localhost;dbname=restaurant_tasty_food;charset=utf8', 'root', '');
        }
    }
    public function getPlat(int $identifier) : Plat|null {
        $this->dbConnect();
        $sql = "SELECT id_plat, nom_plat, description, img_plats, created_at, updated_at, deleted_at, prix_plats, type_plats 
                FROM plats 
                WHERE id_plat = ?";
        $statement = $this->database->prepare($sql);
        $statement->execute([
            $identifier
        ]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $description = ($data["description"]) ? $data["description"] : '';
            return new Plat(
                $data['id_plat'],
                $data['nom_plat'],
                $description,
                $data['img_plats'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                new DateTime($data['deleted_at']),
                $data['type_plats'],
                (float) $data['prix_plats'],
            );
        }

        return null;

    }

    public function getPlats() : array 
    {
        $this->dbConnect();

        $sql = "SELECT id_plat, nom_plat, description, img_plats, created_at, updated_at, deleted_at, prix_plats, type_plats 
                FROM plats";

        $statement = $this->database->prepare($sql);
        $statement->execute([]);


        $plats = [];
        while (($data = $statement->fetch(PDO::FETCH_ASSOC))) {
            $description = ($data["description"]) ? $data["description"] : '';

            $plat = new Plat(
                $data['id_plat'],
                $data['nom_plat'],
                $description,
                $data['img_plats'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                new DateTime($data['deleted_at']),
                $data['type_plats'],
                (float) $data['prix_plats'],
            );

            $plats[] = $plat;
        }

        return $plats;
    }
}

