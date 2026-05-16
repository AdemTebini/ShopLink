<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Security: must be logged in
if (!isset($_SESSION['user'])) {
    header("Location: /ShopLink/public/index.php?page=login");
    exit();
}

include(__DIR__ . "/../../config/db.php");

$current_user_id = (int)$_SESSION['user']['id'];
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        // List all conversations for the current user
        // We get the latest message for each conversation
        $sql = "
            SELECT 
                u.id AS contact_id, 
                u.nom AS contact_nom, 
                u.role AS contact_role,
                m.message AS last_message, 
                m.created_at AS last_time,
                m.is_read
            FROM users u
            JOIN messages m ON (u.id = m.sender_id OR u.id = m.receiver_id)
            WHERE u.id != ? AND m.id IN (
                SELECT MAX(id) 
                FROM messages 
                WHERE sender_id = ? OR receiver_id = ? 
                GROUP BY LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)
            )
            ORDER BY m.created_at DESC
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $current_user_id, $current_user_id, $current_user_id);
        $stmt->execute();
        $conversations = $stmt->get_result();
        
        include(__DIR__ . "/../views/messages/index.php");
        break;

    case 'chat':
        $contact_id = (int)($_GET['id'] ?? 0);
        
        if ($contact_id === 0 || $contact_id === $current_user_id) {
            header("Location: /ShopLink/public/index.php?page=messages");
            exit();
        }

        // Get contact details
        $stmtUser = $conn->prepare("SELECT id, nom, role FROM users WHERE id = ?");
        $stmtUser->bind_param("i", $contact_id);
        $stmtUser->execute();
        $contact = $stmtUser->get_result()->fetch_assoc();

        if (!$contact) {
            header("Location: /ShopLink/public/index.php?page=messages");
            exit();
        }

        // Mark messages as read
        $stmtRead = $conn->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ? AND is_read = 0");
        $stmtRead->bind_param("ii", $contact_id, $current_user_id);
        $stmtRead->execute();

        // Get messages between current user and contact
        $stmtMsg = $conn->prepare("
            SELECT * FROM messages 
            WHERE (sender_id = ? AND receiver_id = ?) 
               OR (sender_id = ? AND receiver_id = ?)
            ORDER BY created_at ASC
        ");
        $stmtMsg->bind_param("iiii", $current_user_id, $contact_id, $contact_id, $current_user_id);
        $stmtMsg->execute();
        $messages = $stmtMsg->get_result();

        include(__DIR__ . "/../views/messages/chat.php");
        break;

    case 'send':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $receiver_id = (int)$_POST['receiver_id'];
            $message = trim($_POST['message'] ?? '');

            if ($receiver_id > 0 && !empty($message)) {
                $stmtSend = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
                $stmtSend->bind_param("iis", $current_user_id, $receiver_id, $message);
                $stmtSend->execute();
            }
            
            header("Location: /ShopLink/public/index.php?page=chat&id=" . $receiver_id);
            exit();
        }
        break;

    default:
        header("Location: /ShopLink/public/index.php?page=messages");
        exit();
}
