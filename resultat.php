<?php
    session_start();
    if (isset($_SESSION['score']) && isset($_SESSION['questions'])) {
      $score = $_SESSION['score'];
      $totalQuestions = count($_SESSION['questions']);
    ?>
    <!DOCTYPE html>
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
        <div class="score">Vous avez obtenu <?php echo $score; ?> sur <?php echo $totalQuestions; ?> questions correctes !</div>
        <a href="index.php" class="btn-suivant">Recommencer</a>
      </div>
    </body>
    </html>
    <?php
      // Clear the session data
      unset($_SESSION['questions']);
      unset($_SESSION['question_courante']);
      unset($_SESSION['score']);
      unset($_SESSION['reponses_utilisateur']);
    } else {
      header("Location: index.php");
      exit;
    }
    ?>
