<?php

/**
 * Charge un fichier PHP en vérifiant son existence et accessibilité.
 * En cas d'erreur, stoppe l'exécution avec un message clair.
 *
 * @param string $filePath Chemin absolu vers le fichier à inclure.
 * @return void
 */
function requireFileOrFail(string $filePath): void
{
  if (file_exists($filePath) && is_readable($filePath)) {
    require_once $filePath;
  } else {
    http_response_code(500);
    echo "Erreur critique : impossible de charger le fichier '{$filePath}'.";
    exit;
  }
}

// Utilisation :
requireFileOrFail(__DIR__ . '/globales/variables/variable.php');
requireFileOrFail(__DIR__ . '/models/dependances.php');
requireFileOrFail(__DIR__ . '/routes/myroute.php');
