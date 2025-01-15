<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = '$hash' WHERE email = 'zaylen@gmx.fr' AND is_admin = 1;";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Générer Hash du Mot de Passe</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        input[type="password"] { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .result { margin-top: 20px; padding: 10px; background: #f0f0f0; }
        .sql { background: #e0e0e0; padding: 10px; margin-top: 10px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Générer un nouveau mot de passe admin</h2>
        <form method="post">
            <div class="form-group">
                <label>Entrez votre nouveau mot de passe :</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Générer le Hash</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="result">
            <h3>Requête SQL à exécuter :</h3>
            <div class="sql">
                <?php echo htmlspecialchars($sql); ?>
            </div>
            <p>Copiez cette requête et exécutez-la dans phpMyAdmin pour mettre à jour votre mot de passe.</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
