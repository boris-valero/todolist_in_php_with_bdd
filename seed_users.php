<?php

require 'vendor/autoload.php'; // Assurez-vous que le chemin est correct
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$database = $_ENV['DB_NAME'];

try {
    $db = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=$database", $user, $password);

    // Création de la table users si elle n'existe pas
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )");

    // Insertion des utilisateurs de test
    $users = [
        ['email' => 'test1@example.com', 'password' => password_hash('password1', PASSWORD_DEFAULT)],
        ['email' => 'test2@example.com', 'password' => password_hash('password2', PASSWORD_DEFAULT)],
        ['email' => 'test3@example.com', 'password' => password_hash('password3', PASSWORD_DEFAULT)],
    ];

    $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");

    foreach ($users as $user) {
        $stmt->bindParam(':email', $user['email']);
        $stmt->bindParam(':password', $user['password']);
        $stmt->execute();
    }

    // Insertion des tâches de test pour chaque utilisateur
    $tasks = [
        ['content' => 'Tâche 1 de test1', 'user_id' => 1],
        ['content' => 'Tâche 2 de test1', 'user_id' => 1],
        ['content' => 'Tâche 1 de test2', 'user_id' => 2],
        ['content' => 'Tâche 2 de test2', 'user_id' => 2],
        ['content' => 'Tâche 1 de test3', 'user_id' => 3],
        ['content' => 'Tâche 2 de test3', 'user_id' => 3],
    ];

    $stmt = $db->prepare("INSERT INTO todo_list (content, user_id) VALUES (:content, :user_id)");

    foreach ($tasks as $task) {
        $stmt->bindParam(':content', $task['content']);
        $stmt->bindParam(':user_id', $task['user_id']);
        $stmt->execute();
    }

    echo "Les utilisateurs et les tâches de test ont été insérés avec succès.\n";
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
}
