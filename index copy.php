<?php

declare(strict_types=1);

require_once 'flight/Flight.php';
// require 'flight/autoload.php';

Flight::register('db', 'PDO', array(
    'pgsql:host=localhost;port=5432;dbname=rallye',
    'postgres',        // ton utilisateur PostgreSQL
    'admin'       // ton mot de passe
));

Flight::route('GET /users', function() {
    $db = Flight::db();
    $stmt = $db->query("SELECT * FROM users ORDER BY id DESC");
    Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
});

Flight::route('GET /users/@id', function($id) {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    Flight::json($stmt->fetch(PDO::FETCH_ASSOC));
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data;
    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$data->name, $data->email]);
    Flight::json(['message' => 'Utilisateur ajouté']);
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data;
    $db = Flight::db();
    $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$data->name, $data->email, $id]);
    Flight::json(['message' => 'Utilisateur modifié']);
});

Flight::route('DELETE /users/@id', function($id) {
    $db = Flight::db();
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    Flight::json(['message' => 'Utilisateur supprimé']);
});

Flight::start();
