<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<style>
  .highlight-input {
    border: 2px solid #325385ff;
    border-radius: 6px;
    box-shadow: 0 0 4px rgba(25, 54, 98, 0.4);
    transition: 0.3s;
  }

  .highlight-input:focus {
    border-color: #198754;
    box-shadow: 0 0 6px rgba(25, 135, 84, 0.6);
    outline: none;
  }
</style>

<div class="container-fluid py-2">

  <!-- Solde disponible -->
  <div class="row mt-3">
    <div class="col-xl-4 col-sm-6">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <p class="text-sm mb-0">Solde disponible</p>
          <h4 class="mb-0"><span id="solde"></span></h4>
        </div>
      </div>
    </div>
  </div>

  <br>

  <!-- Formulaire de virement -->
  <div class="row">
    <div class="col-xl-10">
      <div class="card">
        <div class="card-header">
          <h5>Transférer de l'argent</h5>
        </div>
        <div class="card-body">
          <form id="transferForm" class="form">
            <input type="hidden" name="instruction" value="transArg" />
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="fromAccount" class="form-label">Depuis le compte</label>
                <input type="text" class="form-control highlight-input" id="fromAccount" name="numCdonneur" readonly>
              </div>
              <div class="col-md-6 mb-3">
                <label for="toIban" class="form-label">Vers N° compte</label>
                <input type="text" class="form-control highlight-input" id="toIban" name="numCrecip" required>
                <small id="accountCheck" class="text-danger" style="display:none;">Compte inexistant</small>
              </div>
              <div class="col-md-6 mb-3">
                <label for="amount" class="form-label">Montant</label>
                <input type="number" class="form-control highlight-input" id="amount" name="montantrans" placeholder="EX: 500, 1000, 100000" min="500" step="0.01" required>
                <small id="amountCheck" class="text-danger" style="display:none;">Compte inexistant</small>
                <small id="soldeCheck" class="text-danger" style="display:none;">Compte inexistant</small>
              </div>
              <div class="col-md-6 mb-3">
                <label for="currency" class="form-label">Devise</label>
                <input type="text" class="form-control highlight-input" id="currency" name="devise" value="XOF (CFA)" required>
              </div>
              <div class="col-md-12 mb-3">
                <label for="label" class="form-label">Motif d'envoi</label>
                <input type="text" class="form-control highlight-input" id="label" name="motifenvoie" maxlength="60">
              </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <button type="reset" class="btn btn-secondary">Annuler</button>
              <button type="submit" class="btn btn-success">Confirmer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals pour confirmation, erreur et succès (simplifié) -->
  <div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation du Transfert</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Vérifiez les informations avant de valider :</p>
          <ul>
            <li><b>Depuis :</b> <span id="confirmFrom"></span></li>
            <li><b>Vers :</b> <span id="confirmTo"></span></li>
            <li><b>Montant :</b> <span id="confirmAmount"></span> <span id="confirmCurrency"></span></li>
            <li><b>Libellé :</b> <span id="confirmLabel"></span></li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-success" id="confirmBtn">Valider</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Erreur</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="errorModalMessage">Une erreur est survenue.</div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-success">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Succès</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="successModalMessage">✅ Transfert effectué avec succès !</div>
      </div>
    </div>
  </div>
</div>

