<?php
// Define the constant if not already defined
if (!defined('JSON_PROJECT_FILE')) {
    define('JSON_PROJECT_FILE', 'Data/request.json');
}

/* 
Fonction de génération d'id
------------------------------------------------------
But : lire la bdd json et renvoyer un id non utilisé 
    (le plus haut pour être sur qu'il ne soit pas en trop)
*/
function generateId() {
    if (!file_exists(JSON_PROJECT_FILE)) {
        return 1;
    }

    $jsonContent = file_get_contents(JSON_PROJECT_FILE);
    if (empty($jsonContent)) {
        return 1;
    }

    $data = json_decode($jsonContent, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON decode error: " . json_last_error_msg());
        return 1;
    }

    if (!isset($data['projet']) || !is_array($data['projet']) || empty($data['projet'])) {
        return 1;
    }

    $ids = array_column($data['projet'], 'id');

    if (empty($ids)) {
        return 1;
    }

    $numericIds = array_filter(array_map('intval', $ids), function($id) {
        return $id > 0;
    });

    if (empty($numericIds)) {
        return 1;
    }

    return max($numericIds) + 1;
}

/* 
GetAllProjects
------------------------------------------------------
But : récupérer tous les projets depuis le fichier JSON
Retour : array des projets ou false en cas d'erreur
*/
function GetAllProjects() {
    if (!file_exists(JSON_PROJECT_FILE)) {
        return false;
    }

    $jsonContent = file_get_contents(JSON_PROJECT_FILE);
    if (empty($jsonContent)) {
        return false;
    }

    $data = json_decode($jsonContent, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON decode error: " . json_last_error_msg());
        return false;
    }

    if (!isset($data['projet']) || !is_array($data['projet'])) {
        return false;
    }

    return $data['projet'];
}

/* 
DeleteProjectByID
------------------------------------------------------
But : supprimer un projet par son ID
Paramètres : $id (int) - ID du projet à supprimer
Retour : true si suppression réussie, false sinon
*/
function DeleteProjectByID($id) {
    if (!file_exists(JSON_PROJECT_FILE)) {
        return false;
    }

    $jsonContent = file_get_contents(JSON_PROJECT_FILE);
    if (empty($jsonContent)) {
        return false;
    }

    $data = json_decode($jsonContent, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON decode error: " . json_last_error_msg());
        return false;
    }

    if (!isset($data['projet']) || !is_array($data['projet'])) {
        return false;
    }

    // Chercher et supprimer le projet avec l'ID spécifié
    $projectFound = false;
    foreach ($data['projet'] as $key => $projet) {
        if (isset($projet['id']) && $projet['id'] == $id) {
            unset($data['projet'][$key]);
            $projectFound = true;
            break;
        }
    }

    if (!$projectFound) {
        return false;
    }

    // Réindexer le tableau pour éviter les trous
    $data['projet'] = array_values($data['projet']);

    // Sauvegarder le fichier
    $jsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents(JSON_PROJECT_FILE, $jsonString) !== false) {
        return true;
    }

    return false;
}

/* 
ModifyProjectByID
------------------------------------------------------
But : modifier un projet existant par son ID
Paramètres : $id (int) - ID du projet à modifier
            $newData (array) - nouvelles données du projet
Retour : true si modification réussie, false sinon
*/
function ModifyProjectByID($id, $newData) {
    if (!file_exists(JSON_PROJECT_FILE)) {
        return false;
    }

    $jsonContent = file_get_contents(JSON_PROJECT_FILE);
    if (empty($jsonContent)) {
        return false;
    }

    $data = json_decode($jsonContent, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON decode error: " . json_last_error_msg());
        return false;
    }

    if (!isset($data['projet']) || !is_array($data['projet'])) {
        return false;
    }

    // Chercher et modifier le projet avec l'ID spécifié
    $projectFound = false;
    foreach ($data['projet'] as $key => $projet) {
        if (isset($projet['id']) && $projet['id'] == $id) {
            // Conserver l'ID original
            $newData['id'] = $id;
            $data['projet'][$key] = $newData;
            $projectFound = true;
            break;
        }
    }

    if (!$projectFound) {
        return false;
    }

    // Sauvegarder le fichier
    $jsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents(JSON_PROJECT_FILE, $jsonString) !== false) {
        return true;
    }

    return false;
}

/* 
AddProject
------------------------------------------------------
But : ajouter un nouveau projet
Paramètres : $projectData (array) - données du nouveau projet
Retour : ID du nouveau projet créé, ou false en cas d'erreur
*/
function AddProject($projectData) {
    // Générer un nouvel ID
    $newId = generateId();
    
    // Ajouter l'ID aux données du projet
    $projectData['id'] = $newId;

    // Lire le fichier existant ou créer une structure vide
    $data = ['projet' => []];
    
    if (file_exists(JSON_PROJECT_FILE)) {
        $jsonContent = file_get_contents(JSON_PROJECT_FILE);
        if (!empty($jsonContent)) {
            $existingData = json_decode($jsonContent, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($existingData['projet'])) {
                $data = $existingData;
            }
        }
    }

    // Ajouter le nouveau projet
    $data['projet'][] = $projectData;

    // Créer le dossier s'il n'existe pas
    $dir = dirname(JSON_PROJECT_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    // Sauvegarder le fichier
    $jsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents(JSON_PROJECT_FILE, $jsonString) !== false) {
        return $newId;
    }

    return false;
}

/* 
GetProjectByID
------------------------------------------------------
But : récupérer un projet spécifique par son ID
Paramètres : $id (int) - ID du projet recherché
Retour : array du projet ou false si non trouvé
*/
function GetProjectByID($id) {
    $projects = GetAllProjects();
    
    if ($projects === false) {
        return false;
    }

    foreach ($projects as $project) {
        if (isset($project['id']) && $project['id'] == $id) {
            return $project;
        }
    }

    return false;
}

/* 
Exemples d'utilisation
------------------------------------------------------
*/

/*
// Récupérer tous les projets
$allProjects = GetAllProjects();
if ($allProjects !== false) {
    foreach ($allProjects as $project) {
        echo "Projet: " . $project['nom'] . " (ID: " . $project['id'] . ")\n";
    }
}

// Récupérer un projet spécifique
$project = GetProjectByID(1);
if ($project !== false) {
    echo "Projet trouvé: " . $project['nom'] . "\n";
}

// Ajouter un nouveau projet
$newProject = [
    'nom' => 'Nouveau Projet',
    'confidentialite' => 'Public',
    'description' => 'Description du nouveau projet',
    'langages' => ['PHP', 'JavaScript'],
    'statistiques' => [
        'étoiles' => 0,
        'branches' => 1
    ],
    'liens' => [
        'codeSource' => 'https://github.com/user/new-project'
    ]
];

$newId = AddProject($newProject);
if ($newId !== false) {
    echo "Nouveau projet créé avec l'ID: " . $newId . "\n";
}

// Modifier un projet existant
$updatedData = [
    'nom' => 'Projet Modifié',
    'confidentialite' => 'Privé',
    'description' => 'Description mise à jour',
    'langages' => ['PHP', 'JavaScript', 'CSS'],
    'statistiques' => [
        'étoiles' => 5,
        'branches' => 2
    ],
    'liens' => [
        'codeSource' => 'https://github.com/user/modified-project'
    ]
];

if (ModifyProjectByID(1, $updatedData)) {
    echo "Projet modifié avec succès\n";
}

// Supprimer un projet
if (DeleteProjectByID(1)) {
    echo "Projet supprimé avec succès\n";
}
*/