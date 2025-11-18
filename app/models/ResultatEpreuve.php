<?php
namespace App\Models;

use PDO;

class ResultatEpreuve {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupère les temps par spéciale
    public function getTempsParSpeciale() {
        $sql = "SELECT es.id, es.nom, es.distance, re.temps, re.penalite, re.abandon, e.numero_equipage
                FROM resultat_epreuve re
                JOIN epreuves_speciales es ON re.id_epreuve = es.id
                JOIN equipage e ON re.id_equipage = e.id
                ORDER BY es.id, re.temps";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}