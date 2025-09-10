<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

if (!isset($_SESSION['numeroCompte'])) {
  echo json_encode(['suffisant' => false, 'message' => 'Client non connecté']);
  exit;
}

$montant = (float)($_POST['montant'] ?? 0);

// Récupération du solde actuel
$solde = $UserRequest->verifierSolde($_SESSION['numeroCompte']);

if ($solde === null) {
  echo json_encode(['suffisant' => false, 'message' => 'Compte introuvable']);
  exit;
}

// Vérification
$suffisant = ($montant >= 500) && ($solde >= $montant);

echo json_encode([
  'suffisant' => $suffisant,
  'solde' => $solde,
  'message' => $suffisant
    ? 'Transfert possible'
    : ($montant < 500 ? 'Le montant doit être ≥ 500' : 'Solde insuffisant')
]);
