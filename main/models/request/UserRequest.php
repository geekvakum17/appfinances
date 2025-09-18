<?php

class UserRequest
{
  protected PDO $databaseConnection;

  public function __construct(PDO $databaseConnection)
  {
    $this->databaseConnection = $databaseConnection;
  }

  /****************** OPERATIONS USERS *******************/


  public function authenticateUser(string $username, string $password)
  {
    $sql = "
        SELECT u.iduser, u.username, u.password, u.typeuser, u.codeClient, u.typeProfile,
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

  public function effectuerTransfert(
    string $numCdonneur,
    string $numCrecip,
    float $montant,
    string $devise,
    string $motif
  ): bool {
    try {
      $this->databaseConnection->beginTransaction();


      // Débit compte émetteur
      $sqlDebit = "UPDATE compte SET solde = solde - :montant WHERE numeroCompte = :numCdonneur";
      $stmt = $this->databaseConnection->prepare($sqlDebit);
      $stmt->bindValue(':montant', $montant, PDO::PARAM_STR);
      $stmt->bindValue(':numCdonneur', $numCdonneur, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new Exception("Échec du débit du compte émetteur.");
      }

      // Crédit compte destinataire
      $sqlCredit = "UPDATE compte SET solde = solde + :montant WHERE numeroCompte = :numCrecip";
      $stmt = $this->databaseConnection->prepare($sqlCredit);
      $stmt->bindValue(':montant', $montant, PDO::PARAM_STR);
      $stmt->bindValue(':numCrecip', $numCrecip, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new Exception("Compte destinataire introuvable.");
      }

      // Enregistrement transaction
      $sqlTrans = "INSERT INTO transactions (numCdonneur, numCrecip, montant, devise, motif, date)
                     VALUES (:numCdonneur, :numCrecip, :montant, :devise, :motif, NOW())";
      $stmt = $this->databaseConnection->prepare($sqlTrans);
      $stmt->bindValue(':numCdonneur', $numCdonneur, PDO::PARAM_STR);
      $stmt->bindValue(':numCrecip', $numCrecip, PDO::PARAM_STR);
      $stmt->bindValue(':montant', $montant, PDO::PARAM_INT);
      $stmt->bindValue(':devise', $devise, PDO::PARAM_STR);
      $stmt->bindValue(':motif', $motif, PDO::PARAM_STR);
      $stmt->execute();

      $this->databaseConnection->commit();
      return true;
    } catch (Exception $e) {
      $this->databaseConnection->rollBack();
      error_log("Erreur transfert : " . $e->getMessage());
      throw $e; // Rejette l'exception pour ton API afin que le client voie le message
    }
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

  public function getEmailByCompte(string $numeroCompte): ?string
  {
    // Étape 1 : récupérer le code client
    $sql = 'SELECT codeClient FROM compte WHERE numeroCompte = :numeroCompte LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':numeroCompte', $numeroCompte, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null; // Pas trouvé
    }

    $codeClient = $row['codeClient'];

    // Étape 2 : chercher dans les tables correspondantes
    // Particulier
    $sql = 'SELECT emailcli AS email FROM clientparticulier WHERE codeClient = :codeClient LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && !empty($row['email'])) {
      return $row['email'];
    }

    // Organisme
    $sql = 'SELECT emailorg AS email FROM clientorganisme WHERE codeClient = :codeClient LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && !empty($row['email'])) {
      return $row['email'];
    }

    // Autres services
    $sql = 'SELECT emailcli AS email FROM clientautreservice WHERE codeClient = :codeClient LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && !empty($row['email'])) {
      return $row['email'];
    }

    // Si rien trouvé
    return null;
  }

  public function getCompteByCodeClient(string $codeClient): string|false
  {
    $sql = "SELECT numeroCompte FROM compte WHERE codeClient = :codeClient LIMIT 1";
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn() ?: false;
  }



  public function getTransactionsByCompte(string $numeroCompte): array
  {
    $sql = "SELECT t.id_transaction, t.numCdonneur, t.numCrecip, t.montant, t.devise, t.motif, t.date
            FROM transactions t
            WHERE t.numCdonneur = :numeroCompte OR t.numCrecip = :numeroCompte
            ORDER BY t.date DESC";
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':numeroCompte', $numeroCompte, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  }


  public function getPaliersPret(): array
  {
    $sql = "SELECT nomcpret, fraisoucprets, tauxinteret, montantmin, montantmax, dureemaxremb, dureeminremb FROM infocompteprets";
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // jamais false
  }


  public function getInfoProfileclient(string $codeClient): array|false
  {
    $sql = "
        SELECT nompnomcli AS nom, contactcli AS contact, emailcli AS email, NULL AS organisation, NULL AS org_email, NULL AS org_tel
        FROM clientparticulier WHERE codeClient = :codeClient
        UNION
        SELECT nomorg, telorg, emailorg, nomorg, NULL, NULL 
        FROM clientorganisme WHERE codeClient = :codeClient
        UNION
        SELECT nompnomcli AS nom, contactcli AS contact, emailcli AS email, NULL, NULL, NULL
        FROM clientautreservice WHERE codeClient = :codeClient
        LIMIT 1
    ";

    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
  }
}
