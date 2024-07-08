<?php

require_once 'config/connexionDB.php';


function deleteController() {
    global $db; 

    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id'])) {
            $id = $data['id'];
            $sql = "DELETE FROM posts WHERE id = ?";
            
            try {
                
                $stmt = $db->prepare($sql);
                
                $stmt->execute([$id]);
                
                if ($stmt->rowCount() > 0) {
                    echo json_encode(array("message" => "Post supprimé avec succès"));
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "Post non trouvé"));
                }
            } catch (PDOException $e) {
                http_response_code(500); 
                echo json_encode(array("message" => "Erreur de suppression : " . $e->getMessage()));
            }
        } else {
            http_response_code(400); 
            echo json_encode(array("message" => "ID non fourni"));
        }
    } else {
        http_response_code(405); 
        echo json_encode(array("message" => "Méthode non autorisée"));
    }
}

deleteController();