<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    // Check if user is logged in and is admin
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        header('Location: login.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question = $_POST['question'];
        $correctAnswer = $_POST['correct_answer'];
        $niveau = $_POST['niveau'];

        // Database connection (replace with your actual credentials)
        try {
            $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        // Insert new question
        $stmt = $db->prepare('INSERT INTO questions (question_text, difficulty, quiz_name, correct_answer, answer1, answer2, answer3) VALUES (?, ?, "Culture Générale", ?, ?, ?, ?)');
        $stmt->execute([$question, $niveau, $correctAnswer, $_POST['answer1'], $_POST['answer2'], $_POST['answer3']]);

        header('Location: index.php');
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <title>Ajouter une question</title>
    </head>
    <body>
        <div class="container">
            <h1>Ajouter une question</h1>
            <form method="post">
                <input type="text" name="question" placeholder="Question" required>
                <input type="text" name="correct_answer" placeholder="Réponse correcte" required>
                <input type="text" name="answer1" placeholder="Réponse 1" required>
                <input type="text" name="answer2" placeholder="Réponse 2" required>
                <input type="text" name="answer3" placeholder="Réponse 3" required>
                <select name="niveau" required>
                  <option value="easy">Facile</option>
                  <option value="medium">Moyen</option>
                  <option value="hard">Difficile</option>
                </select>
                <button type="submit" class="btn-suivant">Ajouter</button>
            </form>
        </div>
    </body>
    </html>
