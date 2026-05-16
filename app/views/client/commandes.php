<?php
if (!isset($_SESSION['user'])) exit();

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

$commandesRows = isset($commandes) ? $commandes->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
    <style>
        .timeline {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            gap: 10px;
        }
        .step {
            flex: 1;
            text-align: center;
            font-size: 0.85rem;
            padding: 0.75rem;
            border-radius: var(--radius);
            background: #f1f5f9;
            color: var(--text-muted);
            font-weight: 500;
        }
        .step.active {
            background: var(--secondary);
            color: white;
            font-weight: 700;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        .step.done {
            background: var(--success);
            color: white;
            font-weight: 600;
        }
        .step.refused {
            background: var(--danger);
            color: white;
            font-weight: 600;
        }
        .timeline-arrow {
            color: var(--text-muted);
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .timeline {
                flex-direction: column;
                align-items: stretch;
            }
            .timeline-arrow {
                text-align: center;
                transform: rotate(90deg);
                margin: 0.25rem 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=client_home" class="navbar-brand">
                🛒 Shop<span>Link</span>
            </a>
            <div class="navbar-nav">
                <a href="/ShopLink/public/index.php?page=client_commandes" class="nav-user" style="color: var(--primary);">📦 Mes Commandes</a>
                <a href="/ShopLink/public/index.php?page=panier" class="nav-user">🛒 Panier</a>
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Mes Commandes</h1>
            <a href="/ShopLink/public/index.php?page=client_home" class="btn btn-secondary">Retour aux achats</a>
        </div>

        <?php if (count($commandesRows) === 0): ?>
            <div class="card" style="text-align: center; padding: 4rem 1rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
                <h2 style="margin-bottom: 1rem;">Vous n'avez passé aucune commande pour le moment.</h2>
                <a href="index.php?page=client_home" class="btn btn-primary">Découvrir nos produits</a>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?php foreach ($commandesRows as $row): ?>
                    <div class="card" style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem; color: var(--text-main);">
                                    Commande #<?= $row['id']; ?> - <?= e($row['produit_nom']); ?>
                                </h3>
                                <div style="color: var(--text-muted); font-size: 0.9rem;">
                                    <strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($row['created_at'])); ?>
                                </div>
                            </div>
                            
                            <div style="text-align: right;">
                                <div style="font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
                                    Quantité : <?= (int)$row['quantite']; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div style="background: #f8fafc; padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border-color); font-size: 0.95rem;">
                            <strong>📍 Livraison à :</strong> <?= e($row['adresse']); ?>, <?= e($row['ville']); ?>
                        </div>

                        <?php
                            $s = $row['statut'];
                            $step1 = ($s == 'en attente') ? 'active' : 'done';
                            
                            $step2 = '';
                            if ($s == 'en attente livraison') $step2 = 'active';
                            elseif (in_array($s, ['en livraison', 'livree'])) $step2 = 'done';
                            
                            $step3 = '';
                            if ($s == 'en livraison') $step3 = 'active';
                            elseif ($s == 'livree') $step3 = 'done';

                            $step4 = '';
                            if ($s == 'livree') $step4 = 'done';
                        ?>

                        <div class="timeline">
                            <?php if ($s == 'refusee'): ?>
                                <div class="step refused">Commande annulée / refusée</div>
                            <?php else: ?>
                                <div class="step <?= $step1 ?>">1. Validation Vendeur</div>
                                <div class="timeline-arrow">➔</div>
                                <div class="step <?= $step2 ?>">2. Recherche Livreur</div>
                                <div class="timeline-arrow">➔</div>
                                <div class="step <?= $step3 ?>">3. En cours de livraison</div>
                                <div class="timeline-arrow">➔</div>
                                <div class="step <?= $step4 ?>">4. Livrée</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
