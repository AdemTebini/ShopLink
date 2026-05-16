<?php
if ($_SESSION['user']['role'] != 'admin') exit();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs - Admin ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
    <style>
        .dashboard-grid { display: grid; grid-template-columns: 250px 1fr; gap: 2rem; min-height: calc(100vh - 64px); }
        .sidebar { background: var(--surface); border-right: 1px solid var(--border-color); padding: 2rem 1rem; }
        .sidebar-menu { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; }
        .sidebar-menu a { display: block; padding: 0.75rem 1rem; border-radius: var(--radius); color: var(--text-main); font-weight: 500; transition: all 0.2s; }
        .sidebar-menu a:hover { background: #f1f5f9; color: var(--primary); }
        .dashboard-content { padding: 2rem; }
        @media (max-width: 768px) { .dashboard-grid { grid-template-columns: 1fr; } .sidebar { border-right: none; border-bottom: 1px solid var(--border-color); } }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=admin_dashboard" class="navbar-brand">⚙️ Shop<span>Link</span> <small style="color: var(--danger); font-size: 0.9rem;">Admin</small></a>
            <div class="navbar-nav">
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-grid">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="index.php?page=admin_dashboard">📊 Vue d'ensemble</a></li>
                <li><a href="index.php?page=users" style="background: #fee2e2; color: var(--danger);">👥 Utilisateurs</a></li>
                <li><a href="index.php?page=produits">📦 Produits</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Gestion des utilisateurs 👥</h1>
            </div>

            <div class="card" style="padding: 0; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($u = $users->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $u['id']; ?></td>
                                    <td style="font-weight: 600;"><?= htmlspecialchars($u['nom']); ?></td>
                                    <td><?= htmlspecialchars($u['email']); ?></td>
                                    <td>
                                        <?php
                                        $statusClass = 'badge-success';
                                        if ($u['status'] === 'pending') $statusClass = 'badge-pending';
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $u['status']; ?></span>
                                    </td>
                                    <td>
                                        <form method="POST" action="/ShopLink/app/controllers/UserController.php" style="display: flex; gap: 0.5rem; align-items: center;">
                                            <input type="hidden" name="user_id" value="<?= $u['id']; ?>">
                                            <select name="role" class="form-control" style="padding: 0.3rem; font-size: 0.85rem; width: auto;">
                                                <option value="client" <?= $u['role'] == 'client' ? 'selected' : '' ?>>Client</option>
                                                <option value="vendeur" <?= $u['role'] == 'vendeur' ? 'selected' : '' ?>>Vendeur</option>
                                                <option value="livreur" <?= $u['role'] == 'livreur' ? 'selected' : '' ?>>Livreur</option>
                                                <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            </select>
                                            <button type="submit" name="update_role" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Modifier</button>
                                        </form>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                                            <?php if ($u['status'] == 'pending'): ?>
                                                <a href="/ShopLink/app/controllers/AdminController.php?approve=<?= $u['id']; ?>" class="btn btn-success" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">✅</a>
                                                <a href="/ShopLink/app/controllers/AdminController.php?reject=<?= $u['id']; ?>" class="btn btn-danger" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">❌</a>
                                            <?php endif; ?>
                                            
                                            <a href="/ShopLink/app/controllers/UserController.php?delete=<?= $u['id']; ?>" class="btn btn-danger" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                                🗑️
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>