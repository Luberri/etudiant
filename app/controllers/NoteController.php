<?php
namespace App\Controllers;

use App\Models\Note;

class NoteController {
    private $model;

    public function __construct() {
        $this->model = new Note(\Flight::db());
    }

    // Récupère toutes les notes
    public function getAllNotes() {
        try {
            $notes = $this->model->getAllNotes();
            $this->sendResponse('success', $notes);
        } catch (\Exception $e) {
            $this->sendError(500, 'Erreur lors de la récupération des notes', $e->getMessage());
        }
    }

    public function getNotesByEtudiantAndSemestre($idEtudiant, $semestre) {
        try {
            $notes = $this->model->getNotesByEtudiantAndSemestre($idEtudiant, $semestre);
            $this->sendResponse('success', $notes);
        } catch (\Exception $e) {
            $this->sendError(500, 'Erreur lors de la récupération des notes pour l\'étudiant et le semestre', $e->getMessage());
        }
    }

    public function addNote() {
        try {
            $data = \Flight::request()->data->getData();
            $success = $this->model->addNote(
                $data['idAvancement'],
                $data['idMatiere'],
                $data['note']
            );
            if ($success) {
                $this->sendResponse('success', ['message' => 'Note ajoutée avec succès']);
            } else {
                $this->sendError(400, 'Impossible d\'ajouter la note');
            }
        } catch (\Exception $e) {
            $this->sendError(500, 'Erreur lors de l\'ajout de la note', $e->getMessage());
        }
    }

    private function sendResponse($status, $data = null, $meta = null) {
        \Flight::json([
            'status' => $status,
            'data' => $data,
            'error' => null,
            'meta' => $meta
        ]);
    }

    private function sendError($code, $message, $details = null) {
        \Flight::json([
            'status' => 'error',
            'data' => null,
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details
            ],
            'meta' => null
        ], $code);
    }
}