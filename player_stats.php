<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si l'utilisateur est admin
    $stmt = $db->prepare('SELECT is_admin FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user['is_admin']) {
        header('Location: dashboard.php');
        exit;
    }

    // Récupérer les meilleurs scores par niveau de difficulté
    $difficulties = ['facile', 'moyen', 'difficile'];
    $rankings = [];

    foreach ($difficulties as $difficulty) {
        $stmt = $db->prepare('
            SELECT 
                u.email,
                MAX(gh.score) as best_score,
                COUNT(gh.id) as games_played,
                AVG(gh.score) as avg_score
            FROM users u
            JOIN game_history gh ON u.id = gh.user_id
            WHERE gh.difficulty = ? AND u.is_admin = 0
            GROUP BY u.id, u.email
            ORDER BY best_score DESC, avg_score DESC
            LIMIT 10
        ');
        $stmt->execute([$difficulty]);
        $rankings[$difficulty] = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>QUIZZGAME - Statistiques des joueurs</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="logo">QUIZZGAME</h1>
        
        <div class="admin-stats-container">
            <h2>Statistiques des joueurs</h2>

            <?php foreach ($difficulties as $difficulty): ?>
                <div class="difficulty-stats">
                    <h3>Classement - Niveau <?php echo ucfirst($difficulty); ?></h3>
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Joueur</th>
                                <th>Meilleur score</th>
                                <th>Score moyen</th>
                                <th>Parties jouées</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rankings[$difficulty] as $index => $player): ?>
                                <tr>
                                    <td>#<?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($player['email']); ?></td>
                                    <td><?php echo htmlspecialchars($player['best_score']); ?></td>
                                    <td><?php echo round(htmlspecialchars($player['avg_score']), 1); ?></td>
                                    <td><?php echo htmlspecialchars($player['games_played']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($rankings[$difficulty])): ?>
                                <tr>
                                    <td colspan="5" class="no-data">Aucune donnée disponible pour ce niveau</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>

            <a href="dashboard.php" class="btn-suivant">Retour au tableau de bord</a>
        </div>
    </div>
</body>
</html>
