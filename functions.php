<?php
    require_once 'config.php';

    function getQuestions($pdo) {
      $stmt = $pdo->query("SELECT * FROM questions");
      $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($questions as &$question) {
        $stmt = $pdo->prepare("SELECT * FROM answers WHERE question_id = ?");
        $stmt->execute([$question['id']]);
        $question['answers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      return $questions;
    }

    function calculateScore($pdo, $userAnswers) {
      $score = 0;
      foreach ($userAnswers as $questionId => $answerId) {
        $stmt = $pdo->prepare("SELECT is_correct FROM answers WHERE id = ?");
        $stmt->execute([$answerId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['is_correct']) {
          $score++;
        }
      }
      return $score;
    }
    ?>
