<?php

require_once "../config/connexionDB.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

        $sql = "SELECT * FROM posts";
        $stmt = $db->prepare($sql);

    header('Content-Type: application/json');
    echo json_encode($response);
}
