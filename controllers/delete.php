<?php


function deleteController() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
        $id = $_GET['id'] ?? null;

        if ($id !== null) {
            $sql = "DELETE FROM posts WHERE id = ?";
            
            try {
                $stmt = $db->prepare($sql);
                $stmt->execute([$id]);
                
                if ($stmt->rowCount() > 0) {
                    http_response_code(200); 
                    echo json_encode(array("message" => "Post supprimé avec succès"), JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(404); 
                    echo json_encode(array("message" => "Aucun post trouvé avec cet ID"), JSON_UNESCAPED_UNICODE);
                }
            } catch (PDOException $e) {
                http_response_code(500); 
                echo json_encode(array("message" => "Erreur de suppression : " . $e->getMessage()), JSON_UNESCAPED_UNICODE);
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

deleteController();

