<?php
if (!isset($_SESSION['user'])) {
    header("Location: /ShopLink/public/index.php?page=login");
    exit();
}
$current_user_id = (int)$_SESSION['user']['id'];
$is_client = $_SESSION['user']['role'] === 'client';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat avec <?= htmlspecialchars($contact['nom']) ?> - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 180px);
            max-height: 700px;
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        .chat-header {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-header h2 {
            font-size: 1.2rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .chat-role {
            font-size: 0.75rem;
            background: #e2e8f0;
            color: #475569;
            padding: 0.2rem 0.5rem;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .chat-messages {
            flex-grow: 1;
            padding: 1.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            background: #f1f5f9;
        }
        .message-bubble {
            max-width: 75%;
            padding: 0.8rem 1rem;
            border-radius: 1rem;
            position: relative;
            word-break: break-word;
            line-height: 1.4;
        }
        .msg-sent {
            align-self: flex-end;
            background: var(--primary);
            color: white;
            border-bottom-right-radius: 0.25rem;
        }
        .msg-received {
            align-self: flex-start;
            background: white;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            border-bottom-left-radius: 0.25rem;
        }
        .msg-time {
            font-size: 0.7rem;
            opacity: 0.8;
            margin-top: 0.25rem;
            text-align: right;
            display: block;
        }
        .msg-received .msg-time {
            color: var(--text-muted);
        }
        .chat-input-area {
            padding: 1rem 1.5rem;
            background: white;
            border-top: 1px solid var(--border-color);
        }
        .chat-form {
            display: flex;
            gap: 0.75rem;
        }
        .chat-input {
            flex-grow: 1;
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.75rem 1.25rem;
            outline: none;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }
        .chat-input:focus {
            border-color: var(--primary);
        }
        .btn-send {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 9999px;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
        }
        .btn-send:hover {
            background: var(--primary-hover);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=messages" class="navbar-brand">
                ⬅️ Retour
            </a>
            <div class="navbar-nav">
                <span style="font-weight: bold;">💬 Messagerie</span>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 800px;">
        <div class="chat-container">
            <div class="chat-header">
                <h2>
                    <?= htmlspecialchars($contact['nom']) ?>
                    <span class="chat-role"><?= htmlspecialchars($contact['role']) ?></span>
                </h2>
                <button onclick="location.reload();" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                    🔄 Rafraîchir
                </button>
            </div>

            <div class="chat-messages" id="chatMessages">
                <?php if ($messages && $messages->num_rows > 0): ?>
                    <?php while ($msg = $messages->fetch_assoc()): ?>
                        <?php $is_mine = $msg['sender_id'] == $current_user_id; ?>
                        <div class="message-bubble <?= $is_mine ? 'msg-sent' : 'msg-received' ?>">
                            <?= nl2br(htmlspecialchars($msg['message'])) ?>
                            <span class="msg-time"><?= date('H:i', strtotime($msg['created_at'])) ?></span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div style="text-align: center; color: var(--text-muted); margin-top: 2rem;">
                        <p>Aucun message. Commencez la conversation !</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="chat-input-area">
                <form action="index.php?page=send_message" method="POST" class="chat-form">
                    <input type="hidden" name="receiver_id" value="<?= $contact['id'] ?>">
                    <input type="text" name="message" class="chat-input" placeholder="Écrivez votre message..." required autocomplete="off" autofocus>
                    <button type="submit" class="btn-send" title="Envoyer">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const chatMessages = document.getElementById('chatMessages');
        
        // Scroll to bottom of chat initially
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Auto-refresh chat every 3 seconds
        setInterval(() => {
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMessagesContainer = doc.getElementById('chatMessages');
                    
                    if (newMessagesContainer) {
                        const newMessages = newMessagesContainer.innerHTML;
                        
                        // Only update and scroll if there is new content
                        if (chatMessages.innerHTML !== newMessages) {
                            chatMessages.innerHTML = newMessages;
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }
                    }
                })
                .catch(err => console.error("Error refreshing chat:", err));
        }, 3000);
    </script>
</body>
</html>
