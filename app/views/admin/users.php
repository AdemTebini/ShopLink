<h2>Gestion des utilisateurs 👥</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($u = $users->fetch_assoc()) { ?>
        <tr>
            <td><?= $u['id']; ?></td>
            <td><?= $u['nom']; ?></td>
            <td><?= $u['email']; ?></td>
            <!-- ROLE -->
            <td>
                <form method="POST" action="/ShopLink/app/controllers/UserController.php">
                    <input type="hidden" name="user_id" value="<?= $u['id']; ?>">
                    <select name="role">
                        <option value="client"
                            <?= $u['role'] == 'client' ? 'selected' : '' ?>>
                            client
                        </option>
                        <option value="vendeur"
                            <?= $u['role'] == 'vendeur' ? 'selected' : '' ?>>
                            vendeur
                        </option>
                        <option value="livreur"
                            <?= $u['role'] == 'livreur' ? 'selected' : '' ?>>
                            livreur
                        </option>
                        <option value="admin"
                            <?= $u['role'] == 'admin' ? 'selected' : '' ?>>
                            admin
                        </option>
                    </select>
                    <button type="submit" name="update_role">
                        Modifier
                    </button>
                </form>
            </td>
            <!-- STATUS -->
            <td>
                <?= $u['status']; ?>
            </td>
            <!-- ACTIONS -->
            <td>
                <?php if ($u['status'] == 'pending'): ?>
                    <a href="/ShopLink/app/controllers/AdminController.php?approve=<?= $u['id']; ?>">
                        Approve ✅
                    </a>
                    |
                    <a href="/ShopLink/app/controllers/AdminController.php?reject=<?= $u['id']; ?>">
                        Reject ❌
                    </a>
                    <br><br>
                <?php endif; ?>
                <a href="/ShopLink/app/controllers/UserController.php?delete=<?= $u['id']; ?>">
                    Supprimer 🗑️
                </a>
            </td>
        </tr>
    <?php } ?>
</table>ß