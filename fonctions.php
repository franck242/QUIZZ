<?php
    require_once 'config.php';

    function obtenirQuestions($pdo) {
      $stmt = $pdo->query("SELECT * FROM questions");
      $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($questions as &$question) {
        $stmt = $pdo->prepare("SELECT * FROM reponses WHERE question_id = ?");
        $stmt->execute([$question['id']]);
        $question['reponses'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      return $questions;
    }

    function calculerScore($pdo, $reponsesUtilisateur) {
      $score = 0;
      foreach ($reponsesUtilisateur as $questionId => $reponseId) {
        $stmt = $pdo->prepare("SELECT est_correcte FROM reponses WHERE id = ?");
        $stmt->execute([$reponseId]);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultat && $resultat['est_correcte']) {
          $score++;
        }
      }
      return $score;
    }
    ?>
