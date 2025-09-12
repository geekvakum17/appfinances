<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
header('Content-Type: application/json');
// ✅ Envoi email via PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// ✅ Autoriser uniquement POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
  exit;
}

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

// ✅ Vérification session
if (empty($_POST['numCdonneur']) || empty($_SESSION['codeClient'])) {
  echo json_encode(['success' => false, 'message' => 'Client non connecté']);
  exit;
}

// ✅ Récupération des champs
$numCdonneur = trim($_POST['numCdonneur']);
$numCrecip   = trim($_POST['numCrecip'] ?? '');
$montant     = (float)($_POST['montantrans'] ?? 0);
$devise      = trim($_POST['devise'] ?? 'XOF (CFA)');
$motif       = trim($_POST['motifenvoie'] ?? 'Aucun');

// ✅ Instanciation UserRequest
//$UserRequest = new UserRequest();

try {
  // ✅ Effectuer le transfert
  $resultat = $UserRequest->effectuerTransfert($numCdonneur, $numCrecip, $montant, $devise, $motif);

  if (!$resultat) {
    echo json_encode([
      'success' => false,
      'message' => '❌ Échec du transfert'
    ]);
    exit;
  }

  // ✅ Nouveau solde
  $newSolde = $UserRequest->verifierSolde($numCdonneur);

  // ✅ Récupération des emails des comptes
  $emailEmetteur = $UserRequest->getEmailByCompte($numCdonneur);
  $emailDestinataire = $UserRequest->getEmailByCompte($numCrecip);

  // 🔹 Fonction génération d’email HTML
  function generateTransferEmail($type, $montant, $devise, $from, $to, $motif)
  {
    $title = $type === "emetteur" ? "Confirmation de votre transfert" : "Vous avez reçu un transfert";
    $message = $type === "emetteur"
      ? "Vous avez envoyé <b>$montant $devise</b> au compte <b>$to</b>."
      : "Vous avez reçu <b>$montant $devise</b> du compte <b>$from</b>.";

    return "
      <html>
        <head>
          <meta charset='UTF-8'>
          <style>
            body { font-family: Arial, sans-serif; background:#f6f6f6; margin:0; padding:20px; }
            .email-container { background:#fff; padding:20px; border-radius:8px; max-width:600px; margin:auto; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
            h2 { color:#28a745; }
            .details { margin:20px 0; padding:15px; background:#f9f9f9; border-left:4px solid #28a745; }
            .footer { font-size:12px; color:#777; margin-top:20px; }
          </style>
        </head>
        <body>
          <div class='email-container'>
            <h2>$title</h2>
            <p>$message</p>
            <div class='details'>
              <p><b>Montant :</b> $montant $devise</p>
              <p><b>Compte émetteur :</b> $from</p>
              <p><b>Compte destinataire :</b> $to</p>
              <p><b>Motif :</b> $motif</p>
              <p><b>Date :</b> " . date("d/m/Y H:i") . "</p>
            </div>
            <p class='footer'>
              Ceci est un email automatique, merci de ne pas répondre.<br>
              © " . date("Y") . " AIADES Finances. Tous droits réservés.
            </p>
          </div>
        </body>
      </html>";
  }


  $mail = new PHPMailer(true);
  try {
    // Débogage SMTP (0 = désactivé)
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    // 🔹 Config serveur SMTP (à personnaliser selon ton hébergeur)
    $mail->isSMTP();
    $mail->Host       = 'mail54.lwspanel.com'; // Exemple Gmail
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@ahlydarelsalamfinance.com';
    $mail->Password   = 'fW3@zURtr1_ft!v';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->Timeout    = 30;

    $mail->SMTPOptions = [
      'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      ]
    ];

    // Expéditeur
    $mail->setFrom('info@ahlydarelsalamfinance.com', 'Ahly Dar El Salam Finances');
    $mail->addReplyTo('info@ahlydarelsalamfinance.com', 'Support Ahly Dar El Salam Finances');

    // 🔹 Mail émetteur
    if ($emailEmetteur) {
      $mail->addAddress($emailEmetteur);
      $mail->isHTML(true);
      $mail->Subject = "Confirmation de votre transfert";
      $mail->Body    = generateTransferEmail("emetteur", $montant, $devise, $numCdonneur, $numCrecip, $motif);
      $mail->send();
      $mail->clearAddresses();
    }

    // 🔹 Mail destinataire
    if ($emailDestinataire) {
      $mail->addAddress($emailDestinataire);
      $mail->isHTML(true);
      $mail->Subject = "Vous avez reçu un transfert";
      $mail->Body    = generateTransferEmail("destinataire", $montant, $devise, $numCdonneur, $numCrecip, $motif);
      $mail->send();
      $mail->clearAddresses();
    }
  } catch (Exception $e) {
    error_log("Erreur envoi mail : {$mail->ErrorInfo}");
  }

  // ✅ Réponse JSON
  echo json_encode([
    'success' => true,
    'message' => '✅ Transfert effectué avec succès !',
    'newSolde' => $newSolde
  ]);
} catch (Exception $e) {
  echo json_encode([
    'success' => false,
    'message' => 'Erreur lors du transfert : ' . $e->getMessage()
  ]);
}
