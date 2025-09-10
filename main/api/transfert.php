<?php
session_start();
header('Content-Type: application/json');

// Sécurité : autoriser uniquement POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
  exit;
}

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

// Vérification session
if (empty($_SESSION['codeClient']) || empty($_SESSION['numeroCompte'])) {
  echo json_encode(['success' => false, 'message' => 'Client non connecté']);
  exit;
}

// Récupération des champs du formulaire
$numCdonneur = $_SESSION['numeroCompte']; // Compte émetteur
$numCrecip   = trim($_POST['numCrecip'] ?? '');
$montant     = (float)($_POST['montantrans'] ?? 0);
$devise      = trim($_POST['devise'] ?? 'XOF (CFA)');
$motif       = trim($_POST['motifenvoie'] ?? '');

// Vérifications basiques
if ($numCrecip === '') {
  echo json_encode(['success' => false, 'message' => 'Veuillez saisir le compte destinataire']);
  exit;
}

if ($montant < 500) {
  echo json_encode(['success' => false, 'message' => 'Le montant doit être ≥ 500 FCFA']);
  exit;
}

try {


  $exists = $UserRequest->verifierCompte($numCrecip);

  if (!$exists) {
    echo json_encode(['success' => false, 'message' => 'Le compte destinataire n’existe pas']);
    exit;
  }

  // Vérifier solde émetteur
  $solde = $UserRequest->verifierSolde($numCdonneur);
  if ($solde === null) {
    echo json_encode(['success' => false, 'message' => 'Compte émetteur introuvable']);
    exit;
  }

  if ($solde < 400) {
    echo json_encode(['success' => false, 'message' => 'Votre solde doit être ≥ 400 FCFA pour effectuer un transfert']);
    exit;
  }

  if ($solde < $montant) {
    echo json_encode(['success' => false, 'message' => 'Solde insuffisant']);
    exit;
  }

  // Début transaction
  $db->beginTransaction();

  // Débit compte émetteur
  $stmt = $db->prepare("UPDATE compte SET solde = solde - :montant WHERE numeroCompte = :numCdonneur");
  $stmt->bindValue(':montant', $montant);
  $stmt->bindValue(':numCdonneur', $numCdonneur);
  $stmt->execute();

  // Crédit compte destinataire
  $stmt = $db->prepare("UPDATE compte SET solde = solde + :montant WHERE numeroCompte = :numCrecip");
  $stmt->bindValue(':montant', $montant);
  $stmt->bindValue(':numCrecip', $numCrecip);
  $stmt->execute();

  // Enregistrer transaction dans l’historique (facultatif)
  $stmt = $db->prepare("
        INSERT INTO transactions (emetteur, destinataire, montant, devise, motif, date_trans)
        VALUES (:emetteur, :destinataire, :montant, :devise, :motif, NOW())
    ");
  $stmt->bindValue(':emetteur', $numCdonneur);
  $stmt->bindValue(':destinataire', $numCrecip);
  $stmt->bindValue(':montant', $montant);
  $stmt->bindValue(':devise', $devise);
  $stmt->bindValue(':motif', $motif);
  $stmt->execute();

  // Commit
  $db->commit();

  // Nouveau solde
  $newSolde = $UserRequest->verifierSolde($numCdonneur);

  echo json_encode([
    'success' => true,
    'message' => '✅ Transfert effectué avec succès !',
    'newSolde' => $newSolde
  ]);
} catch (Exception $e) {
  $db->rollBack();
  echo json_encode([
    'success' => false,
    'message' => 'Erreur lors du transfert : ' . $e->getMessage()
  ]);
}
