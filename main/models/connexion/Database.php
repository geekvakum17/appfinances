<?php

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

    // Récupération des variables d'environnement avec fallback
    $host     = getenv('DB_HOST') ?: 'localhost';
    $port     = getenv('DB_PORT') ?: '8889';
    $dbname   = getenv('DB_NAME') ?: 'aiadesfinances';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASS') ?: 'root';

    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

    try {
      $this->databaseConnection = new PDO($dsn, $username, $password, [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_PERSISTENT         => true, // optionnel selon hébergeur
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    } catch (PDOException $ex) {
      // Log sécurisé, message générique pour l'utilisateur
      error_log("Erreur DB: " . $ex->getMessage());
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
