<?php
namespace App\Models;

use PDO;

class Pilote {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les pilotes
    public function getAllPilotes() {
        $sql = "SELECT * FROM pilote ORDER BY nom, prenom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un pilote par son ID
    public function getPiloteById($id) {
        $sql = "SELECT * FROM pilote WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un nouveau pilote
    public function createPilote($data) {
        $sql = "INSERT INTO pilote (nom, prenom) VALUES (:nom, :prenom)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Mettre à jour un pilote
    public function updatePilote($id, $data) {
        $sql = "UPDATE pilote SET nom = :nom, prenom = :prenom WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Supprimer un pilote
    public function deletePilote($id) {
        // Vérifier d'abord si le pilote est dans un équipage
        $checkSql = "SELECT COUNT(*) FROM equipage WHERE id_pilote = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        
        if ($checkStmt->fetchColumn() > 0) {
            return false; // Ne peut pas supprimer, pilote dans un équipage
        }

        $sql = "DELETE FROM pilote WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Rechercher des pilotes par nom
    public function searchPiloteByName($search) {
        $sql = "SELECT * FROM pilote 
                WHERE nom ILIKE :search OR prenom ILIKE :search 
                ORDER BY nom, prenom";
        $stmt = $this->db->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les pilotes disponibles (pas encore dans un équipage)
    public function getPilotesDisponibles() {
        $sql = "SELECT p.* FROM pilote p 
                LEFT JOIN equipage e ON p.id = e.id_pilote 
                WHERE e.id_pilote IS NULL 
                ORDER BY p.nom, p.prenom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer l'équipage d'un pilote s'il existe
    public function getEquipagePilote($id_pilote) {
        $sql = "SELECT e.*, 
                       p.nom as pilote_nom, p.prenom as pilote_prenom,
                       c.nom as copilote_nom, c.prenom as copilote_prenom,
                       cat.nom_categorie
                FROM equipage e
                JOIN pilote p ON e.id_pilote = p.id
                JOIN copilote c ON e.id_copilote = c.id
                JOIN categorie cat ON e.id_categorie = cat.id
                WHERE e.id_pilote = :id_pilote";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pilote', $id_pilote, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si un pilote existe
    public function piloteExists($id) {
        $sql = "SELECT COUNT(*) FROM pilote WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Compter le nombre total de pilotes
    public function countPilotes() {
        $sql = "SELECT COUNT(*) FROM pilote";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    // Récupérer les pilotes avec pagination
    public function getPilotesWithPagination($limit, $offset) {
        $sql = "SELECT * FROM pilote 
                ORDER BY nom, prenom 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifier si un pilote avec ce nom/prénom existe déjà
    public function checkDuplicatePilote($nom, $prenom, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM pilote WHERE nom = :nom AND prenom = :prenom";
        if ($excludeId) {
            $sql .= " AND id != :excludeId";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        
        if ($excludeId) {
            $stmt->bindParam(':excludeId', $excludeId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}