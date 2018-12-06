<?php
$txt = $_POST["txt"];
$aid = $_POST["aid"];
$usr = $_POST["usr"];
$url = $_POST["url"];

//API Url
$url = 'https://betterman-krampchristian543146.codeanyapp.com/api/posts/post_reply.php';

//Initiate cURL.
$ch = curl_init($url);


//The JSON data.
$jsonData = array(
    'txt' => $txt,
    'aid' => $aid,
    'usr' => $usr

);

//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

//Execute the request
$result = curl_exec($ch);

?>