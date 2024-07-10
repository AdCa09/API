<?php

function getAllById() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $response = [
                        "status" => 200,
                        "message" => "OK",
                        "data" => $result  
                    ];

                    header("Content-Type: application/json");

                    echo json_encode($response);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Post not found"]);
                }
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Missing ID parameter"]);
        }
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
    }
}

getAllById();
