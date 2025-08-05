<?php

// Model du fomulaire de contact
require_once("Models/requestModel.php");
// Models pour la page admin
require_once("Models/userModel.php"); // utilisateur
//require_once("Models/projetModel.php"); // Projet

$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/index.php" || $uri === "/") {
    $title = "Page d'accueil";
    $navbar = "Views/Components/navbar.php";
    $footer = "Views/Components/footer.php";
    $template = "Views/home.php";
    $modal[0] = "Views/Components/modals/privacyModal.php";
    $modal[1] = "Views/Components/modals/legalModal.php";
    require_once("Views/base.php");

    if (isset($_POST['btnEnvoi'])) {
        $newRequestData = [
            'nom' => trim($_POST['nom']),
            'email' => trim($_POST['email']),
            'objet' => trim($_POST['objet']),
            'commentaire' => trim($_POST['commentaire']),
            'status' => "En attente"
        ];

        $requestId = addRequest($newRequestData);
    }
} elseif ($uri === "/admin") {

    // Sécurité
    if (!isset($_SESSION['user']) && $_SESSION['user']['certification'] === "admin") {
        header('Location: /login');
        exit;
    }

    // Récupérer toutes les request
    $requests = getAllRequests();
    $enAttente = 0;
    $approuve = 0;
    $rejete = 0;

    if (!empty($requests)) {
        foreach ($requests as $result) {
            if ($result['status'] === "En attente") {
                $enAttente++;
            } elseif ($result['status'] === "Approuvé") {
                $approuve++;
            } elseif ($result['status'] === "Rejeté") {
                $rejete++;
            }
        }
    }

    if (isset($_POST['ApproveBTN'])) {
        $id = intval($_POST['ApproveBTN']);
        // Appelle ta fonction pour approuver la demande $id
        SetInApproved($id);
        header('Location: /admin');
        exit;
    }
    if (isset($_POST['RejectBTN'])) {
        $id = intval($_POST['RejectBTN']);
        // Appelle ta fonction pour rejeter la demande $id
        SetInRejected($id);
        header('Location: /admin');
        exit;
    }
    if (isset($_POST['DeleteBTN'])) {
        $id = intval($_POST['DeleteBTN']);
        // Supprime à partir de $id la request
        DeleteRequestById($id);
        header('Location: /admin');
        exit;
    }


    // View
    $title = "Panel Admin - Gestion Complète";
    $template = "Views/Components/Admins/dashboard.php";
    require_once("Views/base.php");
} elseif ($uri === "/login") {
    if (isset($_POST['btnLogin'])) {

        if (LoginUser()) {
            header('Location: /admin');
            exit;
        } else {
            echo "Identifiants invalides.";
        }
    }

    // View
    $title = "Page de connexion";
    $template = "Views/Components/Admins/login.php";
    require_once("Views/base.php");
} elseif ($uri === "/logout") {
    session_destroy();
    header("Location: /");
    exit;
}
