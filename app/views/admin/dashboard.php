<h2>Admin Dashboard 🛠️</h2>

<p>Bienvenue <?= $_SESSION['user']['nom']; ?></p>

<a href="index.php?page=users">👥 Users</a><br>
<a href="index.php?page=produits">📦 Produits</a><br>


<br>
<a href="../app/controllers/AuthController.php?logout=1">Logout</a>


<h2>Comptes en attente</h2>

<?php
$sql = "SELECT * FROM users
        WHERE status='pending'
        AND (role='vendeur' OR role='livreur')";

$result = $conn->query($sql);

while ($user = $result->fetch_assoc()):
?>

    <div style="border:1px solid black; padding:10px; margin:10px;">

        <p><strong>Nom:</strong> <?= $user['nom'] ?></p>

        <p><strong>Email:</strong> <?= $user['email'] ?></p>

        <p><strong>Role:</strong> <?= $user['role'] ?></p>

        <p><strong>Ville:</strong> <?= $user['ville'] ?></p>

        <p><strong>Téléphone:</strong> <?= $user['telephone'] ?></p>

        <p><strong>CIN:</strong> <?= $user['cin'] ?></p>

        <a href="../../app/controllers/AdminController.php?approve=<?= $user['id'] ?>">
            Approve
        </a>

        |

        <a href="../../app/controllers/AdminController.php?reject=<?= $user['id'] ?>">
            Reject
        </a>

    </div>

    <h2>Demandes d'inscription</h2>

    <?php

    $sql = "SELECT * FROM users
        WHERE status='pending'
        AND role != 'client'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0):

        while ($user = $result->fetch_assoc()):
    ?>

            <div style="
        border:1px solid #ccc;
        padding:15px;
        margin-bottom:15px;
        border-radius:10px;
    ">

                <h3><?= $user['nom'] ?></h3>

                <p><strong>Email:</strong> <?= $user['email'] ?></p>

                <p><strong>Rôle:</strong> <?= $user['role'] ?></p>

                <p><strong>Ville:</strong> <?= $user['ville'] ?></p>

                <p><strong>Téléphone:</strong> <?= $user['telephone'] ?></p>

                <p><strong>CIN:</strong> <?= $user['cin'] ?></p>

                <a href="../../app/controllers/AdminController.php?approve=<?= $user['id'] ?>">
                    <button>Approve</button>
                </a>

                <a href="../../app/controllers/AdminController.php?reject=<?= $user['id'] ?>">
                    <button>Reject</button>
                </a>

            </div>

        <?php
        endwhile;

    else:
        ?>

        <p>Aucune demande en attente.</p>

    <?php endif; ?>

<?php endwhile; ?>