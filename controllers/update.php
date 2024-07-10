<?php

require_once 'config/connexionDB.php';

function update() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] === "PUT") {
        $id = $_GET['id'] ?? null;

        if ($id !== null) {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id === false) {
                http_response_code(400);
                echo json_encode(array("message" => "ID invalide"), JSON_UNESCAPED_UNICODE);
                return;
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['title']) && isset($data['body']) && isset($data['author'])) {
                // Nous pourrions utiliser filter_var(), FILTER_SANITIZE_STRING mais la communauté php à décidé qu'il ne devais plus être pris en charge, source  : https://stackoverflow.com/questions/69207368/constant-filter-sanitize-string-is-deprecated
                $title = htmlspecialchars($data['title']);
                $body = htmlspecialchars($data['body']);
                $author = htmlspecialchars($data['author']);
                $updated_at = date('Y-m-d H:i:s');

                if ($title === false || $body === false || $author === false) {
                    http_response_code(400);
                    echo json_encode(array("message" => "Données invalides"), JSON_UNESCAPED_UNICODE);
                    return;
                }

                $sql = 'UPDATE posts SET title = :title, body = :body, author = :author, updated_at = :updated_at WHERE id = :id';

                try {
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':body', $body);
                    $stmt->bindParam(':author', $author);
                    $stmt->bindParam(':updated_at', $updated_at);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $response = [
                            "status" => 200,
                            "message" => "Post mis à jour avec succès"
                        ];
                        header("Content-Type: application/json");
                        echo json_encode($response, JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(500);
                        echo json_encode(array("message" => "Erreur lors de la mise à jour du post"), JSON_UNESCAPED_UNICODE);
                    }
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(array("message" => "Erreur de mise à jour : " . $e->getMessage()), JSON_UNESCAPED_UNICODE);
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Données incomplètes. Veuillez fournir title, body et author."), JSON_UNESCAPED_UNICODE);
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "ID non fourni dans les paramètres GET"), JSON_UNESCAPED_UNICODE);
        }
    } else {
        http_response_code(405);
        echo json_encode(array("message" => "Méthode non autorisée"), JSON_UNESCAPED_UNICODE);
    }
}

update();
