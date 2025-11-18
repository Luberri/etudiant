<?php

require_once 'flight/Flight.php';
require __DIR__ . '/config/database.php';

use App\Controllers\NoteController;
use App\Controllers\UserController;
use App\Controllers\EtudiantController;

// Users
Flight::route('GET /users', [UserController::class, 'getAll']);
Flight::route('GET /users/@id', [UserController::class, 'getById']);
Flight::route('POST /users', [UserController::class, 'create']);
Flight::route('PUT /users/@id', [UserController::class, 'update']);
Flight::route('DELETE /users/@id', [UserController::class, 'delete']);

Flight::route('GET /notes', [NoteController::class, 'getAllNotes']); // Récupérer toutes les notes
Flight::route('GET /notes/@idEtudiant/@semestre', [NoteController::class, 'getNotesByEtudiantAndSemestre']); // Récupérer les notes d'un étudiant pour un semestre
Flight::route('POST /notes', [NoteController::class, 'addNote']); // Ajouter une nouvelle note

Flight::start();
// Etudiants
Flight::route('GET /etudiants', [EtudiantController::class, 'getAll']);
Flight::route('GET /etudiants/@id', [EtudiantController::class, 'getById']);
Flight::route('POST /etudiants', [EtudiantController::class, 'create']);
Flight::route('PUT /etudiants/@id', [EtudiantController::class, 'update']);
Flight::route('DELETE /etudiants/@id', [EtudiantController::class, 'delete']);


Flight::start();
