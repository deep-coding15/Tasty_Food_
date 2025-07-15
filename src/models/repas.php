<?php
require_once(dirname(__FILE__) ."/../config/database.php");

class Repas{
    private int $id_repas;
    private string $nom_repas;
    private float $prix_repas;
    private DateTime $date_repas;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function getIdRepas(): int {
        return $this->id_repas;
    }

    public function setIdRepas(int $id_repas): void {
        $this->id_repas = $id_repas;
    }

    public function getNomRepas(): string {
        return $this->nom_repas;
    }

    public function setNomRepas(string $nom_repas): void {
        $this->nom_repas = $nom_repas;
    }

    public function getPrixRepas(): float {
        return $this->prix_repas;
    }

    public function setPrixRepas(float $prix_repas): void {
        $this->prix_repas = $prix_repas;
    }

    public function getDateRepas(): DateTime {
        return $this->date_repas;
    }

    public function setDateRepas(DateTime $date_repas): void {
        $this->date_repas = $date_repas;
    }

    public function getCreatedAt(): DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): DateTime {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): void {
        $this->updated_at = $updated_at;
    }

}