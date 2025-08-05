<?php

/* 
Fonction de connexion
------------------------------------------------------
But : Ce connecter en temps que Admin
*/
function LoginUser()
{

    // Vérifier si Post != null
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return false;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si Json != DoesNotExist
    if (!file_exists(JSON_USER_FILE)) {
        return false;
    }

    $jsonContent = file_get_contents(JSON_USER_FILE);

    // Vérifier si structure Json != empty
    if (empty($jsonContent)) {
        return false;
    }

    $data = json_decode($jsonContent, true);

    // Vérifier si structure Json == La même structure Json
    if (!isset($data['user']) || !is_array($data['user'])) {
        return false;
    }

    foreach ($data['user'] as $user) {
        $adminUser = $user['pseudo'];
        $adminHash = $user['mdp'];

        if ($username === $adminUser && $password === $adminHash) {
            $_SESSION['user'] = $user;
            return true;
        }
        echo $username;
        echo $password;
        echo  $adminUser;
        echo  $adminHash;
    }

    return false;
}