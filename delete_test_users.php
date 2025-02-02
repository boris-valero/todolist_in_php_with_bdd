<?php

require 'vendor/autoload.php'; // Assurez-vous que le chemin est correct
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$database = $_ENV['DB_NAME'];

try {
    $db = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=$database", $user, $password);

    // Suppression des utilisateurs de test
    $testEmails = ['test1@example.com', 'test2@example.com', 'test3@example.com'];
    $stmt = $db->prepare("DELETE FROM users WHERE email = :email");

    foreach ($testEmails as $email) {
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    echo "Les utilisateurs de test ont été supprimés avec succès\n";
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
}
