<?php
$user = "boris";
$password = "Jvale2lpp";
$database = "todolist_base";
$table = "todo_list";
try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task'])) {
        $new_task = $_POST['new_task'];
        $stmt = $db->prepare("INSERT INTO $table (content) VALUES (:content)");
        $stmt->bindParam(':content', $new_task);
        $stmt->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
        $delete_task = $_POST['delete_task'];
        $stmt = $db->prepare("DELETE FROM $table WHERE content = :content");
        $stmt->bindParam(':content', $delete_task);
        $stmt->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_task']) && isset($_POST['new_content'])) {
        $edit_task = $_POST['edit_task'];
        $new_content = $_POST['new_content'];
        $stmt = $db->prepare("UPDATE $table SET content = :new_content WHERE content = :content");
        $stmt->bindParam(':new_content', $new_content);
        $stmt->bindParam(':content', $edit_task);
        $stmt->execute();
    }

    echo "<h2>TODO</h2><ol>";
    foreach ($db->query("SELECT content FROM $table") as $row) {
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
