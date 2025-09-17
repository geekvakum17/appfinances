<div class="container-fluid px-2 px-md-4">
  <div class="page-header min-height-300 border-radius-xl mt-4"
    style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?auto=format&fit=crop&w=1920&q=80');">
    <span class="mask bg-gradient-dark opacity-6"></span>
  </div>
  <div class="card card-body mx-2 mx-md-2 mt-n6">
    <div class="row gx-4 mb-2">
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img src="public/assets/img/user.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
        </div>
      </div>
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1" id="nom">Richard Davis</h5>
          <hr class="horizontal gray-light my-4">
          <ul class="list-group">
            <li class="list-group-item border-0 ps-0 text-sm">
              <strong class="text-dark">Contact:</strong> &nbsp;
              <span id="contact">(44) 123 1234 123</span>
            </li>
            <li class="list-group-item border-0 ps-0 text-sm">
              <strong class="text-dark">Email:</strong> &nbsp;
              <span id="email">alecthompson@mail.com</span>
            </li>
          </ul>

          <!-- ✅ Bouton pour ouvrir le modal -->
          <div class="mt-3">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPassword">
              Modifier le mot de passe
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Modal modification mot de passe -->
<div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-radius-xl">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPasswordLabel">Modifier le mot de passe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <form id="formPassword">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Mot de passe actuel</label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const BASE_URL = "<?= BASE_URL ?>"; // définie côté PHP

  // Charger les infos du profil
  fetch(`${BASE_URL}main/api/getInfoprofile.php`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById("nom").innerText = data.client.nom || "—";
        document.getElementById("contact").innerText = data.client.contact || "—";
        document.getElementById("email").innerText = data.client.email || data.client.org_email || "—";
      } else {
        console.error(data.message);
      }
    })
    .catch(err => console.error("Erreur API profil:", err));

  // Gestion formulaire changement mot de passe
  document.getElementById("formPassword").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`${BASE_URL}main/api/updatePassword.php`, {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) {
          document.getElementById("formPassword").reset();
          const modal = bootstrap.Modal.getInstance(document.getElementById("modalPassword"));
          modal.hide();
        }
      })
      .catch(err => console.error("Erreur API password:", err));
  });
</script>