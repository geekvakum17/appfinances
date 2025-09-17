<?php
// main/models/connexion/Database.php

// Inclure l'autoload Composer pour Dotenv et autres packages
require_once __DIR__ . '/../../../vendor/autoload.php';

use Dotenv\Dotenv;

class Database
{
  private ?PDO $databaseConnection = null;

  /**
   * Constructeur : initialise la connexion à la base de données
   */
  public function __construct()
  {
    // Charger .env si présent
    $dotenvPath = dirname(__DIR__, 3); // remonte 3 niveaux pour atteindre la racine
    if (file_exists($dotenvPath . '/.env')) {
      $dotenv = Dotenv::createImmutable($dotenvPath);
      $dotenv->safeLoad(); // safeLoad : pas d'erreur si variable manquante
    }

    // Récupérer les variables d'environnement de manière sécurisée avec fallback
    $host     = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost';
    $port     = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? '8889';
    $dbname   = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'aiadesfinances';
    $username = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root';
    $password = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?? 'root';

    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

    try {
      $this->databaseConnection = new PDO($dsn, $username, $password, [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_PERSISTENT         => true, // optionnel selon hébergeur
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    } catch (PDOException $ex) {
      // Log sécurisé pour le développeur
      error_log("Erreur DB: " . $ex->getMessage());
      // Message générique pour l'utilisateur
      die("Erreur critique : impossible de se connecter à la base de données.");
    }
  }

  /**
   * Retourne la connexion PDO
   */
  public function getConnexion(): ?PDO
  {
    return $this->databaseConnection;
  }

  /**
   * Ferme la connexion
   */
  public function closeConnection(): void
  {
    $this->databaseConnection = null;
  }
}
