<?php
namespace App\Models;

use PDO;

class Note {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllNotes() {
        $sql = "SELECT n.idNote, n.idAvancement, n.idMatiere, n.note, 
                       a.semestre, m.nom AS matiere
                FROM note n
                JOIN avancement a ON n.idAvancement = a.idAvancement
                JOIN matiere m ON n.idMatiere = m.idMatiere
                ORDER BY n.idNote";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNotesByEtudiantAndSemestre($idEtudiant, $semestre, $idOption = null) {
        $sql = "SELECT 
                    n.idNote,
                    n.note,
                    m.nom AS matiere,
                    c.credit,
                    o.nom AS optionNom,
                    a.semestre
                FROM note n
                JOIN avancement a ON n.idAvancement = a.idAvancement
                JOIN matiere m ON n.idMatiere = m.idMatiere
                JOIN credit c ON m.idMatiere = c.idMatiere
                JOIN option_ o ON c.idOption = o.idOption
                WHERE a.idEtudiant = :idEtudiant
                  AND a.semestre = :semestre";
    
        // Ajout de la condition pour l'option si elle est spécifiée
        if ($idOption !== null) {
            $sql .= " AND c.idOption = :idOption";
        }
    
        $stmt = $this->db->prepare($sql);
    
        // Préparation des paramètres
        $params = [
            ':idEtudiant' => $idEtudiant,
            ':semestre' => $semestre
        ];
    
        if ($idOption !== null) {
            $params[':idOption'] = $idOption;
        }
    
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addNote($idAvancement, $idMatiere, $note) {
        $sql = "INSERT INTO note (idAvancement, idMatiere, note) 
                VALUES (:idAvancement, :idMatiere, :note)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':idAvancement' => $idAvancement,
            ':idMatiere' => $idMatiere,
            ':note' => $note
        ]);
    }
}