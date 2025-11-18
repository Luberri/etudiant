
<?php
Flight::register('db', 'PDO', array(
    'mysql:host=db;port=3306;dbname=gestion_scolarite;charset=utf8',
    'root',
    'root'
), function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});