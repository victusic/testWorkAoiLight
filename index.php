<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
header('Access-Control-Expose-Headers: *');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    header('Access-Control-Expose-Headers: *');
    die();
}

require 'connect.php';
require 'controllers.php';

$params = explode('/', $_GET['q']);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($params[0]) {
            case 'tasks':
                getTasks($connect);
                break;
            default:
                r405();
                break;
        }
        break;
    case 'POST':
        switch ($params[0]) {
            case 'task':
                postTask($connect, $_POST);
                break;
            default:
                r405();
                break;
        }
        break;
    case 'PATCH':
        switch ($params[0]) {
            case 'task':
                if (isset($params[1])) {
                    $patchData = json_decode(file_get_contents('php://input'), true);
                    updateTask($connect, $params[1], $patchData);
                } else {
                    r400();
                }
                break;
            default:
                r405();
                break;
        }
        break;
    case 'DELETE':
        switch ($params[0]) {
            case 'task':
                if(isset($params[1])){deleteTask($connect, $params[1]);}
                else{r400();}
                break;
            default:
                r405();
                break;
        }
        break;
}

?>
