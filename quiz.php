<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$difficulty = $_GET['difficulty'] ?? '';
if (!in_array($difficulty, ['facile', 'moyen', 'difficile'])) {
    header('Location: dashboard.php');
    exit;
}

try {
    $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer toutes les questions de la difficulté choisie
    $stmt = $db->prepare('SELECT * FROM questions WHERE difficulty = ? ORDER BY RAND() LIMIT 10');
    $stmt->execute([$difficulty]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Stocker les questions dans la session
$_SESSION['questions'] = $questions;
$_SESSION['current_question'] = 0;
$_SESSION['score'] = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZZGAME - Quiz <?php echo ucfirst($difficulty); ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="logo">QUIZZGAME</h1>
        
        <?php if (!empty($questions)): ?>
            <div class="quiz-container">
                <div class="question">
                    <h2><?php echo htmlspecialchars($questions[0]['question_text']); ?></h2>
                </div>

                <form action="check_answer.php" method="post" class="reponses">
                    <?php
                        $answers = [
                            $questions[0]['correct_answer'],
                            $questions[0]['answer1'],
                            $questions[0]['answer2'],
                            $questions[0]['answer3']
                        ];
                        shuffle($answers);
                        foreach ($answers as $answer):
                    ?>
                        <button type="submit" name="answer" value="<?php echo htmlspecialchars($answer); ?>" class="reponse">
                            <?php echo htmlspecialchars($answer); ?>
                        </button>
                    <?php endforeach; ?>
                </form>

                <div class="button-group">
                    <a href="dashboard.php" class="btn-retour">Retour au tableau de bord</a>
                </div>
            </div>
        <?php else: ?>
            <div class="message">
                <p>Aucune question disponible pour ce niveau de difficulté.</p>
                <a href="dashboard.php" class="btn-retour">Retour au tableau de bord</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
