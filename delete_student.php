<?php

require_once 'db_connect.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {

        $sql = "DELETE FROM students WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        // Exécuter la requête
        $stmt->execute([':id' => $id]);

        header("Location: index.php?msg=deleted");
        exit();

    } catch (PDOException $e) {
        // Gestion des erreurs en cas de problème technique
        echo "Erreur lors de la suppression : " . htmlspecialchars($e->getMessage());
    }
} else {

    header("Location: index.php");
    exit();
}
