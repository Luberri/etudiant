<?php
namespace App\Controllers;

use App\Models\ResultatEpreuve;

class ResultatEpreuveController {
    private $model;

    public function __construct() {
        $this->model = new ResultatEpreuve(\Flight::db());
    }

    public function tempsParSpeciale() {
        $resultats = $this->model->getTempsParSpeciale();
        \Flight::json($resultats);
    }
}