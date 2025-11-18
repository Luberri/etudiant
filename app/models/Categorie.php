<?php
namespace App\Models;

use PDO;

class Categorie {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les catégories
    public function getAllCategories() {
        $sql = "SELECT * FROM categorie ORDER BY nom_categorie";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une catégorie par son ID
    public function getCategorieById($id) {
        $sql = "SELECT * FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer une nouvelle catégorie
    public function createCategorie($data) {
        $sql = "INSERT INTO categorie (nom_categorie) VALUES (:nom_categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom_categorie', $data['nom_categorie'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Mettre à jour une catégorie
    public function updateCategorie($id, $data) {
        $sql = "UPDATE categorie SET nom_categorie = :nom_categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom_categorie', $data['nom_categorie'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Supprimer une catégorie
    public function deleteCategorie($id) {
        // Vérifier d'abord si la catégorie est utilisée par des équipages
        $checkSql = "SELECT COUNT(*) FROM equipage WHERE id_categorie = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        
        if ($checkStmt->fetchColumn() > 0) {
            return false; // Ne peut pas supprimer, catégorie utilisée
        }

        $sql = "DELETE FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Rechercher des catégories par nom
    public function searchCategorieByName($search) {
        $sql = "SELECT * FROM categorie 
                WHERE nom_categorie ILIKE :search 
                ORDER BY nom_categorie";
        $stmt = $this->db->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les équipages d'une catégorie
    public function getEquipagesByCategorie($id_categorie) {
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

    // Vérifier si une catégorie existe
    public function categorieExists($id) {
        $sql = "SELECT COUNT(*) FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Compter le nombre d'équipages par catégorie
    public function countEquipagesByCategorie($id_categorie) {
        $sql = "SELECT COUNT(*) FROM equipage WHERE id_categorie = :id_categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Vérifier si une catégorie avec ce nom existe déjà
    public function checkDuplicateCategorie($nom_categorie, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM categorie WHERE nom_categorie = :nom_categorie";
        if ($excludeId) {
            $sql .= " AND id != :excludeId";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom_categorie', $nom_categorie, PDO::PARAM_STR);
        
        if ($excludeId) {
            $stmt->bindParam(':excludeId', $excludeId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Récupérer les statistiques d'une catégorie
    public function getCategorieStats($id_categorie) {
        $sql = "SELECT 
                    cat.nom_categorie,
                    COUNT(DISTINCT e.id) as nb_equipages,
                    COUNT(re.id) as nb_participations_epreuves,
                    COUNT(CASE WHEN re.abandon = TRUE THEN 1 END) as nb_abandons,
                    AVG(CASE WHEN re.abandon = FALSE THEN re.penalite END) as penalite_moyenne
                FROM categorie cat
                LEFT JOIN equipage e ON cat.id = e.id_categorie
                LEFT JOIN resultat_epreuve re ON e.id = re.id_equipage
                WHERE cat.id = :id_categorie
                GROUP BY cat.id, cat.nom_categorie";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer toutes les catégories avec le nombre d'équipages
    public function getCategoriesWithCount() {
        $sql = "SELECT c.*, COUNT(e.id) as nb_equipages
                FROM categorie c
                LEFT JOIN equipage e ON c.id = e.id_categorie
                GROUP BY c.id, c.nom_categorie
                ORDER BY c.nom_categorie";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifier si la catégorie peut être supprimée
    public function canDeleteCategorie($id) {
        $sql = "SELECT COUNT(*) FROM equipage e
                JOIN resultat_epreuve re ON e.id = re.id_equipage
                WHERE e.id_categorie = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }
}