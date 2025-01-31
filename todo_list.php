<?php
//Le script se connecte à la base de données MySQL en utilisant les informations d'identification fournies
$user = "boris";
$password = "Jvale2lpp";
$database = "todolist_base";
$table = "todo_list";
try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
    
// Si le formulaire est soumis (méthode POST) et que le champ new_task est défini
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_task'])) {
//Le script récupère la valeur de new_task
        $new_task = $_POST['new_task'];
//Une déclaration préparée ($stmt) est utilisée pour insérer la nouvelle tâche dans la table todo_list = requête SQL pour insérer une nouvelle tâche dans la table
        $stmt = $db->prepare("INSERT INTO $table (content) VALUES (:content)");
        $stmt->bindParam(':content', $new_task);
        $stmt->execute();
    }
    
// Si le formulaire est soumis (méthode POST) et que le champ delete_task est défini
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
//Le script récupère la tâche à supprimer
        $delete_task = $_POST['delete_task'];
//Une déclaration préparée ($stmt) est utilisée pour suprrimer la tâche dans la table todo_list = requête SQL pour supprimer la tâche de la table
        $stmt = $db->prepare("DELETE FROM $table WHERE content = :content");
        $stmt->bindParam(':content', $delete_task); // Liaison de la valeur de la tâche à supprimer au paramètre :content
        $stmt->execute(); // Exécution de la requête préparée
    }
//Le script récupère toutes les tâches de la table todo_list et les affiche dans une liste ordonnée.
    echo "<h2>TODO</h2><ol>"; 
    foreach ($db->query("SELECT content FROM $table") as $row) { // Exécution de la requête SQL pour récupérer toutes les tâches
        echo "<li>" . $row['content'] . "
                    <form method='post' action='' style='display:inline;'>
					<input type='hidden' name='delete_task' value='" . $row['content'] . "'>
					<input type='submit' value='Supprimer'>
					</form>     
        </li>"; // Affichage de chaque tâche avec un bouton de suppression
    }
    echo "</ol>"; // Fermeture de la liste ordonnée
} catch (PDOException $e) {
// Gestion des erreurs de connexion à la base de données
    print "Error!: " . $e->getMessage() . "<br/>";
    die(); // Arrêt du script en cas d'erreur
}
?>
<form method="post" action="">
    <input type="text" name="new_task" placeholder="Entrez une nouvelle tâche">
    <input type="submit" value="Ajouter">
</form>
