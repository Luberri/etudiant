<?php 
namespace App\Controllers;

use App\Models\Note;
use Flight;

class NoteController {
    private $model;

    public function __construct() {
        $this->model = new Note(\Flight::db());
    }

    public function getAllNotes() {
        try {
            $notes = $this->model->getAllNotes();
            $this->sendResponse('success', $notes);
        } catch (\Exception $e) {
            $this->sendError(500, 'Erreur lors de la récupération des notes', $e->getMessage());
        }
    }

    public function getNotesByEtudiantAndSemestre($idEtudiant, $semestre, $idOption) {
        try {
            $notes = $this->model->getNotesByEtudiantAndSemestre($idEtudiant, $semestre, $idOption);

            $moyenne = null;
            if (!empty($notes)) {
                $total = 0;
                $totalCredits = 0;
                foreach ($notes as $n) {
                    $total += $n['note'] * $n['credit'];
                    $totalCredits += $n['credit'];
                }
                $moyenne = $totalCredits > 0 ? round($total / $totalCredits, 2) : null;
            }

            $this->sendResponse('success', $notes, ['moyenne' => $moyenne]);
        } catch (\Exception $e) {
            $this->sendError(500, 'Erreur lors de la récupération des notes', $e->getMessage());
        }
    }

    public function getNotesAnnuelByEtudiant($idEtudiant, $annee, $idOption) {
        try {
            $notes = $this->model->getNotesAnnuelByEtudiant($idEtudiant, $annee, $idOption);
            $moyenne = $this->model->getMoyenneAnnuel($idEtudiant, $annee, $idOption);

            $this->sendResponse('success', $notes, ['moyenne_annuelle' => round($moyenne, 2)]);
        } catch (\Exception $e) {
            $this->sendError(500, 'Erreur lors de la récupération des notes annuelles', $e->getMessage());
        }
    }

    public function addNote() {
        try {
            $data = \Flight::request()->data->getData();
            $success = $this->model->addNote($data['idAvancement'], $data['idMatiere'], $data['note']);

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
