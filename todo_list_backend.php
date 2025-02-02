<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'vendor/autoload.php'; // Assurez-vous que le chemin est correct
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$database = $_ENV['DB_NAME'];
$table = "todo_list";
try {
    $db = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=$database", $user, $password);

    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task'])) {
        $new_task = $_POST['new_task'];
        $stmt = $db->prepare("INSERT INTO $table (content, user_id) VALUES (:content, :user_id)");
        $stmt->bindParam(':content', $new_task);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
        $delete_task = $_POST['delete_task'];
        $stmt = $db->prepare("DELETE FROM $table WHERE content = :content AND user_id = :user_id");
        $stmt->bindParam(':content', $delete_task);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_task']) && isset($_POST['new_content'])) {
        $edit_task = $_POST['edit_task'];
        $new_content = $_POST['new_content'];
        $stmt = $db->prepare("UPDATE $table SET content = :new_content WHERE content = :content AND user_id = :user_id");
        $stmt->bindParam(':new_content', $new_content);
        $stmt->bindParam(':content', $edit_task);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    echo "<h2>TODO</h2><ol>";
    $stmt = $db->prepare("SELECT content FROM $table WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    foreach ($stmt as $row) {
        $task = htmlspecialchars($row['content']);
        echo "<li>" . $task . "
            <form method='post' action='' style='display:inline;'>
                <input type='hidden' name='delete_task' value='" . $task . "'>
                <input type='submit' value='Supprimer'>
            </form>
            <button onclick='showEditForm(\"" . $task . "\")'>Modifier</button>
            <form id='edit-form-" . $task . "' method='post' action='' style='display:none;'>
                <input type='hidden' name='edit_task' value='" . $task . "'>
                <input type='text' name='new_content' placeholder='Modifier la tâche'>
                <input type='submit' value='OK'>
            </form>
        </li>";
    }
    echo "</ol>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
<form method="post" action="">
    <input type="text" name="new_task" placeholder="Entrez une nouvelle tâche">
    <input type="submit" value="Ajouter">
</form>