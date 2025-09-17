<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

// Vérification session
if (empty($_SESSION['codeClient'])) {
  echo json_encode([
    'success' => false,
    'message' => 'Non connecté (codeClient manquant)'
  ]);
  exit;
}

$codeClient = $_SESSION['codeClient'];

try {
  // Instancier la classe UserRequest
  //$UserRequest = new UserRequest();

  // Récupérer les infos du client
  $infoClient = $UserRequest->getInfoProfileclient($codeClient);

  if ($infoClient) {
    echo json_encode([
      'success' => true,
      'client' => $infoClient // on renvoie directement toutes les infos récupérées
    ], JSON_PRETTY_PRINT);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Aucune information trouvée pour ce client.'
    ]);
  }
} catch (Exception $e) {
  echo json_encode([
    'success' => false,
    'message' => 'Erreur : ' . $e->getMessage()
  ]);
}
