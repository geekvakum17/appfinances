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
            // $resultat est déjà un tableau associatif unique
            $data = $resultat; // Pas $resultat[0]
            $id_role = $data['typeuser'];
            $codeClient = $data['codeClient'];
            $resultat2 = $UserRequest->getclientorganismeById($codeClient);
            $data0 = $resultat2;
            $_SESSION['nomorg'] = $data0['nomorg'];
            $resultat4 = $UserRequest->getclientparticuliersById($codeClient);
            $data2 = $resultat4;
            $_SESSION['nompnomcli'] = $data2['nompnomcli'];
            $resultat5 = $UserRequest->getclientautreserviceById($codeClient);
            $data3 = $resultat5;
            $_SESSION['nompcliaservices'] = $data3['nompnomcli'];
            $resultat3 = $UserRequest->getcompteclientById($codeClient);
            $data1 = $resultat3;
            $_SESSION['numeroCompte'] = $data1['numeroCompte'];
            $_SESSION['solde'] = $data1['solde'];
            $_SESSION['login'] = true;
            header("Location: {$urlBase}?page=menu");
            exit();
        } else {
            $_SESSION['error'] = "nom utilisateur ou mot de passe incorrecte";
            header("Location: {$urlBase}?page=login");
            exit();
        }

        break;

    /************** OPERATIONS UTILISATEURS *******************/
    case "addusers":
        $nom_users = getPost('nom_users');
        $id_role = getPost('id_role');
        $email = getPost('email');
        $password = getPost('password');

        $resultat = $UserRequest->addusers($nom_users, $id_role, $email, $password);
        if ($resultat) {
            $_SESSION['users'] = true;
            header("Location: {$urlBase}?page=users");
            exit();
        }
        break;

    case "rechusers":
        $id_users = getPost('id_users');
        $_SESSION['id_users'] = $id_users;
        $_SESSION['users'] = true;
        header("Location: {$urlBase}?page=modifusers");
        exit();
        break;

    case "updateusers":
        $id_users = $_POST['id_users'] ?? '';
        $nom_users = getPost('nom_users');
        $id_role = getPost('id_role');
        $email = getPost('email');
        $password = getPost('password');

        // Note : dans l’original, $id_pays et $id_ville sont utilisés sans être définis,
        // je les mets à null ici, à adapter selon contexte
        $resultat = $UserRequest->update_users($id_users, $nom_users, $id_role, null, null, $email, $password);

        if ($resultat) {
            $_SESSION['user'] = true;
            header("Location: {$urlBase}?page=users");
            exit();
        }
        break;

    case "rechdelusers":
        $id_users = getPost('id_users');
        $_SESSION['id_users'] = $id_users;
        $_SESSION['users'] = true;
        header("Location: {$urlBase}?page=delusers");
        exit();
        break;

    case "deleteusers":
        $id_users = $_POST['id_users'] ?? '';
        $UserRequest->delete_users($id_users);
        $_SESSION['user'] = true;
        header("Location: {$urlBase}?page=users");
        exit();
        break;

    /************** OPERATIONS ROLE *******************/
    case "addroles":
        $role = getPost('role');
        $resultat = $UserRequest->addroles($role);
        if ($resultat) {
            $_SESSION['users'] = true;
            header("Location: {$urlBase}?page=roles");
            exit();
        }
        break;

    case "rechrole":
        $id_role = getPost('id_role');
        $_SESSION['id_role'] = $id_role;
        $_SESSION['users'] = true;
        header("Location: {$urlBase}?page=modifrole");
        exit();
        break;

    case "updaterole":
        $id_role = $_POST['id_role'] ?? '';
        $role = getPost('role');
        $resultat = $UserRequest->update_role($id_role, $role);
        if ($resultat) {
            $_SESSION['user'] = true;
            header("Location: {$urlBase}?page=roles");
            exit();
        }
        break;

    case "rechdelrole":
        $id_role = getPost('id_role');
        $_SESSION['id_role'] = $id_role;
        $_SESSION['users'] = true;
        header("Location: {$urlBase}?page=delrole");
        exit();
        break;

    case "deleterole":
        $id_role = $_POST['id_role'] ?? '';
        $UserRequest->delete_role($id_role);
        $_SESSION['user'] = true;
        header("Location: {$urlBase}?page=roles");
        exit();
        break;

    /************** OPERATIONS PROFILE *******************/
    case "addprofiles":
        $libelle = getPost('libelle');
        $resultat = $UserRequest->addprofiles($libelle);
        if ($resultat) {
            $_SESSION['users'] = true;
            header("Location: {$urlBase}?page=profiles");
            exit();
        }
        break;

    case "updateprofiles":
        $id_profile = $_POST['id_profile'] ?? '';
        $libelle = getPost('libelle');
        $resultat = $UserRequest->update_profiles($id_profile, $libelle);
        if ($resultat) {
            $_SESSION['user'] = true;
            header("Location: {$urlBase}?page=profiles");
            exit();
        }
        break;

    case "deleteprofiles":
        $id_profile = $_POST['id_profile'] ?? '';
        $UserRequest->delete_profiles($id_profile);
        $_SESSION['user'] = true;
        header("Location: {$urlBase}?page=profiles");
        exit();
        break;

    /************** OPERATIONS ORGANISMES *******************/
    case "addorganismes":
        $liborganismes = getPost('liborganismes');
        $resultat = $UserRequest->addorganismes($liborganismes);
        if ($resultat) {
            $_SESSION['users'] = true;
            header("Location: {$urlBase}?page=addorganismes");
            exit();
        }
        break;

    case "updateorganismes":
        $id_organismes = getPost('id_organismes');
        $liborganismes = getPost('liborganismes');
        $resultat = $UserRequest->update_organismes($id_organismes, $liborganismes);
        if ($resultat) {
            $_SESSION['user'] = true;
            header("Location: {$urlBase}?page=addorganismes");
            exit();
        }
        break;

    case "deleteorganismes":
        $id_organismes = getPost('id_organismes');
        $UserRequest->delete_organismes($id_organismes);
        $_SESSION['user'] = true;
        header("Location: {$urlBase}?page=addorganismes");
        exit();
        break;



    default:
        $_SESSION['error'] = 'Action inconnue';
        header("Location: {$urlBase}?page=login");
        exit();
        break;
}
