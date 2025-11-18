<?php

require_once 'flight/Flight.php';
// require 'flight/autoload.php';

//require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config/database.php';

use App\Controllers\EquipageController;
use App\Controllers\UserController;
use App\Controllers\ResultatEpreuveController;
// Routes REST
Flight::route('GET /users', [UserController::class, 'getAll']); // Uncommented User routes
Flight::route('GET /users/@id', [UserController::class, 'getById']);
Flight::route('POST /users', [UserController::class, 'create']);
Flight::route('PUT /users/@id', [UserController::class, 'update']);
Flight::route('DELETE /users/@id', [UserController::class, 'delete']);

Flight::route('GET /equipages', [EquipageController::class, 'index']);
Flight::route('GET /equipages/@id', [EquipageController::class, 'show']);
Flight::route('POST /equipages', [EquipageController::class, 'create']);
Flight::route('PUT /equipages/@id', [EquipageController::class, 'update']);
Flight::route('DELETE /equipages/@id', [EquipageController::class, 'delete']);

// Routes spéciales Equipages
Flight::route('GET /equipages/numero/@numero', [EquipageController::class, 'searchByNumero']);
Flight::route('GET /equipages/categorie/@id_categorie', [EquipageController::class, 'getByCategorie']);
Flight::route('GET /equipages/@id/resultats', [EquipageController::class, 'getResultats']);
Flight::route('GET /equipages/form-data', [EquipageController::class, 'getFormData']);

Flight::route('GET /speciales/temps', [ResultatEpreuveController::class, 'tempsParSpeciale']);
Flight::start();