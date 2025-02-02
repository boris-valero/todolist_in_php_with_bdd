<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'todo_list_backend.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste de Tâches</title>
    <style>
        .logout-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Le contenu HTML généré par todo_list_backend.php sera inséré ici -->
    <form method="post" action="logout.php" class="logout-button">
        <input type="submit" value="Se déconnecter">
    </form>
    <script src="todo_list.js"></script>
</body>
</html>