<!DOCTYPE html>
<html>
<head>
    <title>SUP2I Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h1 class="sup2i">SUP2I</h1>
    <h2>Connexion</h2>

    <form action="auth.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>
