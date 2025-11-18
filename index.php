<?php

require_once 'flight/Flight.php';
// require 'flight/autoload.php';

//require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config/database.php';

use App\Controllers\NoteController;
use App\Controllers\UserController;

// Routes REST pour les utilisateurs
Flight::route('GET /users', [UserController::class, 'getAll']);
Flight::route('GET /users/@id', [UserController::class, 'getById']);
Flight::route('POST /users', [UserController::class, 'create']);
Flight::route('PUT /users/@id', [UserController::class, 'update']);
Flight::route('DELETE /users/@id', [UserController::class, 'delete']);

Flight::route('GET /notes', [NoteController::class, 'getAllNotes']); // Récupérer toutes les notes
Flight::route('GET /notes/@idEtudiant/@semestre', [NoteController::class, 'getNotesByEtudiantAndSemestre']); // Récupérer les notes d'un étudiant pour un semestre
Flight::route('POST /notes', [NoteController::class, 'addNote']); // Ajouter une nouvelle note

Flight::start();