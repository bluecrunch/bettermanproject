<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/posts.php';
$arr = array();


$database = new Database();
$db = $database->getConnection();
 
$product = new Product($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->txt) &&
    !empty($data->aid) &&
    !empty($data->usr) 
){
 
    // set product property values
    $product->txt = $data->txt;
    $product->aid = $data->aid;
    $product->usr = $data->usr;
    $product->img = NULL;
 
    // create the product
    if($product->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Reply was created.","code" => true));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create reply.","code" => false));

    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    //echo json_encode(array("message" => "Unable to create reply. Data is incomplete.","code" => false));
    echo json_encode(array("message" => "Unable to create reply. Data is incomplete.","code" => false));
}
?>