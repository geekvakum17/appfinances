<?php
session_start();
header('Content-Type: application/json');

// Inclure l'autoload de Composer pour Dotenv et toutes les classes
require_once __DIR__ . '/../../vendor/autoload.php';

// Inclure les dépendances et le modèle UserRequest
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';
// Vérifier si le client est connecté
if (!isset($_SESSION['codeClient'])) {
  echo json_encode(['error' => 'Client non connecté']);
  exit;
}

$codeClient = (int) $_SESSION['codeClient'];

// Récupérer les infos du client
$ResultatinfoClient = $UserRequest->getinfoClientById($codeClient);

if ($ResultatinfoClient) {
  echo json_encode($ResultatinfoClient);
} else {
  echo json_encode(['error' => 'Client non trouvé']);
}
