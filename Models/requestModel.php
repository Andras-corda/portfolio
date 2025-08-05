<?php

// Configuration
global $jsonFile; 


/* 
Fonction de génération d'id
------------------------------------------------------
But : lire la bdd json et renvoyer un id non utilisé 
    (le plus haut pour être sur qu'il ne soit pas en trop)
*/
function generateId() {
    $jsonFile = 'Data/request.json';

    if (!file_exists(JSON_REQUEST_FILE)) {
        return 1;
    }

    $jsonContent = file_get_contents(JSON_REQUEST_FILE);
    if (empty($jsonContent)) {
        return 1;
    }

    $data = json_decode($jsonContent, true);

    if (!isset($data['request']) || !is_array($data['request']) || empty($data['request'])) {
        return 1;
    }

    $ids = array_column($data['request'], 'id');

    if (empty($ids)) {
        return 1;
    }

    return max($ids) + 1;
}



/* 
Fonction de fetch d'informations
------------------------------------------------------
But : parcourir la bdd json dans le but d'afficher ce qu'elle contient
*/
function getAllRequests() {
    if (!file_exists(JSON_REQUEST_FILE)) {
        return [];
    }

    $jsonContent = file_get_contents(JSON_REQUEST_FILE);

    if (empty($jsonContent)) {
        return [];
    }

    $data = json_decode($jsonContent, true);

    return isset($data['request']) && is_array($data['request'])
        ? $data['request']
        : [];
}



/* 
Fonction de suppression de données
------------------------------------------------------
But : parcourir la bdd json et supprimer un élément à partir de son ID
*/
function DeleteRequestById($id) {
    if (!file_exists(JSON_REQUEST_FILE)) {
        return false;
    }

    $jsonContent = file_get_contents(JSON_REQUEST_FILE);
    if (empty($jsonContent)) {
        return false;
    }

    $data = json_decode($jsonContent, true);
    if (!isset($data['request']) || !is_array($data['request'])) {
        return false;
    }

    $filtered = array_filter($data['request'], function($item) use ($id) {
        return $item['id'] != $id;
    });

    if (count($filtered) === count($data['request'])) {
        return false; // id non trouvé
    }

    $data['request'] = array_values($filtered);

    file_put_contents(JSON_REQUEST_FILE, json_encode($data, JSON_PRETTY_PRINT));

    return true;
}



/* 
Fonction d'ajout de données
------------------------------------------------------
But : ajouter à la bdd une requête
*/
function addRequest(array $newRequestData) {
    $data = file_exists(JSON_REQUEST_FILE)
        ? json_decode(file_get_contents(JSON_REQUEST_FILE), true)
        : ['request' => []];

    if (!isset($data['request']) || !is_array($data['request'])) {
        $data['request'] = [];
    }

    $newRequestData['id'] = generateId();

    if (!isset($newRequestData['date'])) {
        $newRequestData['date'] = date('Y-m-d H:i:s');
    }

    $data['request'][] = $newRequestData;

    file_put_contents(JSON_REQUEST_FILE, json_encode($data, JSON_PRETTY_PRINT));

    return $newRequestData['id']; 
}



/* 

------------------------------------------------------
But : 
*/

function SetInApproved($idCible) {
    if (!file_exists(JSON_REQUEST_FILE)) {
        return false;
    }

    $jsonContent = file_get_contents(JSON_REQUEST_FILE);
    if (empty($jsonContent)) {
        return false;
    }

    $datas = json_decode($jsonContent, true);

    if (!isset($datas['request']) || !is_array($datas['request'])) {
        return false;
    }

    foreach ($datas['request'] as &$data) {
        if (isset($data['id']) && $data['id'] == $idCible) {
            $data['status'] = "Approuvé";
            file_put_contents(JSON_REQUEST_FILE, json_encode($datas, JSON_PRETTY_PRINT));
            return true;
        }
    }

    return false;
}

function SetInRejected($idCible) {
    if (!file_exists(JSON_REQUEST_FILE)) {
        return false;
    }

    $jsonContent = file_get_contents(JSON_REQUEST_FILE);
    if (empty($jsonContent)) {
        return false;
    }

    $datas = json_decode($jsonContent, true);

    if (!isset($datas['request']) || !is_array($datas['request'])) {
        return false;
    }

    foreach ($datas['request'] as &$data) {
        if (isset($data['id']) && $data['id'] == $idCible) {
            $data['status'] = "Rejeté";
            file_put_contents(JSON_REQUEST_FILE, json_encode($datas, JSON_PRETTY_PRINT));
            return true;
        }
    }

    return false;
}
