<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    // Database connection
    try {
        $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    $step = isset($_SESSION['reset_step']) ? $_SESSION['reset_step'] : 1;
    $email = isset($_SESSION['reset_email']) ? $_SESSION['reset_email'] : '';
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($step === 1 && isset($_POST['email'])) {
            $email = $_POST['email'];
            
            // Check if user exists and get security question
            $stmt = $db->prepare('SELECT id, security_question FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_user_id'] = $user['id'];
                $_SESSION['reset_step'] = 2;
                $security_question = $user['security_question'];
                $step = 2;
            } else {
                $errors[] = 'Email incorrect.';
            }
        } 
        elseif ($step === 2 && isset($_POST['security_answer'])) {
            // Verify security answer
            $stmt = $db->prepare('SELECT security_answer FROM users WHERE id = ? AND email = ?');
            $stmt->execute([$_SESSION['reset_user_id'], $_SESSION['reset_email']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify(strtolower($_POST['security_answer']), $user['security_answer'])) {
                $_SESSION['reset_step'] = 3;
                $step = 3;
            } else {
                $errors[] = 'Réponse incorrecte.';
                // Réinitialiser la session après 3 tentatives incorrectes
                if (!isset($_SESSION['answer_attempts'])) {
                    $_SESSION['answer_attempts'] = 1;
                } else {
                    $_SESSION['answer_attempts']++;
                    if ($_SESSION['answer_attempts'] >= 3) {
                        session_destroy();
                        header('Location: forgot_password.php');
                        exit;
                    }
                }
            }
        }
        elseif ($step === 3 && isset($_POST['new_password'])) {
            if (strlen($_POST['new_password']) < 8) {
                $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
            }
            elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
                $errors[] = 'Les mots de passe ne correspondent pas.';
            }
            else {
                // Update password
                $hashed_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ? AND email = ?');
                $stmt->execute([$hashed_password, $_SESSION['reset_user_id'], $_SESSION['reset_email']]);

                // Reset session variables
                session_destroy();
                session_start();
                $success = 'Votre mot de passe a été réinitialisé avec succès.';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Mot de passe oublié</title>
    <style>
        .security-question {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .note {
            font-size: 0.9em;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mot de passe oublié</h1>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
            <a href="login.php" class="btn-suivant">Retour à la connexion</a>
        <?php else: ?>
            <?php if ($step === 1): ?>
                <form method="post" autocomplete="off">
                    <input type="email" name="email" placeholder="Votre email" required>
                    <button type="submit" class="btn-suivant">Suivant</button>
                </form>
            <?php elseif ($step === 2): ?>
                <p>Pour vérifier votre identité, veuillez répondre à votre question personnelle :</p>
                <p class="security-question"><strong><?php echo htmlspecialchars($security_question); ?></strong></p>
                <form method="post" autocomplete="off">
                    <input type="text" name="security_answer" placeholder="Votre réponse" required autocomplete="off">
                    <button type="submit" class="btn-suivant">Vérifier</button>
                </form>
                <p class="note">Note : Après 3 tentatives incorrectes, vous devrez recommencer le processus.</p>
            <?php elseif ($step === 3): ?>
                <form method="post">
                    <input type="password" name="new_password" placeholder="Nouveau mot de passe (minimum 8 caractères)" required minlength="8">
                    <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required minlength="8">
                    <button type="submit" class="btn-suivant">Réinitialiser le mot de passe</button>
                </form>
            <?php endif; ?>
            <a href="login.php" class="btn-retour">Retour à la connexion</a>
        <?php endif; ?>
    </div>
</body>
</html>
