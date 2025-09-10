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

        /*  $username = getPost('username');
        $password = getPost('password');
        $resultat = $UserRequest->authenticateUser($username, $password);

        if (is_array($resultat) && !empty($resultat)) {
            $_SESSION['login']          = true;
            $_SESSION['codeClient']     = $resultat['codeClient'];
            $_SESSION['nomorg']         = $resultat['nomorg'] ?? '';
            $_SESSION['nompnomcli']     = $resultat['nompnomcli'] ?? '';
            $_SESSION['nompcliaservices'] = $resultat['nompcliaservices'] ?? '';
            $_SESSION['numeroCompte']   = $resultat['numeroCompte'] ?? '';
            $_SESSION['solde']          = $resultat['solde'] ?? '';
            header("Location: {$urlBase}?page=menu");
            exit();
        } else {
            $_SESSION['error'] = "Nom utilisateur ou mot de passe incorrect";
            header("Location: {$urlBase}?page=login");
            exit();
        } */

        break;

    case 'transArg':
        $action = $_POST['action'] ?? '';

        $numCdonneur = $_POST['numCdonneur'] ?? '';
        $numCrecip   = $_POST['numCrecip'] ?? '';
        $montant     = floatval($_POST['montantrans'] ?? 0);
        $devise      = $_POST['devise'] ?? '';
        $motif       = $_POST['motifenvoie'] ?? '';

        // Vérification du montant minimum
        if ($montant < 500) {
            echo json_encode(["success" => false, "message" => "Le montant minimum est de 500 FCFA."]);
            exit;
        }

        // Vérification destinataire
        $compteDest = $UserRequest->getVerifCompte($numCrecip);
        if (!$compteDest) {
            echo json_encode(["success" => false, "message" => "Compte destinataire inexistant"]);
            exit;
        }

        // Vérification solde
        $solde = $UserRequest->getSoldeCompte($numCdonneur);
        if ($montant > $solde) {
            echo json_encode(["success" => false, "message" => "Solde insuffisant pour effectuer le transfert"]);
            exit;
        }

        // Exécution du transfert
        $success = $UserRequest->transfertArgent($numCdonneur, $numCrecip, $montant, $devise, $motif);

        if ($success) {
            // Solde mis à jour après transfert
            $soldeMisAJour = $UserRequest->getSoldeCompte($numCdonneur);

            // Historique à renvoyer (dernier transfert)
            $historique = $UserRequest->getDerniersTransferts($numCdonneur, 5);

            echo json_encode([
                "success" => true,
                "message" => "Transfert effectué avec succès !",
                "solde" => number_format($soldeMisAJour, 0, ',', ' '),
                "historique" => $historique
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors du transfert, veuillez réessayer."]);
        }
        exit;
        break;


    default:
        $_SESSION['error'] = 'Action inconnue';
        header("Location: {$urlBase}?page=login");
        exit();
        break;
}