<script>
  async function chargerInfosCompte() {
    try {
      const response = await fetch('/appfinances/main/api/getinfoconcter.php');
      const data = await response.json();

      if (data.error) {
        console.error(data.error);
        return;
      }

      // Remplir numéro de compte
      document.getElementById("fromAccount").value = data.numeroCompte;

      // Remplir solde
      soldeDisplay.textContent = new Intl.NumberFormat("fr-FR").format(data.solde) + " FCFA";
    } catch (err) {
      console.error("Erreur lors du chargement du compte :", err);
    }
  }

  // Références DOM
  const soldeDisplay = document.getElementById("solde");
  const toIban = document.getElementById("toIban");
  const accountCheck = document.getElementById("accountCheck");
  const amountInput = document.getElementById("amount");
  const amountCheck = document.getElementById("amountCheck");
  const soldeCheck = document.getElementById("soldeCheck");

  // États de validation
  let compteValide = false;
  let montantValide = false;

  // Charger au démarrage et toutes les 10 secondes
  chargerInfosCompte();
  setInterval(chargerInfosCompte, 10000);

  // Vérifier compte destinataire
  toIban.addEventListener("blur", async () => {
    const numDest = toIban.value.trim();
    if (numDest === "") {
      accountCheck.style.display = "none";
      compteValide = false;
      return;
    }

    try {
      const res = await fetch(`/appfinances/main/api/verifierCompte.php?numCrecip=${encodeURIComponent(numDest)}`);
      const data = await res.json();

      if (data.exists) {
        accountCheck.style.display = "none";
        compteValide = true;
      } else {
        accountCheck.textContent = "Le compte destinataire n'existe pas.";
        accountCheck.style.display = "block";
        compteValide = false;
      }
    } catch (err) {
      console.error(err);
      accountCheck.textContent = "Erreur réseau, impossible de vérifier le compte.";
      accountCheck.style.display = "block";
      compteValide = false;
    }
  });
  // Vérification montant et solde suffisant (côté client)
  amountInput.addEventListener("blur", () => {
    const montant = parseFloat(amountInput.value);
    if (isNaN(montant) || montant < 500) {
      amountCheck.textContent = "Le montant doit être ≥ 500 FCFA.";
      amountCheck.style.display = "block";
      montantValide = false;
      soldeCheck.style.display = "none";
      return;
    } else {
      amountCheck.style.display = "none";
      montantValide = true;
    }

    // Vérification solde
    let soldeTexte = soldeDisplay.textContent.replace(/\s/g, '').replace('FCFA', '');
    const solde = parseFloat(soldeTexte);

    if (solde >= montant) {
      soldeCheck.style.display = "none";
      montantValide = true;
    } else {
      soldeCheck.textContent = `Solde insuffisant (Votre solde : ${new Intl.NumberFormat("fr-FR").format(solde)} FCFA)`;
      soldeCheck.style.display = "block";
      montantValide = false;
    }
  });
  // Formulaire
  const transferForm = document.getElementById("transferForm");
  const confirmModal = new bootstrap.Modal(document.getElementById("confirmModal"));
  const successModal = new bootstrap.Modal(document.getElementById("successModal"));
  const errorModal = new bootstrap.Modal(document.getElementById("errorModal"));

  // Champs confirmation
  const confirmFrom = document.getElementById("confirmFrom");
  const confirmTo = document.getElementById("confirmTo");
  const confirmAmount = document.getElementById("confirmAmount");
  const confirmCurrency = document.getElementById("confirmCurrency");
  const confirmLabel = document.getElementById("confirmLabel");

  // Afficher la modal de confirmation
  transferForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const soldeActuel = parseFloat(soldeDisplay.textContent.replace(/\s/g, '').replace("FCFA", ""));

    if (soldeActuel < 400) {
      alert("Votre solde doit être ≥ 400 FCFA pour effectuer un transfert.");
      return;
    }
    if (!compteValide) {
      alert("Le compte destinataire n'est pas valide.");
      return;
    }
    if (!montantValide) {
      alert("Veuillez saisir un montant valide (≥ 500 FCFA et ≤ solde disponible).");
      return;
    }

    confirmFrom.textContent = document.getElementById("fromAccount").value;
    confirmTo.textContent = toIban.value;
    confirmAmount.textContent = amountInput.value;
    confirmCurrency.textContent = document.getElementById("currency").value;
    confirmLabel.textContent = document.getElementById("label").value || "-";

    confirmModal.show();
  });

  // Valider transfert
  document.getElementById("confirmBtn").addEventListener("click", async () => {
    const formData = new FormData(transferForm);

    try {
      const res = await fetch("/appfinances/main/api/transfert.php", {
        method: "POST",
        body: formData
      });
      const data = await res.json();

      confirmModal.hide();

      if (data.success) {
        soldeDisplay.textContent = new Intl.NumberFormat("fr-FR").format(data.newSolde) + " FCFA";
        transferForm.reset();
        compteValide = false;
        montantValide = false;
        successModal.show();
      } else {
        document.getElementById("errorModalMessage").textContent = data.message;
        errorModal.show();
      }

    } catch {
      document.getElementById("errorModalMessage").textContent = "Erreur réseau, veuillez réessayer.";
      errorModal.show();
    }
  });
</script>