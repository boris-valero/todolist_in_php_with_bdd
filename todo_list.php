<?php
//Le script se connecte à la base de données MySQL en utilisant les informations d'identification fournies
$user = "boris";
$password = "Loveonthebe@t";
$database = "todolist_base";
$table = "todo_list";
try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
    
// Si le formulaire est soumis (méthode POST) et que le champ new_task est défini, le script récupère la valeur de new_task.Une déclaration préparée ($stmt) est utilisée pour insérer la nouvelle tâche dans la table todo_list.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task'])) {
        $new_task = $_POST['new_task'];
        $stmt = $db->prepare("INSERT INTO $table (content) VALUES (:content)");
        $stmt->bindParam(':content', $new_task);
        $stmt->execute();
    }
//Le script récupère toutes les tâches de la table todo_list et les affiche dans une liste ordonnée.
    echo "<h2>TODO</h2><ol>"; 
    foreach ($db->query("SELECT content FROM $table") as $row) {
        echo "<li>" . $row['content'] . "</li>";
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
