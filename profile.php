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
    $stmt = $db->prepare('SELECT email FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer les statistiques par niveau de difficulté
    $stmt = $db->prepare('
        SELECT 
            difficulty,
            COUNT(*) as games_played,
            AVG(score) as average_score,
            MAX(score) as best_score
        FROM game_history 
        WHERE user_id = ?
        GROUP BY difficulty
    ');
    $stmt->execute([$_SESSION['user_id']]);
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer l'historique complet
    $stmt = $db->prepare('
        SELECT difficulty, score, DATE_FORMAT(played_at, "%d/%m/%Y %H:%i") as played_at
        FROM game_history 
        WHERE user_id = ? 
        ORDER BY played_at DESC
    ');
    $stmt->execute([$_SESSION['user_id']]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZZGAME - Profil</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="logo">QUIZZGAME</h1>
        
        <div class="profile-container">
            <h2>Profil de <?php echo htmlspecialchars($user['email']); ?></h2>

            <div class="stats-grid">
                <?php foreach (['facile', 'moyen', 'difficile'] as $difficulty): ?>
                    <?php
                    $diffStats = array_filter($stats, function($s) use ($difficulty) {
                        return $s['difficulty'] === $difficulty;
                    });
                    $diffStats = !empty($diffStats) ? reset($diffStats) : null;
                    ?>
                    <div class="stat-card">
                        <h3>Niveau <?php echo ucfirst($difficulty); ?></h3>
                        <p>Parties jouées : <?php echo $diffStats ? $diffStats['games_played'] : 0; ?></p>
                        <p>Score moyen : <?php echo $diffStats ? round($diffStats['average_score'], 1) : 0; ?></p>
                        <p>Meilleur score : <?php echo $diffStats ? $diffStats['best_score'] : 0; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="history-section">
                <h3>Historique des parties</h3>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Difficulté</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $game): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($game['played_at']); ?></td>
                            <td><?php echo htmlspecialchars($game['difficulty']); ?></td>
                            <td><?php echo htmlspecialchars($game['score']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <a href="dashboard.php" class="btn-suivant">Retour au tableau de bord</a>
        </div>
    </div>
</body>
</html>
