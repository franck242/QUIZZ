<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $security_question = $_POST['security_question'];
        $security_answer = $_POST['security_answer'];

        // Validation des champs
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
        if (empty($security_question)) {
            $errors[] = "La question personnelle est requise.";
        }
        if (empty($security_answer)) {
            $errors[] = "La réponse à la question est requise.";
        }

        if (empty($errors)) {
            // Database connection
            try {
                $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }

            // Check if email already exists
            $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $errors[] = 'Cet email est déjà utilisé.';
            } else {
                // Hash password and security answer
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $hashed_answer = password_hash(strtolower($security_answer), PASSWORD_DEFAULT);

                // Insert new user
                $stmt = $db->prepare('INSERT INTO users (email, password, security_question, security_answer) VALUES (?, ?, ?, ?)');
                $stmt->execute([$email, $hashed_password, $security_question, $hashed_answer]);

                header('Location: login.php');
                exit;
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
    <title>Inscription</title>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <input type="password" name="password" placeholder="Mot de passe (minimum 8 caractères)" required minlength="8">
            <input type="text" name="security_question" placeholder="Votre question personnelle (ex: Quel est le nom de mon premier animal ?)" required value="<?php echo isset($_POST['security_question']) ? htmlspecialchars($_POST['security_question']) : ''; ?>">
            <input type="text" name="security_answer" placeholder="Votre réponse" required>
            <button type="submit" class="btn-suivant">S'inscrire</button>
        </form>
        <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>
</body>
</html>
