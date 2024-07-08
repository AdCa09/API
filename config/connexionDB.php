<?php

$host = 'mysql';
$dbname = 'api';
$username = 'root';
$password = 'root_password';


try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie";
    
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>

