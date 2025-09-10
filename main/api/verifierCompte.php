<?php
session_start();
header('Content-Type: application/json');

// Inclure l'autoload de Composer pour Dotenv et toutes les classes
require_once __DIR__ . '/../../vendor/autoload.php';

// Inclure les dépendances et le modèle UserRequest
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

// Vérifie que le paramètre est présent
if (!isset($_GET['numCrecip']) || empty(trim($_GET['numCrecip']))) {
  echo json_encode(['exists' => false]);
  exit;
}

$numCrecip = trim($_GET['numCrecip']);

// Instancier la classe qui contient la méthode verifierCompte
//$UserRequest = new UserRequest(); // Nom exact de ta classe

// Vérifier si le compte existe
$exists = $UserRequest->verifierCompte($numCrecip);

// Retourner la réponse JSON
echo json_encode(['exists' => $exists]);
