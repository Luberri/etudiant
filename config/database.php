<?php
Flight::register('db', 'PDO', array(
    'mysql:host=127.0.0.1;port=3306;dbname=gestion_scolarite;charset=utf8',
    'root',      // utilisateur MySQL dans ton conteneur
    'admin'      // mot de passe MySQL
), function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});
