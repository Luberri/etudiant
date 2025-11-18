<?php
namespace App\Models;

use PDO;

class Copilote {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les copilotes
    public function getAllCopilotes() {
        $sql = "SELECT * FROM copilote ORDER BY nom, prenom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un copilote par son ID
    public function getCopiloteById($id) {
        $sql = "SELECT * FROM copilote WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un nouveau copilote
    public function createCopilote($data) {
        $sql = "INSERT INTO copilote (nom, prenom) VALUES (:nom, :prenom)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Mettre à jour un copilote
    public function updateCopilote($id, $data) {
        $sql = "UPDATE copilote SET nom = :nom, prenom = :prenom WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Supprimer un copilote
    public function deleteCopilote($id) {
        // Vérifier d'abord si le copilote est dans un équipage
        $checkSql = "SELECT COUNT(*) FROM equipage WHERE id_copilote = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        
        if ($checkStmt->fetchColumn() > 0) {
            return false; // Ne peut pas supprimer, copilote dans un équipage
        }

        $sql = "DELETE FROM copilote WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Rechercher des copilotes par nom
    public function searchCopiloteByName($search) {
        $sql = "SELECT * FROM copilote 
                WHERE nom ILIKE :search OR prenom ILIKE :search 
                ORDER BY nom, prenom";
        $stmt = $this->db->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les copilotes disponibles (pas encore dans un équipage)
    public function getCopilotesDisponibles() {
        $sql = "SELECT c.* FROM copilote c 
                LEFT JOIN equipage e ON c.id = e.id_copilote 
                WHERE e.id_copilote IS NULL 
                ORDER BY c.nom, c.prenom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer l'équipage d'un copilote s'il existe
    public function getEquipageCopilote($id_copilote) {
        $sql = "SELECT e.*, 
                       p.nom as pilote_nom, p.prenom as pilote_prenom,
                       c.nom as copilote_nom, c.prenom as copilote_prenom,
                       cat.nom_categorie
                FROM equipage e
                JOIN pilote p ON e.id_pilote = p.id
                JOIN copilote c ON e.id_copilote = c.id
                JOIN categorie cat ON e.id_categorie = cat.id
                WHERE e.id_copilote = :id_copilote";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_copilote', $id_copilote, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si un copilote existe
    public function copiloteExists($id) {
        $sql = "SELECT COUNT(*) FROM copilote WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Compter le nombre total de copilotes
    public function countCopilotes() {
        $sql = "SELECT COUNT(*) FROM copilote";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    // Récupérer les copilotes avec pagination
    public function getCopilotesWithPagination($limit, $offset) {
        $sql = "SELECT * FROM copilote 
                ORDER BY nom, prenom 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifier si un copilote avec ce nom/prénom existe déjà
    public function checkDuplicateCopilote($nom, $prenom, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM copilote WHERE nom = :nom AND prenom = :prenom";
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

    // Récupérer les statistiques des copilotes
    public function getCopiloteStats($id_copilote) {
        $sql = "SELECT 
                    COUNT(re.id) as nb_epreuves,
                    COUNT(CASE WHEN re.abandon = FALSE THEN 1 END) as nb_terminees,
                    COUNT(CASE WHEN re.abandon = TRUE THEN 1 END) as nb_abandons,
                    AVG(CASE WHEN re.abandon = FALSE THEN re.penalite END) as penalite_moyenne
                FROM equipage e
                LEFT JOIN resultat_epreuve re ON e.id = re.id_equipage
                WHERE e.id_copilote = :id_copilote";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_copilote', $id_copilote, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si le copilote peut être supprimé (n'est pas dans un équipage avec des résultats)
    public function canDeleteCopilote($id) {
        $sql = "SELECT COUNT(*) FROM equipage e
                JOIN resultat_epreuve re ON e.id = re.id_equipage
                WHERE e.id_copilote = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }
}