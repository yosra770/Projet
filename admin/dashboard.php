<?php include("../includes/header.php"); ?>
<?php include("sidebar.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maison NYA | Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/web2/projet/style.css">
</head>
<body>

   

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="section-title mb-0">Bienvenue, Nada & Yosra</h2>
                <p class="text-muted">Voici l'état actuel de votre boutique.</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="me-3 text-end">
                    <small class="d-block text-muted">22 Avril 2026</small>
                    <strong>Tableau de bord</strong>
                </div>
                <img src="https://ui-avatars.com/api/?name=NY&background=d4af37&color=fff" class="rounded-circle" width="45" alt="Profile">
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-custom">
                    <div class="icon-circle bg-gold-light">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-value">120</div>
                    <div class="stat-label">Produits en ligne</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-custom">
                    <div class="icon-circle bg-blue-light">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-value">75</div>
                    <div class="stat-label">Commandes ce mois</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-custom">
                    <div class="icon-circle bg-purple-light">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">50</div>
                    <div class="stat-label">Nouveaux Clients</div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="section-title" style="font-size: 1.5rem;">Actions Stratégiques</h4>
            <div class="card-custom">
                <div class="d-flex flex-wrap gap-3">
                    <button class="btn-nya">
                        <i class="fas fa-plus me-2"></i> Nouveau Produit
                    </button>
                    <button class="btn-nya" style="background: white; color: black; border: 1px solid #eee;">
                        <i class="fas fa-file-export me-2"></i> Exporter Rapports
                    </button>
                    <button class="btn-nya" style="background: #f8f9fa; color: #666;">
                        <i class="fas fa-envelope me-2"></i> Newsletter Clients
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php include("../includes/footer.php"); ?>