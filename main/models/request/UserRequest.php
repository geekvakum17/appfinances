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
  public function authenticateUser(string $username, string $password)
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

  // Ajouter un utilisateur (avec hashage du mot de passe)
  public function addUser(string $nom_users, int $id_role, string $email, string $password)
  {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (nom_users, id_role, email, password) VALUES (:nom_users, :id_role, :email, :password)';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':nom_users', $nom_users, PDO::PARAM_STR);
    $stmt->bindValue(':id_role', $id_role, PDO::PARAM_INT);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
    return $stmt->execute();
  }

  // Liste des utilisateurs avec leur rôle
  public function listUsers()
  {
    $sql = 'SELECT u.id_users, u.nom_users, r.role, u.email FROM users u JOIN roles r ON u.id_role = r.id_role';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Chercher le libellé du rôle
  public function getRoleLabel(int $id_role)
  {
    $sql = 'SELECT libelle FROM roles WHERE id_role = :id_role LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':id_role', $id_role, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() ?: false;
  }

  // Récupérer un utilisateur par son ID
  public function getUserById(int $id_users)
  {
    $sql = 'SELECT * FROM users WHERE id_users = :id_users LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':id_users', $id_users, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
  }

  // Mise à jour utilisateur (gérer hash si besoin)
  public function updateUser(int $id_users, string $nom_users, int $id_role, string $email, ?string $password = null)
  {
    if ($password !== null) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $sql = 'UPDATE users SET nom_users = :nom_users, id_role = :id_role, email = :email, password = :password WHERE id_users = :id_users';
    } else {
      $sql = 'UPDATE users SET nom_users = :nom_users, id_role = :id_role, email = :email WHERE id_users = :id_users';
    }

    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':nom_users', $nom_users, PDO::PARAM_STR);
    $stmt->bindValue(':id_role', $id_role, PDO::PARAM_INT);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':id_users', $id_users, PDO::PARAM_INT);

    if ($password !== null) {
      $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
    }

    return $stmt->execute();
  }

  // Suppression utilisateur
  public function deleteUser(int $id_users)
  {
    $sql = 'DELETE FROM users WHERE id_users = :id_users LIMIT 1';
    $stmt = $this->databaseConnection->prepare($sql);
    $stmt->bindValue(':id_users', $id_users, PDO::PARAM_INT);
    return $stmt->execute();
  }
  /****************** FIN  OPERATIONS USERS   *******************/


  /****************** OPERATIONS ROLE *******************/

  // Ajouter un rôle
  public function addRole(string $role): bool
  {
    $stmt = $this->databaseConnection->prepare('INSERT INTO roles (role) VALUES (:role)');
    $stmt->bindValue(':role', $role, PDO::PARAM_STR);
    return $stmt->execute();
  }

  // Lister tous les rôles
  public function listRoles(): array|false
  {
    $stmt = $this->databaseConnection->prepare('SELECT * FROM roles');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result ?: false;
  }

  // Récupérer un rôle par ID
  public function getRoleById(int $id_role): array|false
  {
    $stmt = $this->databaseConnection->prepare('SELECT * FROM roles WHERE id_role = :id_role LIMIT 1');
    $stmt->bindValue(':id_role', $id_role, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: false;
  }

  // Mettre à jour un rôle
  public function updateRole(int $id_role, string $role): bool
  {
    $stmt = $this->databaseConnection->prepare('UPDATE roles SET role = :role WHERE id_role = :id_role');
    $stmt->bindValue(':role', $role, PDO::PARAM_STR);
    $stmt->bindValue(':id_role', $id_role, PDO::PARAM_INT);
    return $stmt->execute();
  }

  // Supprimer un rôle
  public function deleteRole(int $id_role): bool
  {
    $stmt = $this->databaseConnection->prepare('DELETE FROM roles WHERE id_role = :id_role LIMIT 1');
    $stmt->bindValue(':id_role', $id_role, PDO::PARAM_INT);
    return $stmt->execute();
  }

  /****************** FIN OPERATIONS ROLE *******************/

  /****************** OPERATIONS CLIENT ORGANISME *******************/
  // Récupérer un client organisme par ID
  public function getclientorganismeById(string $codeClient): array|false
  {
    $stmt = $this->databaseConnection->prepare('SELECT * FROM clientorganisme WHERE codeClient = :codeClient LIMIT 1');
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: false;
  }

  public function getcompteclientById(string $codeClient): array|false
  {
    $stmt = $this->databaseConnection->prepare('SELECT * FROM compteclient WHERE codeClient = :codeClient LIMIT 1');
    $stmt->bindValue(':codeClient', $codeClient, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: false;
  }

  /****************** FIN OPERATIONS CLIENT ORGANISME *******************/
}
