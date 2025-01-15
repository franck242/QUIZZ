<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    // Database connection (replace with your actual credentials)
    try {
        $db = new PDO('mysql:host=localhost;dbname=qcm_simple;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    // Check if user is admin
    $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

    // Handle admin actions
    if ($isAdmin && isset($_GET['action'])) {
        if ($_GET['action'] == 'add_question') {
            header('Location: add_question.php');
            exit;
        }
    }

    // Handle logout
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        session_destroy();
        header('Location: login.php');
        exit;
    }

    // Fetch questions from the database based on the selected level
    $level = isset($_GET['level']) ? $_GET['level'] : 'facile';
    
    // Reset question index and score when changing level or when explicitly requested
    if (isset($_GET['level']) || isset($_GET['new_questions'])) {
        $_SESSION['question_index'] = 0;
        $_SESSION['user_answers'] = [];
        $_SESSION['score'] = 0;
    }
    $_SESSION['current_level'] = $level;

    // Sélectionner aléatoirement 10 questions pour le niveau choisi
    $stmt = $db->prepare('SELECT id_question, question_text, correct_answer, answer1, answer2, answer3 
                         FROM questions 
                         WHERE quiz_name = "Culture Générale" AND difficulty = ? 
                         ORDER BY RAND() 
                         LIMIT 10');
    $stmt->execute([$level]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize session variables on the first visit
    if (!isset($_SESSION['score'])) {
        $_SESSION['score'] = 0;
        $_SESSION['question_index'] = 0;
        $_SESSION['user_answers'] = [];
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Store user's answer
        $_SESSION['user_answers'][$_SESSION['question_index']] = $_POST['answer'];

        // Check if the answer is correct
        $correctAnswer = $questions[$_SESSION['question_index']]['correct_answer'];

        if ($_POST['answer'] === $correctAnswer) {
            $_SESSION['score']++;
        }

        // Move to the next question or show results
        if ($_SESSION['question_index'] < count($questions) - 1) {
            $_SESSION['question_index']++;
        } else {
            // Display results
            echo '<!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="style.css">
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
                <title>Résultats du QCM</title>
            </head>
            <body>
                <div class="container">
                    <h1>Résultat</h1>
                    <div class="score">Vous avez obtenu ' . $_SESSION['score'] . ' sur ' . count($questions) . ' questions correctes !</div>
                    <a href="index.php" class="btn-suivant">Recommencer</a>
                </div>
            </body>
            </html>';

            // Reset session variables
            unset($_SESSION['score']);
            unset($_SESSION['question_index']);
            unset($_SESSION['user_answers']);
            exit;
        }
    }

    // Get the current question
    if ($_SESSION['question_index'] < count($questions)) {
      $currentQuestion = $questions[$_SESSION['question_index']];
    } else {
      exit;
    }

    // Fetch answers for the current question
    $answers = [
        ['answer' => $currentQuestion['correct_answer']],
        ['answer' => $currentQuestion['answer1']],
        ['answer' => $currentQuestion['answer2']],
        ['answer' => $currentQuestion['answer3']],
    ];

    // Shuffle answers randomly
    shuffle($answers);
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <title>Application QCM</title>
    </head>
    <body>
        <div class="container">
            <h1>Question <?php echo $_SESSION['question_index'] + 1; ?>/10</h1>
            <div class="question"><?php echo $currentQuestion['question_text']; ?></div>
            <form method="post" class="reponses">
                <?php foreach ($answers as $answer): ?>
                    <button type="submit" name="answer" value="<?php echo $answer['answer']; ?>" class="reponse">
                        <?php echo $answer['answer']; ?>
                    </button>
                <?php endforeach; ?>
            </form>
            <?php if ($isAdmin): ?>
              <a href="index.php?action=add_question" class="btn-suivant">Ajouter une question</a>
            <?php endif; ?>
            <div class="level-select">
                <a href="index.php?level=facile&new_questions=1" class="btn-suivant">Niveau Facile</a>
                <a href="index.php?level=moyen&new_questions=1" class="btn-suivant">Niveau Moyen</a>
                <a href="index.php?level=difficile&new_questions=1" class="btn-suivant">Niveau Difficile</a>
            </div>
            <a href="index.php?action=logout" class="btn-suivant">Déconnexion</a>
        </div>
    </body>
    </html>
