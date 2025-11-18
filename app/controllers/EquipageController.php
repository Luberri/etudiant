<?php
namespace App\Controllers;

use App\Models\Equipage;
use App\Models\Pilote;
use App\Models\Copilote;
use App\Models\Categorie;
use Flight;

class EquipageController {

    public static function index() {
        try {
            $model = new Equipage(Flight::db());
            $equipages = $model->getEquipageAll();
            Flight::json(['success' => true, 'data' => $equipages]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function show($id) {
        try {
            $model = new Equipage(Flight::db());
            $equipage = $model->getEquipageById($id);
            
            if ($equipage) {
                // Récupérer aussi les résultats
                $resultats = $model->getResultatsEquipage($id);
                $equipage['resultats'] = $resultats;
                Flight::json(['success' => true, 'data' => $equipage]);
            } else {
                Flight::json(['success' => false, 'message' => 'Équipage non trouvé'], 404);
            }
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function create() {
        try {
            $data = Flight::request()->data->getData();
            $model = new Equipage(Flight::db());
            
            // Validation des données
            $validation = self::validateEquipageData($data);
            if (!$validation['valid']) {
                Flight::json(['success' => false, 'message' => $validation['message']], 400);
                return;
            }

            // Vérifier si le pilote et copilote ne sont pas déjà dans un équipage
            if ($model->isPiloteInEquipage($data['id_pilote'])) {
                Flight::json(['success' => false, 'message' => 'Ce pilote est déjà dans un équipage'], 400);
                return;
            }

            if ($model->isCopiloteInEquipage($data['id_copilote'])) {
                Flight::json(['success' => false, 'message' => 'Ce copilote est déjà dans un équipage'], 400);
                return;
            }

            $model->createEquipage($data);
            Flight::json(['success' => true, 'message' => 'Équipage créé avec succès'], 201);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data->getData();
            $model = new Equipage(Flight::db());
            
            // Vérifier si l'équipage existe
            $equipage = $model->getEquipageById($id);
            if (!$equipage) {
                Flight::json(['success' => false, 'message' => 'Équipage non trouvé'], 404);
                return;
            }

            // Validation des données
            $validation = self::validateEquipageData($data);
            if (!$validation['valid']) {
                Flight::json(['success' => false, 'message' => $validation['message']], 400);
                return;
            }

            $model->updateEquipage($id, $data);
            Flight::json(['success' => true, 'message' => 'Équipage mis à jour avec succès']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function delete($id) {
        try {
            $model = new Equipage(Flight::db());
            
            $equipage = $model->getEquipageById($id);
            if (!$equipage) {
                Flight::json(['success' => false, 'message' => 'Équipage non trouvé'], 404);
                return;
            }

            $model->deleteEquipage($id);
            Flight::json(['success' => true, 'message' => 'Équipage supprimé avec succès']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function searchByNumero($numero) {
        try {
            $model = new Equipage(Flight::db());
            $equipage = $model->getEquipageByNumero($numero);
            
            if ($equipage) {
                Flight::json(['success' => true, 'data' => $equipage]);
            } else {
                Flight::json(['success' => false, 'message' => 'Équipage non trouvé'], 404);
            }
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getByCategorie($id_categorie) {
        try {
            $model = new Equipage(Flight::db());
            $equipages = $model->getEquipageByCategorie($id_categorie);
            Flight::json(['success' => true, 'data' => $equipages]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getResultats($id) {
        try {
            $model = new Equipage(Flight::db());
            $resultats = $model->getResultatsEquipage($id);
            Flight::json(['success' => true, 'data' => $resultats]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getFormData() {
        try {
            $piloteModel = new Pilote(Flight::db());
            $copiloteModel = new Copilote(Flight::db());
            $categorieModel = new Categorie(Flight::db());

            $pilotes = $piloteModel->getAllPilotes();
            $copilotes = $copiloteModel->getAllCopilotes();
            $categories = $categorieModel->getAllCategories();

            Flight::json([
                'success' => true,
                'data' => [
                    'pilotes' => $pilotes,
                    'copilotes' => $copilotes,
                    'categories' => $categories
                ]
            ]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private static function validateEquipageData($data) {
        if (!isset($data['id_pilote']) || !isset($data['id_copilote']) || 
            !isset($data['id_categorie']) || !isset($data['numero_equipage'])) {
            return [
                'valid' => false,
                'message' => 'Tous les champs sont obligatoires (id_pilote, id_copilote, id_categorie, numero_equipage)'
            ];
        }

        if (!is_numeric($data['id_pilote']) || !is_numeric($data['id_copilote']) || 
            !is_numeric($data['id_categorie']) || !is_numeric($data['numero_equipage'])) {
            return [
                'valid' => false,
                'message' => 'Les IDs doivent être des nombres'
            ];
        }

        if ($data['numero_equipage'] <= 0) {
            return [
                'valid' => false,
                'message' => 'Le numéro d\'équipage doit être positif'
            ];
        }

        return ['valid' => true];
    }
}