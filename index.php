<?php

use Dotenv\Dotenv;
// Démarrage sécurisé de la session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Charger Composer et Dotenv AVANT tout
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
