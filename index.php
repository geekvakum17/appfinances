<?php
// Démarrage sécurisé de la session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Chemin absolu vers main.php
$mainPath = __DIR__ . '/main/main.php';

// Vérification de l'existence du fichier avant inclusion
if (file_exists($mainPath) && is_readable($mainPath)) {
  require_once $mainPath;
} else {
  // Affichage d'une erreur claire et arrêt du script
  http_response_code(500); // Code erreur serveur
  echo "Erreur critique : impossible de charger le fichier principal.";
  exit;
}
