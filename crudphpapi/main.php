<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With,  Origin, Content-Type,");
header("Access-Control-Max-Age: 86400");
// ini_set('display_errors',0);
date_default_timezone_set("Asia/Manila");
set_time_limit(1000);

$root = $_SERVER['DOCUMENT_ROOT'];
$api = $root .'/crudphpapi';

// Configuring the database connection
require_once($api . '/config/connection.php');

//Model for CRUD operations
require_once($api . '/model/crudModel.php');

$dbase = new connection();
$pdo = $dbase->connect();

$crud = new CrudModel($pdo);

$data = json_decode(file_get_contents("php://input"));

$req = [];

if(isset($_REQUEST['request']))
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
else $req = array('errorcatcher');

switch ($_SERVER['REQUEST_METHOD']) {
 
    //GET (ALL AND ONE)
    case 'GET':
            if($req[0]=='Get'){
                if($req[1]=='All'){echo json_encode($crud->getAll()); return;}
                if($req[1]== 'Single'){echo json_encode($crud->GetSingle($data)); return;}
            }
        break;

    //INSERT 
    case 'POST':
        if($req[0] == 'Insert'){echo json_encode($crud->insert($data)); return;}
        break;

    //UPDATE 
    case 'PUT':
        if($req[0]== 'Update'){echo json_encode($crud->update($data)); return;}
        break;

    //DELETE
    case 'DELETE':
        if($req[0]== 'Delete'){echo json_encode($crud->delete($data)); return;}  
        break;

    default:
        echo "Invalid request";
        http_response_code(403);
        break;
}