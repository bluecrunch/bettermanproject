<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/posts.php';
include_once '../objects/verification.php';

$owner = $_GET["u"];
$contact = $_GET["c"];

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new Product($db);
$verify = new Verify($db);

// query products
$ctrl = $verify->check($owner,$contact);
$stmt = $product->read($contact);
$num = $stmt->rowCount();

if($ctrl){
    // check if more than 0 record found
    if($num>0){

        // products array
        $products_arr=array();
        //$products_arr["records"]=array();

        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);

            $product_item=array(
                "id" => $id,
                "title" => $title,
                "byline" => $byline,
                "lead_statement" => $lead_statement,
                "body" => $body,
                "image" => $image,
                "created" => $created,
                "name" => $bfn,
                "c_ident" => $bmcc,
                "u_ident" => $bmcu,
                "url" => $url
            );


            array_push($products_arr, $product_item);
        }

        // set response code - 200 OK
        http_response_code(200);

        // show products data in json format
        echo json_encode($products_arr);
    }

    else{

        // set response code - 404 Not found
        http_response_code(404);

        // tell the user no products found
        echo json_encode(
            array("message" => "No products found.")
        );
    }
}
else {
  echo json_encode(
      array("message" => "No access.")
  );
}

