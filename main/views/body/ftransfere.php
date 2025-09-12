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
          <form id="transferForm" class="form" method="POST">
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


</div>

<script>
  const BASE_URL = "<?= BASE_URL ?>";
</script>


<script>
  async function chargerInfosCompte() {
    try {
      const response = await fetch(`${BASE_URL}main/api/getinfoconcter.php`);

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

  // Vérifier compte destinataire en POST
  toIban.addEventListener("blur", async () => {
    const numDest = toIban.value.trim();
    if (numDest === "") {
      accountCheck.style.display = "none";
      compteValide = false;
      return;
    }

    try {
      const res = await fetch(`${BASE_URL}main/api/verifierCompte.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `numCrecip=${encodeURIComponent(numDest)}`
      });

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
</script>

<script>
  document.getElementById("transferForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    const fromAccount = formData.get("numCdonneur");
    const toAccount = formData.get("numCrecip");
    const amount = formData.get("montantrans");
    const currency = formData.get("devise");
    const motif = formData.get("motifenvoie") || "Aucun";

    // ✅ Confirmation avant transfert
    Swal.fire({
      title: "Confirmer le transfert",
      html: `
            <p>Voulez-vous vraiment transférer <b>${amount} ${currency}</b> ?</p>
            <p>De : <b>${fromAccount}</b> → Vers : <b>${toAccount}</b></p>
            <p>Motif : ${motif}</p>
        `,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Oui, confirmer",
      cancelButtonText: "Annuler",
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545"
    }).then((result) => {
      if (result.isConfirmed) {
        // ✅ Envoi AJAX
        fetch(`${BASE_URL}main/api/transfert.php`, {
            method: "POST",
            body: formData,
            credentials: "include" // envoie les cookies de session
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: data.message,
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                willClose: () => {
                  window.location.href = `${BASE_URL}?page=menu`;
                }
              });
              form.reset();
              if (data.newSolde !== undefined) {
                document.getElementById("solde").textContent = new Intl.NumberFormat("fr-FR").format(data.newSolde) + " FCFA";
              }
            } else {
              Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
              });
            }
          })
          .catch(err => {
            console.error(err);
            Swal.fire({
              toast: true,
              position: "top-end",
              icon: "warning",
              title: "Impossible de traiter le transfert",
              showConfirmButton: false,
              timer: 4000,
              timerProgressBar: true
            });
          });
      }
    });
  });
</script>