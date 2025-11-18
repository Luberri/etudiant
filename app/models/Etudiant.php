<?php
namespace App\Models;

use PDO;

class Etudiant {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les étudiants
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM etudiant ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un étudiant par son ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM etudiant WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Créer un étudiant
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO etudiant (ETU, nom, prenom, dtn)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['ETU'],
            $data['nom'],
            $data['prenom'],
            $data['dtn']
        ]);
    }

    // Mettre à jour un étudiant
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE etudiant 
            SET ETU = ?, nom = ?, prenom = ?, dtn = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['ETU'],
            $data['nom'],
            $data['prenom'],
            $data['dtn'],
            $id
        ]);
    }

    // Supprimer un étudiant
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM etudiant WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
