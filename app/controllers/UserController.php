<?php
namespace App\Controllers;

use App\Models\User;
use Flight;

class UserController {

    public static function getAll() {
        $model = new User(Flight::db());
        Flight::json($model->getAll());
    }

    public static function getById($id) {
        $model = new User(Flight::db());
        $user = $model->getById($id);
        if ($user)
            Flight::json($user);
        else
            Flight::json(['error' => 'User not found'], 404);
    }

    public static function create() {
        $data = Flight::request()->data->getData();
        $model = new User(Flight::db());
        $model->create($data);
        Flight::json(['message' => 'User created'], 201);
    }

    public static function update($id) {
        $data = Flight::request()->data->getData();
        $model = new User(Flight::db());
        $model->update($id, $data);
        Flight::json(['message' => 'User updated']);
    }

    public static function delete($id) {
        $model = new User(Flight::db());
        $model->delete($id);
        Flight::json(['message' => 'User deleted']);
    }
}