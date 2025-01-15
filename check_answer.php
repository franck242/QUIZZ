<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['questions'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $current_question = $_SESSION['current_question'];
    $questions = $_SESSION['questions'];
    
    // Vérifier si la réponse est correcte
    if ($_POST['answer'] === $questions[$current_question]['correct_answer']) {
        $_SESSION['score']++;
    }
    
    // Passer à la question suivante
    $_SESSION['current_question']++;
    
    // Si toutes les questions ont été répondues
    if ($_SESSION['current_question'] >= count($questions)) {
        try {
            $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Enregistrer le score
            $stmt = $db->prepare('INSERT INTO game_history (user_id, difficulty, score) VALUES (?, ?, ?)');
            $stmt->execute([
                $_SESSION['user_id'],
                $questions[0]['difficulty'],
                $_SESSION['score']
            ]);
            
            // Rediriger vers la page de résultats
            header('Location: results.php');
            exit;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    } else {
        // Continuer avec la question suivante
        header('Location: quiz.php?difficulty=' . $questions[0]['difficulty']);
        exit;
    }
}

header('Location: dashboard.php');
exit;
