<?php
if (!isset($_SESSION['user'])) {
    header("Location: /ShopLink/public/index.php?page=login");
    exit();
}
$is_client = $_SESSION['user']['role'] === 'client';
$home_url = $is_client ? "index.php?page=client_home" : "index.php?page=vendeur_dashboard";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Messages - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
    <style>
        .msg-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .msg-item {
            background: var(--surface);
            border: 1px solid var(--border-color);
            margin-bottom: 1rem;
            border-radius: var(--radius);
            transition: transform 0.2s, box-shadow 0.2s;
            display: block;
            text-decoration: none !important;
            color: inherit;
        }
        .msg-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            border-color: var(--primary);
        }
        .msg-item-inner {
            padding: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }
        .msg-info {
            flex-grow: 1;
        }
        .msg-name {
            font-weight: 700;
            color: var(--text-main);
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .msg-role {
            font-size: 0.75rem;
            background: #e5e7eb;
            color: var(--text-muted);
            padding: 0.1rem 0.5rem;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .msg-preview {
            color: var(--text-muted);
            font-size: 0.95rem;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
        }
        .msg-meta {
            text-align: right;
            min-width: 80px;
        }
        .msg-time {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: block;
        }
        .unread-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            border-radius: 50%;
            margin-top: 0.5rem;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px dashed var(--border-color);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?= htmlspecialchars($home_url) ?>" class="navbar-brand">
                <?= $is_client ? '🛒' : '🏪' ?> Shop<span>Link</span>
                <small style="color: var(--text-muted); font-size: 0.9rem; margin-left: 0.5rem;">
                    <?= $is_client ? 'Client' : 'Vendeur' ?>
                </small>
            </a>
            <div class="navbar-nav">
                <a href="<?= htmlspecialchars($home_url) ?>" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 800px;">
        <div class="page-header">
            <h1 class="page-title">💬 Mes Messages</h1>
        </div>

        <?php if ($conversations && $conversations->num_rows > 0): ?>
            <ul class="msg-list">
                <?php while ($conv = $conversations->fetch_assoc()): ?>
                    <li>
                        <a href="index.php?page=chat&id=<?= $conv['contact_id'] ?>" class="msg-item">
                            <div class="msg-item-inner">
                                <div class="msg-info">
                                    <div class="msg-name">
                                        <?= htmlspecialchars($conv['contact_nom']) ?>
                                        <span class="msg-role"><?= htmlspecialchars($conv['contact_role']) ?></span>
                                    </div>
                                    <div class="msg-preview">
                                        <?= htmlspecialchars($conv['last_message']) ?>
                                    </div>
                                </div>
                                <div class="msg-meta">
                                    <span class="msg-time">
                                        <?= date('d/m H:i', strtotime($conv['last_time'])) ?>
                                    </span>
                                    <?php if ($conv['is_read'] == 0 && isset($conv['receiver_id']) && $conv['receiver_id'] == $_SESSION['user']['id']): ?>
                                        <span class="unread-dot"></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="empty-state">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                <h3>Aucun message</h3>
                <p>Vous n'avez pas encore de conversations.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
