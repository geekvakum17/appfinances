<?php
session_start();

// Vider toutes les variables de session
$_SESSION = [];

// Supprimer le cookie de session si utilisé
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(
    session_name(),
    '',
    time() - 42000, // Date passée pour forcer suppression
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
  );
}

// Détruire la session côté serveur
session_destroy();

// Redirection vers la page de connexion (ajuste BASE_URL dans variable.php)
header('Location: ' . BASE_URL . '?page=login');
exit;
