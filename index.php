<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
?>
<?php include "config.php"; ?>

<h2>Gestion des utilisateurs</h2>

<h3>Ajouter utilisateur</h3>

<form method="POST" action="add.php">
    <input type="text" name="name" placeholder="Nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Ajouter</button>
</form>

<hr>

<h3>Liste des utilisateurs</h3>

<?php
$result = $conn->query("SELECT * FROM users");

while($row = $result->fetch_assoc()) {
?>
    <p>
        <form method="POST" action="update.php" style="display:inline;">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="name" value="<?= $row['name'] ?>" required>
            <input type="email" name="email" value="<?= $row['email'] ?>" required>
            <button type="submit">Modifier</button>
        </form>

        <a href="delete.php?id=<?= $row['id'] ?>">Supprimer</a>
    </p>
<?php } ?>
