<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Microfinance Gestion - Dashboard</title>
  <style>
    /* Reset basique */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background: #f4f6f9;
      color: #333;
    }

    /* Sidebar */
    nav.sidebar {
      width: 250px;
      background-color: #004d40;
      color: white;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    nav.sidebar h2 {
      margin-bottom: 30px;
      font-weight: 700;
      letter-spacing: 1.2px;
      text-align: center;
      user-select: none;
    }

    nav.sidebar a {
      color: white;
      text-decoration: none;
      padding: 12px 15px;
      border-radius: 5px;
      display: block;
      margin-bottom: 10px;
      transition: background-color 0.3s ease;
    }

    nav.sidebar a:hover,
    nav.sidebar a.active {
      background-color: #00796b;
    }

    /* Main content */
    main.content {
      flex-grow: 1;
      padding: 20px 40px;
    }

    header.page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    header.page-header h1 {
      font-size: 24px;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      border-radius: 5px;
      overflow: hidden;
    }

    table thead {
      background-color: #00796b;
      color: white;
    }

    table th,
    table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    table tbody tr:hover {
      background-color: #f1f8f7;
    }

    /* Form */
    form {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      max-width: 500px;
      margin-top: 30px;
    }

    form label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
    }

    form input,
    form select {
      width: 100%;
      padding: 10px 8px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    form input:focus,
    form select:focus {
      outline: none;
      border-color: #00796b;
    }

    form button {
      background-color: #00796b;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 4px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    form button:hover {
      background-color: #004d40;
    }

    /* Responsive */
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      nav.sidebar {
        width: 100%;
        flex-direction: row;
        overflow-x: auto;
        padding: 10px 5px;
      }

      nav.sidebar a {
        margin: 0 10px 0 0;
        flex-shrink: 0;
      }

      main.content {
        padding: 15px 10px;
      }
    }
  </style>
</head>

<body>

  <nav class="sidebar">
    <h2>Microfinance AIADES</h2>
    <a href="#" class="active" data-section="dashboard">Tableau de bord</a>
    <a href="#" data-section="clients">Clients</a>
    <a href="#" data-section="comptes">Comptes</a>
    <a href="#" data-section="operations">Opérations</a>
    <a href="#" data-section="rapports">Rapports</a>
    <a href="#" data-section="parametres">Paramètres</a>
  </nav>

  <main class="content">
    <header class="page-header">
      <h1>Tableau de bord</h1>
      <div id="date"></div>
    </header>

    <section id="dashboard-section" class="section active-section">
      <h2>Bienvenue dans votre application de gestion microfinance</h2>
      <p>Utilisez le menu pour naviguer entre les sections.</p>
    </section>

    <section id="clients-section" class="section" style="display:none;">
      <h2>Liste des clients</h2>
      <table>
        <thead>
          <tr>
            <th>ID Client</th>
            <th>Nom complet</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="clients-table-body">
          <!-- Données insérées en JS -->
        </tbody>
      </table>

      <form id="client-form">
        <h3>Ajouter un nouveau client</h3>
        <label for="nomClient">Nom complet</label>
        <input type="text" id="nomClient" name="nomClient" required />
        <label for="telClient">Téléphone</label>
        <input type="tel" id="telClient" name="telClient" required />
        <label for="emailClient">Email</label>
        <input type="email" id="emailClient" name="emailClient" />
        <button type="submit">Ajouter Client</button>
      </form>
    </section>

    <section id="comptes-section" class="section" style="display:none;">
      <h2>Gestion des comptes</h2>
      <p>Section en construction...</p>
    </section>

    <section id="operations-section" class="section" style="display:none;">
      <h2>Opérations financières</h2>
      <p>Section en construction...</p>
    </section>

    <section id="rapports-section" class="section" style="display:none;">
      <h2>Rapports et statistiques</h2>
      <p>Section en construction...</p>
    </section>

    <section id="parametres-section" class="section" style="display:none;">
      <h2>Paramètres de l'application</h2>
      <p>Section en construction...</p>
    </section>
  </main>

  <script>
    // Gestion du menu et affichage des sections
    const navLinks = document.querySelectorAll('nav.sidebar a');
    const sections = document.querySelectorAll('main.content .section');

    navLinks.forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        // Désactive tous les liens
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');

        // Affiche la section correspondante
        const target = link.getAttribute('data-section');
        sections.forEach(sec => {
          if (sec.id === target + '-section') {
            sec.style.display = 'block';
          } else {
            sec.style.display = 'none';
          }
        });

        // Change le titre de la page
        document.querySelector('header.page-header h1').textContent = link.textContent;
      });
    });

    // Affiche la date du jour dans le header
    const dateEl = document.getElementById('date');
    const now = new Date();
    dateEl.textContent = now.toLocaleDateString('fr-FR', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });

    // Exemple simple de gestion clients
    let clients = [{
        id: 1,
        nom: "Ahoua Konan",
        tel: "0700000000",
        email: "ahoua@example.com"
      },
      {
        id: 2,
        nom: "Jean Koffi",
        tel: "0711111111",
        email: "jean@example.com"
      }
    ];

    function renderClients() {
      const tbody = document.getElementById('clients-table-body');
      tbody.innerHTML = '';
      clients.forEach(client => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
                    <td>${client.id}</td>
                    <td>${client.nom}</td>
                    <td>${client.tel}</td>
                    <td>${client.email || '-'}</td>
                    <td>
                        <button onclick="alert('Editer client ${client.id}')">✏️</button>
                        <button onclick="deleteClient(${client.id})" style="color:red;">🗑️</button>
                    </td>
                `;
        tbody.appendChild(tr);
      });
    }

    function deleteClient(id) {
      if (confirm('Voulez-vous vraiment supprimer ce client ?')) {
        clients = clients.filter(c => c.id !== id);
        renderClients();
      }
    }

    document.getElementById('client-form').addEventListener('submit', e => {
      e.preventDefault();
      const nom = e.target.nomClient.value.trim();
      const tel = e.target.telClient.value.trim();
      const email = e.target.emailClient.value.trim();

      if (nom === '' || tel === '') {
        alert('Nom et téléphone sont obligatoires');
        return;
      }

      const newId = clients.length ? clients[clients.length - 1].id + 1 : 1;
      clients.push({
        id: newId,
        nom,
        tel,
        email
      });
      renderClients();

      e.target.reset();
      alert('Client ajouté avec succès !');
    });

    // Initial render
    renderClients();
  </script>
</body>

</html>