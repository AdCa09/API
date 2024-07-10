<?php

function createPost()
{
    global $db;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['title']) && isset($data['body']) && isset($data['author'])) {

            // Nous pourrions utiliser filter_var(), FILTER_SANITIZE_STRING mais la communauté php à décidé qu'il ne devais plus être pris en charge, source  : https://stackoverflow.com/questions/69207368/constant-filter-sanitize-string-is-deprecated
            $title = htmlspecialchars($data['title']); 
            $body = htmlspecialchars($data['body']);
            $author = htmlspecialchars($data['author']);

            if ($title && $body && $author) {
                $created_at = date('Y-m-d H:i:s');
                $updated_at = date('Y-m-d H:i:s');

                $stmt = $db->prepare("INSERT INTO posts (title, body, author, created_at, updated_at) VALUES (:title, :body, :author, :created_at, :updated_at)");

                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':body', $body);
                $stmt->bindParam(':author', $author);
                $stmt->bindParam(':created_at', $created_at);
                $stmt->bindParam(':updated_at', $updated_at);

                if ($stmt->execute()) {
                    $response = [
                        "status" => 200,
                        "message" => "Post créé avec succès",
                        "data" => [
                            "title" => $title,
                            "body" => $body,
                            "author" => $author
                        ]
                    ];
                    header("Content-Type: application/json");
                    echo json_encode($response);
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Erreur lors de la création du post"));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Données invalides après validation."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Données incomplètes. Veuillez fournir title, body et author."));
        }
    }
}

createPost();
