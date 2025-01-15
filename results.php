<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['score'])) {
    header('Location: dashboard.php');
    exit;
}

$score = $_SESSION['score'];
$total_questions = count($_SESSION['questions']);
$percentage = ($score / $total_questions) * 100;

// Nettoyer les variables de session du quiz
unset($_SESSION['questions']);
unset($_SESSION['current_question']);
unset($_SESSION['score']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZZGAME - Résultats</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="logo">QUIZZGAME</h1>
        
        <div class="results-container">
            <h2>Résultats</h2>
            <div class="score-display">
                <p>Votre score : <?php echo $score; ?> / <?php echo $total_questions; ?></p>
                <p>Pourcentage de réussite : <?php echo round($percentage); ?>%</p>
            </div>
            
            <?php if ($percentage >= 80): ?>
                <p class="success-message">Excellent ! Vous maîtrisez le sujet !</p>
            <?php elseif ($percentage >= 60): ?>
                <p class="success-message">Bien joué ! Continuez comme ça !</p>
            <?php else: ?>
                <p class="error-message">Continuez à vous entraîner pour vous améliorer !</p>
            <?php endif; ?>
            
            <div class="button-group">
                <a href="dashboard.php" class="btn-suivant">Retour au tableau de bord</a>
                <a href="profile.php" class="btn-suivant">Voir mon profil</a>
            </div>
        </div>
    </div>
</body>
</html>
