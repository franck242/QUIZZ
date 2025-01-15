<?php
    // Configuration de la base de données
    $host = 'localhost'; // Hôte de la base de données
    $dbName = 'questionnaire_choix_multiple'; // Nom de la base de données
    $user = 'root'; // Nom d'utilisateur de la base de données
    $password = ''; // Mot de passe de la base de données (vide par défaut dans WAMP)

    try {
      $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $user, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
    ?>
