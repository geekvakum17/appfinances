<?php

class Database
{
  private string $host = 'localhost';
  private string $databaseName = 'aiadesfinances';
  private string $username = 'root';
  private string $password = 'root';
  private array $options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lancer des exceptions en cas d'erreur
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mode de fetch par défaut
  ];

  private ?PDO $databaseConnection = null;

  public function __construct()
  {
    try {
      $dsn = sprintf(
        'mysql:host=%s;port=8889;dbname=%s;charset=utf8',
        $this->host,
        $this->databaseName
      );
      $this->databaseConnection = new PDO($dsn, $this->username, $this->password, $this->options);
    } catch (PDOException $ex) {
      // Log l'erreur dans un fichier au lieu de l'afficher à l'utilisateur
      error_log('Erreur de connexion à la base de données : ' . $ex->getMessage());
      // Message générique pour l'utilisateur
      die('Erreur critique : impossible de se connecter à la base de données.');
    }
  }

  public function getConnexion(): ?PDO
  {
    return $this->databaseConnection;
  }

  public function closeConnection(): void
  {
    $this->databaseConnection = null;
  }



  /*  private $host = "185.98.131.214";
   private $databasename = "ahlyd2603177"; 
   private $username ="ahlyd2603177";
   private $password ="b0imbtt8ix";
   private $option=array(
     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
     PDO::ATTR_PERSISTENT => true
   );
   private $databaseConnection;

   public function __construct() {

     try {
       $this->databaseConnection = new PDO('mysql:host='.$this->host.';port=3306;dbname='.$this->databasename, $this->username, $this->password, $this->option);
     }
     catch(Exception $ex) {
      echo 'connexion à la base de donnee echoue '.$ex->getMessage();
     }

   }

   function getconnexion() {
     return $this->databaseConnection;
   }

   function closeConnection() {
     unset($this->databaseConnection);
   }   */
}
