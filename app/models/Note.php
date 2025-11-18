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
    public function getMoyenne($idEtudiant, $semestre, $idOption) {
        $sql = "SELECT AVG(n.note) AS moyenne
                FROM note n
                JOIN avancement a ON n.idAvancement = a.idAvancement
                JOIN matiere m ON n.idMatiere = m.idMatiere
                JOIN credit c ON m.idMatiere = c.idMatiere
                WHERE a.idEtudiant = :idEtudiant
                  AND a.semestre = :semestre
                  AND c.idOption = :idOption";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idEtudiant' => $idEtudiant,
            ':semestre' => $semestre,
            ':idOption' => $idOption
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['moyenne'] ?? null;
    }

    public function getNotesAnnuelByEtudiant($idEtudiant, $annee, $idOption) {
        $semestres = [];
        if ($annee == 1) {
            $semestres = ['S1', 'S2'];
        } elseif ($annee == 2) {
            $semestres = ['S3', 'S4'];
        } else {
            return [];
        }
    
        $in  = str_repeat('?,', count($semestres) - 1) . '?';
        $sql = "SELECT 
                    n.idNote,
                    n.note,
                    m.nom AS matiere,
                    c.credit,
                    a.semestre,
                    o.nom AS optionNom
                FROM note n
                JOIN avancement a ON n.idAvancement = a.idAvancement
                JOIN matiere m ON n.idMatiere = m.idMatiere
                JOIN credit c ON m.idMatiere = c.idMatiere
                JOIN option_ o ON c.idOption = o.idOption
                WHERE a.idEtudiant = ?
                  AND c.idOption = ?
                  AND a.semestre IN ($in)
                ORDER BY a.semestre ASC, m.nom ASC";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_merge([$idEtudiant, $idOption], $semestres));
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getMoyenneAnnuel($idEtudiant, $annee, $idOption = 1) {
        $semestres = [];
        if ($annee == 1) {
            $semestres = ['S1', 'S2'];
        } elseif ($annee == 2) {
            $semestres = ['S3', 'S4'];
        } else {
            return null;
        }
    
        $in  = str_repeat('?,', count($semestres) - 1) . '?';
        $sql = "SELECT SUM(n.note * c.credit) / SUM(c.credit) AS moyenne_annuelle
                FROM note n
                JOIN avancement a ON n.idAvancement = a.idAvancement
                JOIN matiere m ON n.idMatiere = m.idMatiere
                JOIN credit c ON m.idMatiere = c.idMatiere
                WHERE a.idEtudiant = ?
                  AND c.idOption = ?
                  AND a.semestre IN ($in)";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_merge([$idEtudiant, $idOption], $semestres));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['moyenne_annuelle'] ?? null;
    }
     
}