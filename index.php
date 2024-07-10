<?php
require "config/connexionDB.php";


require_once __DIR__ . "/helpers/core.php";
require_once __DIR__ . "/helpers/request.php";

$method = $_SERVER['REQUEST_METHOD'];

$url = parse_url($_SERVER['REQUEST_URI']);
$path = $url['path'];

switch ($path) {
    case '/delete':
        if ($method === 'DELETE') {
            require_once __DIR__ . '/controllers/delete.php';
        }
        break;
    case '/getAll':
        if ($method === 'GET') {
            require_once __DIR__ . '/controllers/getAll.php';
        } 
        break;
    case '/getById' :
        if($method === 'GET'){
            require_once __DIR__ . '/controllers/getById.php';
        }
        break;
    case '/createPost':
        if($method === 'POST'){
            require_once __DIR__ . '/controllers/createPost.php';
        }
        break;
    case '/update':
        if($method === 'PUT'){
            require_once __DIR__ . '/controllers/update.php';
        }
        break;
}
