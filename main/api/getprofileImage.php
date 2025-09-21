<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

if (!isset($_SESSION['codeClient'])) {
  echo json_encode(["success" => false, "message" => "Utilisateur non connecté"]);
  exit;
}

$codeClient = $_SESSION['codeClient'];
//$userRequest = new UserRequest();

try {
  $imagePath = $UserRequest->getProfileImage($codeClient);
  if ($imagePath) {
    echo json_encode(["success" => true, "filePath" => $imagePath]);
  } else {
    echo json_encode(["success" => true, "filePath" => "public/assets/user/user.png"]); // image par défaut
  }
} catch (PDOException $e) {
  echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
