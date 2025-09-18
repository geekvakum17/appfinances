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

        // Vérifie que les champs ne sont pas vides
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header("Location: {$urlBase}?page=login");
            exit();
        }

        // Authentification
        $resultat = $UserRequest->authenticateUser($username, $password);

        if (is_array($resultat) && !empty($resultat)) {
            // Stocker les infos essentielles en session
            $_SESSION['login'] = true;
            $_SESSION['codeClient'] = $resultat['codeClient'] ?? null;
            $_SESSION['typeProfile'] = $resultat['typeProfile'] ?? null;

            // Redirection selon le type de profil
            switch ((int) $_SESSION['typeProfile']) {
                case 4:
                    header("Location: {$urlBase}?page=menu1");
                    break;
                default:
                    header("Location: {$urlBase}?page=menu");
                    break;
            }
            exit();
        } else {
            $_SESSION['error'] = "Nom utilisateur ou mot de passe incorrect.";
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
