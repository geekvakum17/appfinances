<div class="container-fluid px-2 px-md-4">
  <div class="page-header min-height-300 border-radius-xl mt-4"
    style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?auto=format&fit=crop&w=1920&q=80');">
    <span class="mask bg-gradient-dark opacity-6"></span>
  </div>
  <div class="card card-body mx-2 mx-md-2 mt-n6">
    <div class="row gx-4 mb-2">
      <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
          <img id="profileImage"
            src="public/assets/user/user.png"
            alt="profile_image"
            class="w-100 border-radius-lg shadow-sm"
            style="cursor:pointer;"
            title="Cliquez pour changer la photo">
          <input type="file" id="uploadPhoto" accept="image/*" style="display:none;">
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
            <li class="list-group-item border-0 ps-0 text-sm">
              <strong class="text-dark">Adresse</strong> &nbsp;
              <span id="adresse">alecthompson@mail.com</span>
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
  const BASE_URL = "<?= BASE_URL ?>"; // défini côté PHP
  const profileImage = document.getElementById("profileImage");
  const uploadPhoto = document.getElementById("uploadPhoto");

  // Fonction pour forcer le rechargement de l'image avec cache-buster
  function setProfileImage(path) {
    profileImage.src = `${BASE_URL}${path}?t=${Date.now()}`;
  }

  // 1️⃣ Charger les infos et la photo du profil au chargement
  document.addEventListener("DOMContentLoaded", async () => {
    try {
      const res = await fetch(`${BASE_URL}main/api/getInfoprofile.php`);
      const data = await res.json();

      if (data.success) {
        // Infos utilisateur
        document.getElementById("nom").innerText = data.client.nom || "—";
        document.getElementById("contact").innerText = data.client.contact || "—";
        document.getElementById("email").innerText = data.client.email || data.client.org_email || "—";
        document.getElementById("adresse").innerText = data.client.adresse || "—";

        // ⚡ Définir la photo du profil depuis la BD
        if (data.client.profileimage && data.client.profileimage !== "") {
          profileImage.src = `${BASE_URL}${data.client.photo}?t=${Date.now()}`;
        } else {
          // Optionnel : mettre une image par défaut si aucune photo en base
          profileImage.src = "public/assets/user/user.png";
        }
      }
    } catch (err) {
      console.error("Erreur récupération profil:", err);
    }

  });

  document.addEventListener("DOMContentLoaded", function() {
    fetch(`${BASE_URL}main/api/getprofileImage.php`)
      .then(response => response.json())
      .then(data => {
        if (data.success && data.filePath) {
          document.getElementById("profileImage").src = data.filePath + "?v=" + Date.now();
        }
      })
      .catch(err => console.error("Erreur chargement image:", err));
  });



  // 2️⃣ Cliquer sur l'image ouvre le sélecteur de fichier
  profileImage.addEventListener("click", () => uploadPhoto.click());

  // 3️⃣ Upload de la nouvelle image avec prévisualisation

  uploadPhoto.addEventListener("change", async () => {
    const file = uploadPhoto.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append("photo", file);

    const res = await fetch(`${BASE_URL}main/api/updatePhoto.php`, {
      method: "POST",
      body: formData
    });
    const data = await res.json();
    console.log(data); // ⚡ Vérifie dans la console

    if (data.success) {
      profileImage.src = `${BASE_URL}${data.filePath}?t=${Date.now()}`;
    } else {
      alert(data.message);
    }
  });

  fetch(`${BASE_URL}main/api/updatePhoto.php`, {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById("profileImage").src = data.filePath + "?v=" + Date.now();
      } else {
        alert(data.message);
      }
    });
</script>