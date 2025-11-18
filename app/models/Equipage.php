<?php
namespace App\Models;

use PDO;

class Equipage {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les équipages avec leurs informations complètes
    public function getEquipageAll() {
        $sql = "SELECT e.*, 
                       p.nom as pilote_nom, p.prenom as pilote_prenom,
                       c.nom as copilote_nom, c.prenom as copilote_prenom,
                       cat.nom_categorie
                FROM equipage e
                JOIN pilote p ON e.id_pilote = p.id
                JOIN copilote c ON e.id_copilote = c.id
                JOIN categorie cat ON e.id_categorie = cat.id
                ORDER BY e.numero_equipage";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un équipage par son ID
    public function getEquipageById($id) {
        $sql = "SELECT e.*, 
                       p.nom as pilote_nom, p.prenom as pilote_prenom,
                       c.nom as copilote_nom, c.prenom as copilote_prenom,
                       cat.nom_categorie
                FROM equipage e
                JOIN pilote p ON e.id_pilote = p.id
                JOIN copilote c ON e.id_copilote = c.id
                JOIN categorie cat ON e.id_categorie = cat.id
                WHERE e.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer un équipage par son numéro
    public function getEquipageByNumero($numero) {
        $sql = "SELECT e.*, 
                       p.nom as pilote_nom, p.prenom as pilote_prenom,
                       c.nom as copilote_nom, c.prenom as copilote_prenom,
                       cat.nom_categorie
                FROM equipage e
                JOIN pilote p ON e.id_pilote = p.id
                JOIN copilote c ON e.id_copilote = c.id
                JOIN categorie cat ON e.id_categorie = cat.id
                WHERE e.numero_equipage = :numero";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un nouvel équipage
    public function createEquipage($data) {
        $sql = "INSERT INTO equipage (id_pilote, id_copilote, id_categorie, numero_equipage) 
                VALUES (:id_pilote, :id_copilote, :id_categorie, :numero_equipage)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pilote', $data['id_pilote'], PDO::PARAM_INT);
        $stmt->bindParam(':id_copilote', $data['id_copilote'], PDO::PARAM_INT);
        $stmt->bindParam(':id_categorie', $data['id_categorie'], PDO::PARAM_INT);
        $stmt->bindParam(':numero_equipage', $data['numero_equipage'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Mettre à jour un équipage
    public function updateEquipage($id, $data) {
        $sql = "UPDATE equipage 
                SET id_pilote = :id_pilote, 
                    id_copilote = :id_copilote, 
                    id_categorie = :id_categorie, 
                    numero_equipage = :numero_equipage 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_pilote', $data['id_pilote'], PDO::PARAM_INT);
        $stmt->bindParam(':id_copilote', $data['id_copilote'], PDO::PARAM_INT);
        $stmt->bindParam(':id_categorie', $data['id_categorie'], PDO::PARAM_INT);
        $stmt->bindParam(':numero_equipage', $data['numero_equipage'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Supprimer un équipage
    public function deleteEquipage($id) {
        $sql = "DELETE FROM equipage WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupérer les équipages par catégorie
    public function getEquipageByCategorie($id_categorie) {
        $sql = "SELECT e.*, 
                       p.nom as pilote_nom, p.prenom as pilote_prenom,
                       c.nom as copilote_nom, c.prenom as copilote_prenom,
                       cat.nom_categorie
                FROM equipage e
                JOIN pilote p ON e.id_pilote = p.id
                JOIN copilote c ON e.id_copilote = c.id
                JOIN categorie cat ON e.id_categorie = cat.id
                WHERE e.id_categorie = :id_categorie
                ORDER BY e.numero_equipage";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifier si un pilote est déjà dans un équipage
    public function isPiloteInEquipage($id_pilote) {
        $sql = "SELECT COUNT(*) FROM equipage WHERE id_pilote = :id_pilote";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pilote', $id_pilote, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Vérifier si un copilote est déjà dans un équipage
    public function isCopiloteInEquipage($id_copilote) {
        $sql = "SELECT COUNT(*) FROM equipage WHERE id_copilote = :id_copilote";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_copilote', $id_copilote, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Récupérer les résultats d'un équipage
    public function getResultatsEquipage($id_equipage) {
        $sql = "SELECT re.*, es.nom as epreuve_nom, es.distance
                FROM resultat_epreuve re
                JOIN epreuves_speciales es ON re.id_epreuve = es.id
                WHERE re.id_equipage = :id_equipage
                ORDER BY es.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_equipage', $id_equipage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}