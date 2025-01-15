<?php
    session_start();
    if (isset($_SESSION['score']) && isset($_SESSION['questions'])) {
      $score = $_SESSION['score'];
      $totalQuestions = count($_SESSION['questions']);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="style.css">
      <title>QCM Results</title>
    </head>
    <body>
      <div class="container">
        <h1>Your Score</h1>
        <p>You got <?php echo $score; ?> out of <?php echo $totalQuestions; ?> questions correct!</p>
      </div>
    </body>
    </html>
    <?php
      // Clear the session data
      unset($_SESSION['questions']);
      unset($_SESSION['current_question']);
      unset($_SESSION['score']);
      unset($_SESSION['user_answers']);
    } else {
      header("Location: index.php");
      exit;
    }
    ?>
