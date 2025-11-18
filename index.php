<?php

require_once 'flight/Flight.php';
require __DIR__ . '/config/database.php';

use App\Controllers\EquipageController;
use App\Controllers\UserController;
use App\Controllers\ResultatEpreuveController;
use App\Controllers\EtudiantController;

// Users
Flight::route('GET /users', [UserController::class, 'getAll']);
Flight::route('GET /users/@id', [UserController::class, 'getById']);
Flight::route('POST /users', [UserController::class, 'create']);
Flight::route('PUT /users/@id', [UserController::class, 'update']);
Flight::route('DELETE /users/@id', [UserController::class, 'delete']);

// Etudiants
Flight::route('GET /etudiants', [EtudiantController::class, 'getAll']);
Flight::route('GET /etudiants/@id', [EtudiantController::class, 'getById']);
Flight::route('POST /etudiants', [EtudiantController::class, 'create']);
Flight::route('PUT /etudiants/@id', [EtudiantController::class, 'update']);
Flight::route('DELETE /etudiants/@id', [EtudiantController::class, 'delete']);


Flight::start();
