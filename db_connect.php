<?php
// db_connect.php - connexion à la base de données

$host = 'localhost';
$dbname = 'gestion_etudiants';
$username = 'root';
$password = ''; // mot de passe vide par défaut sur laragon

try {
    // connexion via pdo 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // configurer le mode d'erreur  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // en cas d'erreur 
    die("erreur de connexion : " . $e->getMessage());
}
?>