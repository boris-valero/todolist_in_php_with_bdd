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
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .logout-button input {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-task-form {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .task-input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
            width: 300px;
        }
        .add-task-button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-task-button:hover {
            background-color: #0056b3;
        }
        .task-list {
            list-style-type: none;
            padding: 0;
        }
        .task-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .delete-form, .edit-form {
            margin: 0 10px;
        }
        .delete-button, .edit-button, .edit-submit {
            padding: 5px 10px;
            font-size: 14px;
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button {
            background-color: #ffc107;
        }
        .edit-submit {
            background-color: #28a745;
        }
        .edit-input {
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
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