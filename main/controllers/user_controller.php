<?php

function getPost(string $key): string
{
    return isset($_POST[$key]) && is_string($_POST[$key]) && !empty(trim($_POST[$key]))
        ? htmlspecialchars(trim($_POST[$key]))
        : '';
}


$instruction = getPost('instruction');
$urlBase = $url1 ?? ''; // À définir dans ton contexte avant inclusion

switch ($instruction) {

    /************** OPERATIONS CONNECTION *******************/
    case "login":
        $username = getPost('username');
        $password = getPost('password');
        $resultat = $UserRequest->authenticateUser($username, $password);

        if (is_array($resultat) && !empty($resultat)) {
            // Stocker uniquement l'identifiant
            $_SESSION['login'] = true;
            $_SESSION['codeClient'] = $resultat['codeClient'];
            header("Location: {$urlBase}?page=menu");
            exit();
        } else {
            $_SESSION['error'] = "Nom utilisateur ou mot de passe incorrect";
            header("Location: {$urlBase}?page=login");
            exit();
        }

        break;

    default:
        $_SESSION['error'] = 'Action inconnue';
        header("Location: {$urlBase}?page=login");
        exit();
        break;
}
