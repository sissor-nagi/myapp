<?php include "config.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>SUP2I - Gestion des Étudiants</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h1 class="sup2i">SUP2I</h1>
        <h2>Gestion des Étudiants</h2>
    </div>

    <!-- FORMULAIRE -->
    <div class="card">
        <h3>Ajouter un étudiant</h3>

        <form action="add.php" method="POST">
            <input type="text" name="name" placeholder="Nom étudiant" required>
            <input type="email" name="email" placeholder="Email étudiant" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <!-- LISTE -->
    <div class="card">
        <h3>Liste des étudiants</h3>

        <?php
        $result = $conn->query("SELECT * FROM students");

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='item'>
                    <span>{$row['name']} - {$row['email']}</span>
                    <a class='delete' href='delete.php?id={$row['id']}'>Supprimer</a>
                </div>";
            }
        } else {
            echo "<p>Aucun étudiant trouvé</p>";
        }
        ?>

    </div>

</div>

</body>
</html>
