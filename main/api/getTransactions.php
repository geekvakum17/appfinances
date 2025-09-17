<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

if (empty($_SESSION['codeClient'])) {
  echo json_encode(['success' => false, 'message' => 'Non connecté (codeClient manquant)']);
  exit;
}

$codeClient = $_SESSION['codeClient'];

// 🔎 On récupère le numeroCompte à partir du codeClient
$numCompte = $UserRequest->getCompteByCodeClient($codeClient);

if (!$numCompte) {
  echo json_encode(['success' => false, 'message' => 'Aucun compte trouvé pour ce client']);
  exit;
}

try {
  $transactions = $UserRequest->getTransactionsByCompte($numCompte);

  echo json_encode([
    'success' => true,
    'numeroCompte' => $numCompte,
    'transactions' => $transactions
  ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
  echo json_encode([
    'success' => false,
    'message' => 'Erreur : ' . $e->getMessage()
  ]);
}
