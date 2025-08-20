<?php
// Chargement des classes nécessaires
require_once __DIR__ . '/connexion/Database.php';
require_once __DIR__ . '/request/UserRequest.php';

// Instanciation des classes
try {
  $Database = new Database(); // Connexion à la base de données
  $UserRequest = new UserRequest($Database->getConnexion());
} catch (Exception $e) {
  // Gestion d'erreur si la connexion ou l'instanciation échoue
  http_response_code(500);
  echo "Erreur critique lors de l'initialisation des dépendances : " . htmlspecialchars($e->getMessage());
  exit;
}
