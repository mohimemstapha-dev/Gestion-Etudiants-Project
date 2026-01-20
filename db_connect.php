<?php


$host = 'localhost';
$dbname = 'gestion_etudiants';
$username = 'root';
$password = ''; 

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
     
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    
    die("erreur de connexion : " . $e->getMessage());
}
?>