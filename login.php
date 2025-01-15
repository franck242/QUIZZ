<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        $stmt = $db->prepare('SELECT id, is_admin, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe avec support des deux formats
        $passwordValid = false;
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $passwordValid = true;
            } elseif ($user['password'] === $password) { // Pour les anciens mots de passe non hashés
                // Mettre à jour le mot de passe en version hashée
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
                $updateStmt->execute([$hashedPassword, $user['id']]);
                $passwordValid = true;
            }
        }

        if ($passwordValid) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Email ou mot de passe incorrect.';
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">
    <title>QUIZZGAME - Connexion</title>
</head>
<body class="login-page">
    <div class="container">
        <h1 class="logo">QUIZZGAME</h1>
        
        <div class="intro-section">
            <h2>Bienvenue dans l'univers du savoir !</h2>
            <p class="intro-text">
                Découvrez QUIZZGAME, votre nouvelle plateforme de quiz de culture générale interactive et captivante.
                Testez vos connaissances, défiez-vous à travers différents niveaux de difficulté et suivez votre progression !
            </p>
            <div class="features">
                <div class="feature-item">
                    <h3> 3 Niveaux de difficulté</h3>
                    <p>Du débutant à l'expert, trouvez le défi qui vous correspond</p>
                </div>
                <div class="feature-item">
                    <h3> Suivi de progression</h3>
                    <p>Visualisez vos scores et votre évolution</p>
                </div>
                <div class="feature-item">
                    <h3> Classement dynamique</h3>
                    <p>Comparez vos performances avec les autres joueurs</p>
                </div>
            </div>
        </div>

        <div class="form-container">
            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="post" autocomplete="off">
                <!-- Champs cachés pour tromper l'autocomplétion -->
                <div style="display:none">
                    <input type="text" name="fakeusernameremembered">
                    <input type="password" name="fakepasswordremembered">
                </div>
                
                <input type="email" 
                       name="email" 
                       placeholder="Email" 
                       required 
                       autocomplete="off"
                       readonly
                       onfocus="this.removeAttribute('readonly');">
                       
                <input type="password" 
                       name="password" 
                       placeholder="Mot de passe" 
                       required 
                       autocomplete="off"
                       readonly
                       onfocus="this.removeAttribute('readonly');">
                       
                <button type="submit" class="btn-suivant">Se connecter</button>
            </form>
            <p>Pas de compte ? <a href="register.php">S'inscrire</a></p>
            <p><a href="forgot_password.php">Mot de passe oublié ?</a></p>
        </div>
    </div>
</body>
</html>
