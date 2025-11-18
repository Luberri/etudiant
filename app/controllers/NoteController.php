<?php
namespace App\Controllers;

use App\Models\Note;

class NoteController {
    private $model;

    public function __construct() {
        $this->model = new Note(\Flight::db());
    }

    public function getAllNotes() {
        $notes = $this->model->getAllNotes();
        \Flight::json($notes);
    }

    public function getNotesByEtudiantAndSemestre($idEtudiant, $semestre) {
        $notes = $this->model->getNotesByEtudiantAndSemestre($idEtudiant, $semestre);
        \Flight::json($notes);
    }

    // Ajoute une nouvelle note
    public function addNote() {
        $data = \Flight::request()->data->getData();
        $success = $this->model->addNote(
            $data['idAvancement'],
            $data['idMatiere'],
            $data['note']
        );
        \Flight::json(['success' => $success]);
    }
}