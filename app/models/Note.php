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

    public function getNotesByEtudiantAndSemestre($idEtudiant, $semestre) {
        $sql = "SELECT n.idNote, n.note, m.nom AS matiere, c.credit
                FROM note n
                JOIN avancement a ON n.idAvancement = a.idAvancement
                JOIN matiere m ON n.idMatiere = m.idMatiere
                JOIN credit c ON m.idMatiere = c.idMatiere
                WHERE a.idEtudiant = :idEtudiant AND a.semestre = :semestre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idEtudiant' => $idEtudiant,
            ':semestre' => $semestre
        ]);
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