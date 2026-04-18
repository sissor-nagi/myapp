<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        .student {
            display: flex;
            justify-content: space-between;
            background: #f9f9f9;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .delete {
            color: red;
            text-decoration: none;
        }

        .delete:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Ajouter un étudiant</h2>

    <form method="POST" action="add.php">
        <input type="text" name="name" placeholder="Nom de l'étudiant" required>
        <input type="email" name="email" placeholder="Email de l'étudiant" required>
        <button type="submit">Ajouter étudiant</button>
    </form>

    <h2>Liste des étudiants</h2>

    <?php
    $result = $conn->query("SELECT * FROM users");

    while($row = $result->fetch_assoc()) {
        echo "<div class='student'>
                <span>".$row['name']." - ".$row['email']."</span>
                <a class='delete' href='delete.php?id=".$row['id']."'>Supprimer</a>
              </div>";
    }
    ?>

</div>

</body>
</html>
