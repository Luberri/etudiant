<?php
namespace App\Controllers;

use App\Models\Etudiant;
use Flight;

class EtudiantController {

    // GET /etudiants
    public static function getAll() {
        $model = new Etudiant(Flight::db());
        Flight::json($model->getAll());
    }

    // GET /etudiants/{id}
    public static function getById($id) {
        $model = new Etudiant(Flight::db());
        $etu = $model->getById($id);

        if ($etu)
            Flight::json($etu);
        else
            Flight::json(['error' => 'Etudiant not found'], 404);
    }

    // POST /etudiants
    public static function create() {
        $data = Flight::request()->data->getData();
        $model = new Etudiant(Flight::db());
        $model->create($data);

        Flight::json(['message' => 'Etudiant created'], 201);
    }

    // PUT /etudiants/{id}
    public static function update($id) {
        $data = Flight::request()->data->getData();
        $model = new Etudiant(Flight::db());
        $model->update($id, $data);

        Flight::json(['message' => 'Etudiant updated']);
    }

    // DELETE /etudiants/{id}
    public static function delete($id) {
        $model = new Etudiant(Flight::db());
        $model->delete($id);

        Flight::json(['message' => 'Etudiant deleted']);
    }
}
