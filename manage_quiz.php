<?php
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
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

    // Récupérer les questions de la difficulté sélectionnée
    $stmt = $db->prepare('SELECT * FROM questions WHERE difficulty = ? ORDER BY id_question');
    $stmt->execute([$difficulty]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Traitement de l'ajout d'une question
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'add' && isset($_POST['question_text'])) {
            $stmt = $db->prepare('INSERT INTO questions (quiz_name, question_text, difficulty, correct_answer, answer1, answer2, answer3) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $_POST['quiz_name'],
                $_POST['question_text'],
                $difficulty,
                $_POST['correct_answer'],
                $_POST['answer1'],
                $_POST['answer2'],
                $_POST['answer3']
            ]);
            header("Location: manage_quiz.php?difficulty=$difficulty&success=1");
            exit;
        } elseif ($_POST['action'] === 'delete' && isset($_POST['question_id'])) {
            $stmt = $db->prepare('DELETE FROM questions WHERE id_question = ? AND difficulty = ?');
            $stmt->execute([$_POST['question_id'], $difficulty]);
            header("Location: manage_quiz.php?difficulty=$difficulty&success=2");
            exit;
        }
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
    <title>QUIZZGAME - Gestion des Quiz</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="logo">QUIZZGAME</h1>
        
        <div class="admin-section">
            <h2>Gestion des Questions <?php echo ucfirst($difficulty); ?>s</h2>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">
                    <?php echo $_GET['success'] == 1 ? 'Question ajoutée avec succès!' : 'Question supprimée avec succès!'; ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire d'ajout de question -->
            <div class="add-question-form">
                <h3>Ajouter une question</h3>
                <form method="post" action="">
                    <input type="hidden" name="action" value="add">
                    
                    <input type="text" name="quiz_name" placeholder="Nom du quiz" required>
                    <textarea name="question_text" placeholder="Texte de la question" required></textarea>
                    <input type="text" name="correct_answer" placeholder="Réponse correcte" required>
                    <input type="text" name="answer1" placeholder="Mauvaise réponse 1" required>
                    <input type="text" name="answer2" placeholder="Mauvaise réponse 2" required>
                    <input type="text" name="answer3" placeholder="Mauvaise réponse 3" required>
                    
                    <button type="submit" class="btn-suivant">Ajouter la question</button>
                </form>
            </div>

            <!-- Liste des questions existantes -->
            <div class="questions-list">
                <h3>Questions existantes</h3>
                <?php foreach ($questions as $question): ?>
                    <div class="question-item">
                        <p><strong>Question:</strong> <?php echo htmlspecialchars($question['question_text']); ?></p>
                        <p><strong>Réponse correcte:</strong> <?php echo htmlspecialchars($question['correct_answer']); ?></p>
                        <p><strong>Autres réponses:</strong></p>
                        <ul>
                            <li><?php echo htmlspecialchars($question['answer1']); ?></li>
                            <li><?php echo htmlspecialchars($question['answer2']); ?></li>
                            <li><?php echo htmlspecialchars($question['answer3']); ?></li>
                        </ul>
                        <form method="post" action="" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="question_id" value="<?php echo $question['id_question']; ?>">
                            <button type="submit" class="btn-suivant" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">Supprimer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="dashboard.php" class="btn-suivant">Retour au tableau de bord</a>
        </div>
    </div>
</body>
</html>
