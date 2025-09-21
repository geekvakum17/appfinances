<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['codeClient'])) {
  echo json_encode(["success" => false, "message" => "Utilisateur non connecté"]);
  exit;
}

$codeClient = $_SESSION['codeClient'];

// Vérifier qu'un fichier a été uploadé
if (empty($_FILES['photo']['tmp_name'])) {
  echo json_encode(["success" => false, "message" => "Aucun fichier reçu"]);
  exit;
}

// Vérification basique : est-ce bien une image ?
$check = getimagesize($_FILES['photo']['tmp_name']);
if ($check === false) {
  echo json_encode(["success" => false, "message" => "Le fichier n'est pas une image"]);
  exit;
}

$fileType = $_FILES['photo']['type'];
$allowedTypes = ["image/jpeg", "image/png", "image/gif"];
if (!in_array($fileType, $allowedTypes)) {
  echo json_encode(["success" => false, "message" => "Format d'image non autorisé"]);
  exit;
}

// Préparer le dossier de destination
$uploadDir = __DIR__ . "/../../public/assets/user/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

// Créer un nom de fichier unique par utilisateur
$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
$filename = "user_" . $codeClient . "_" . time() . "." . $ext;
$destination = $uploadDir . $filename;

// Déplacer le fichier dans le dossier
if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
  echo json_encode(["success" => false, "message" => "Échec de l'upload"]);
  exit;
}

// Stocker le chemin relatif en base
$profileimage = "public/assets/user/" . $filename;

try {
  // Utiliser ta méthode getupProfile ou une nouvelle méthode adaptée pour le chemin
  $success = $UserRequest->getupProfile($profileimage, $codeClient);

  if ($success) {
    echo json_encode(["success" => true, "filePath" => $profileimage, "message" => "Image enregistrée avec succès"]);
  } else {
    echo json_encode(["success" => false, "message" => "Échec de l'enregistrement en base"]);
  }
} catch (PDOException $e) {
  echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
