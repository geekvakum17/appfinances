<?php
// Chargement des dépendances et instanciation de $UserRequest
require_once './main/models/connexion/Database.php';
require_once './main/models/request/UserRequest.php';

$Database = new Database();
$UserRequest = new UserRequest($Database->getConnexion());

// Démarrage de la session si ce n’est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Récupération sécurisée du paramètre page
$page = 'login';
$page = (isset($_GET['page']) && !empty($_GET['page']) && is_string($_GET['page'])) ? $_GET['page'] : $page;

// Switch sur la page demandée
switch ($page) {
  // Frontend //

  case 'login':
    include './main/views/components/head.php';
    include './main/views/body/login.php';
    break;

  case 'menu':
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      include './main/views/components/head.php';
      include './main/views/components/sidebar.php';
      include './main/views/components/header.php';
      include './main/views/body/menu.php';
      include './main/views/components/footer.php';
    } else {
      include './main/views/components/head.php';
      include './main/views/body/login.php';
    }
    break;

  case 'transfere':
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      include './main/views/components/head.php';
      include './main/views/components/sidebar.php';
      include './main/views/components/header.php';
      include './main/views/body/ftransfere.php';
      include './main/views/components/footer.php';
    } else {
      include './main/views/components/head.php';
      include './main/views/body/login.php';
    }
    break;

  case 'pret':
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      include './main/views/components/head.php';
      include './main/views/components/sidebar.php';
      include './main/views/components/header.php';
      include './main/views/body/lpret.php';
      include './main/views/components/footer.php';
    } else {
      include './main/views/components/head.php';
      include './main/views/body/login.php';
    }
    break;

  case 'profile':
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      include './main/views/components/head.php';
      include './main/views/components/sidebar.php';
      include './main/views/components/header.php';
      include './main/views/body/profile.php';
      include './main/views/components/footer.php';
    } else {
      include './main/views/components/head.php';
      include './main/views/body/login.php';
    }
    break;

  case 'infoget':
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      include './main/api/getinfoconcter.php';
      include './main/views/components/footer.php';
    } else {
      include './main/views/components/head.php';
      include './main/views/body/login.php';
    }
    break;

  case 'transfert1':
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      include './main/api/getInfoprofile.php';
      //include './main/views/components/footer.php';
    } else {
      include './main/views/components/head.php';
      include './main/views/body/login.php';
    }
    break;

  case 'verif':
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
      include './main/api/verifierCompte.php';
    } else {
      include './main/views/components/head.php';
      include './main/views/body/login.php';
    }
    break;



  case 'test':
    include './main/views/body/test.php';
    break;



  // Controllers //

  case 'user':
    include './main/controllers/user_controller.php';
    break;

  case 'user0':
    include './main/controllers/villecontrollers.php';
    break;

  case 'out':
    include './main/controllers/user_deconexion.php';
    break;

  default:
    include './main/views/components/backend/head.php';
    include './main/views/body/backend/errorpage.php';
    include './main/views/components/backend/footer.php';
    break;
}
