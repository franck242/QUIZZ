<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations de l'utilisateur
    $stmt = $db->prepare('SELECT email, is_admin FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Extraire le nom d'utilisateur de l'email (partie avant le @)
    $username = explode('@', $user['email'])[0];

    if ($user['is_admin']) {
        // Pour l'admin, récupérer les questions par difficulté
        $stmt = $db->prepare('SELECT difficulty, COUNT(*) as count FROM questions GROUP BY difficulty');
        $stmt->execute();
        $questionStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZZGAME - Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="logo">QUIZZGAME</h1>
        
        <div class="welcome-message">
            <?php if ($user['is_admin']): ?>
                <h2>Hey <?php echo htmlspecialchars(ucfirst($username)); ?> ! Prêt à gérer les défis du jour ?</h2>
            <?php else: ?>
                <h2>En route <?php echo htmlspecialchars(ucfirst($username)); ?> ! Prêt à relever de nouveaux défis ?</h2>
                <p class="motivation-text">Choisis ton niveau et montre-nous tes talents !</p>
            <?php endif; ?>
        </div>

        <?php if ($user['is_admin']): ?>
        <!-- Interface Admin -->
        <div class="admin-panel">
            <h3>Gestion des Quiz</h3>
            <div class="quiz-management">
                <div class="difficulty-section">
                    <h4>Questions Faciles</h4>
                    <p>Nombre de questions : <?php echo array_filter($questionStats, function($q) { return $q['difficulty'] === 'facile'; })[0]['count'] ?? 0; ?></p>
                    <a href="manage_quiz.php?difficulty=facile" class="btn-suivant">Gérer</a>
                </div>
                <div class="difficulty-section">
                    <h4>Questions Moyennes</h4>
                    <p>Nombre de questions : <?php echo array_filter($questionStats, function($q) { return $q['difficulty'] === 'moyen'; })[0]['count'] ?? 0; ?></p>
                    <a href="manage_quiz.php?difficulty=moyen" class="btn-suivant">Gérer</a>
                </div>
                <div class="difficulty-section">
                    <h4>Questions Difficiles</h4>
                    <p>Nombre de questions : <?php echo array_filter($questionStats, function($q) { return $q['difficulty'] === 'difficile'; })[0]['count'] ?? 0; ?></p>
                    <a href="manage_quiz.php?difficulty=difficile" class="btn-suivant">Gérer</a>
                </div>
            </div>
            <a href="player_stats.php" class="btn-suivant">Informations joueurs</a>
        </div>
        <?php else: ?>
        <!-- Interface Utilisateur -->
        <div class="difficulty-buttons">
            <a href="quiz.php?difficulty=facile" class="btn-suivant">Niveau Facile</a>
            <a href="quiz.php?difficulty=moyen" class="btn-suivant">Niveau Moyen</a>
            <a href="quiz.php?difficulty=difficile" class="btn-suivant">Niveau Difficile</a>
        </div>

        <a href="profile.php" class="btn-suivant">Voir mon profil</a>
        <?php endif; ?>

        <a href="logout.php" class="btn-suivant">Se déconnecter</a>
    </div>
</body>
</html>
