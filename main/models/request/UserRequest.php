<?php

class UserRequest
{
  protected PDO $databaseConnection;

  public function __construct(PDO $databaseConnection)
  {
    $this->databaseConnection = $databaseConnection;
  }

  /****************** OPERATIONS USERS *******************/

  // Fonction d'authentification sécurisée (avec password_verify)
  /* public function authenticateUser(string $username, string $password)
  {
    $sql = 'SELECT * FROM user WHERE username = :username LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      return $user;
    }
    return false;
  } */

  public function authenticateUser(string $username, string $password)
  {
    $sql = "
        SELECT u.iduser, u.username, u.password, u.typeuser, u.codeClient,
               o.nomorg,
               p.nompnomcli,
               s.nompnomcli AS nompcliaservices,
               c.numeroCompte, c.solde
        FROM user u
        LEFT JOIN clientorganisme o ON u.codeClient = o.codeClient
        LEFT JOIN clientparticulier p ON u.codeClient = p.codeClient
        LEFT JOIN clientautreservice s ON u.codeClient = s.codeClient
        LEFT JOIN compte c ON u.codeClient = c.codeClient
        WHERE u.username = :username
        LIMIT 1
    ";

    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      return $user;
    }

    return false;
  }


  public function getinfoClientById(int $codeClient)
  {
    $sql = "
        SELECT 
            COALESCE(co.nomorg, cp.nompnomcli, cas.nompnomcli) AS nomClient,
            c.numeroCompte,
            c.solde
        FROM compte c
        LEFT JOIN clientorganisme co 
            ON c.codeClient = co.codeClient
        LEFT JOIN clientparticulier cp 
            ON c.codeClient = cp.codeClient
        LEFT JOIN clientautreservice cas 
            ON c.codeClient = cas.codeClient
        WHERE c.codeClient = :codeClient
        LIMIT 1
    ";

    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
  }



  // Récupérer le rôle par ID
  public function verifierCompte($numCrecip): bool
  {
    $sql = 'SELECT COUNT(*) AS count FROM compte WHERE numeroCompte = :numeroCompte';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':numeroCompte', $numCrecip, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retourne true si le compte existe, false sinon
    return ($result && $result['count'] > 0);
  }

  // Récupérer le solde d’un compte par son numéro
  public function verifierSolde(string $numeroCompte): ?float
  {
    $sql = 'SELECT solde FROM compte WHERE numeroCompte = :numeroCompte LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':numeroCompte', $numeroCompte, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? (float) $result['solde'] : null;
  }





  // Récupérer le rôle par ID
  public function getRole(int $id_role)
  {
    $sql = 'SELECT role FROM roles WHERE id_role = :id_role LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':id_role', $id_role, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
  }
}
