<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if (isset($_GET['token'])) {
        $token = $_GET['token'];

        // Database connection (replace with your actual credentials)
        try {
            $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        // Check if token is valid and not expired
        $stmt = $db->prepare('SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()');
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];

                // Validate password
                if (strlen($newPassword) < 8) {
                    $error = 'Le mot de passe doit contenir au moins 8 caractères.';
                } elseif ($newPassword !== $confirmPassword) {
                    $error = 'Les mots de passe ne correspondent pas.';
                } else {
                    // Hash password and update
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $db->prepare('UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?');
                    $stmt->execute([$hashedPassword, $user['id']]);

                    $success = 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.';
                }
            }
        } else {
            $error = 'Le lien de réinitialisation est invalide ou a expiré.';
        }
    } else {
        $error = 'Lien de réinitialisation invalide.';
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Réinitialiser le mot de passe</title>
</head>
<body>
    <div class="container">
        <h1>Réinitialiser le mot de passe</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
            <a href="login.php" class="btn-suivant">Se connecter</a>
        <?php elseif (!isset($error) || (isset($error) && $error !== 'Lien de réinitialisation invalide.' && $error !== 'Le lien de réinitialisation est invalide ou a expiré.')): ?>
            <form method="post">
                <input type="password" name="new_password" placeholder="Nouveau mot de passe" required minlength="8">
                <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required minlength="8">
                <button type="submit" class="btn-suivant">Réinitialiser le mot de passe</button>
            </form>
        <?php else: ?>
            <a href="login.php" class="btn-suivant">Retour à la connexion</a>
        <?php endif; ?>
    </div>
</body>
</html>
