


require_once "controllers/delete.php";
require_once "controllers/getAll.php";
require_once "controllers/getById.php";
require_once "controllers/post.php";
require_once "controllers/update.php";


function route($request_method, $path){

    switch($request_method){
        case 'DELETE':
            return deleteController($path);
            break;

        case "GET":
            if($path === '/'){
                return getController();
            }elseif (preg_match('/^\/(\d+)$/', $path, $matches)){
                $id = $matches[1];
                return getByIdController($id);
                
            }else{
                return null;
                break;
            }
        case "POST":
            return postController();
            break;
        case "PATCH":
            return updateController();
            break;
        default:
           return null;
           break;
    }
}