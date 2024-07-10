<?php


function getController() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        
        try {
            $stmt = $db->prepare("SELECT * FROM posts");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = [
                "status" => 200,
                "message" => "OK",
                "data" => $results
            ];

            header("Content-Type: application/json");

            echo json_encode($response);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        }
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
    }
}

getController();
