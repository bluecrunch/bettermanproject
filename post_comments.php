<?php
include_once 'api/config/database.php';
$database = new Database();
$db = $database->getConnection();
//$apipsvar = 'api/posts/read.php?u=cjaddwowedaaw&c=asdsdwdhfhfdj'; //set path to read posts

$owner = $usr;
$contact = $cnt;
$aid = $aid;

$urlar = array();
$sql = "SELECT url,u_identifier_appr,c_identifier_inqu FROM bm_connections WHERE insert_by = 'u' AND c_identifier_inqu = '$contact'";
$result = $db->query($sql); 
if($result !== false) {
    // use $result here as that you PDO::Statement object
    $allRows = $result->fetchAll(PDO::FETCH_OBJ); 

    // Parse the result set
    foreach($allRows as $row) {
        // also amend here to address the contents of the allRows i.e. $row as objects
      $apipsvar = 'api/posts/read_post_comment.php?u='.$row->u_identifier_appr.'&c='.$row->c_identifier_inqu.'&aid='.$aid;
      $stack = array($row->url.$apipsvar, $apipsvar);
      $urlar[] =  $stack;

    }
}

$items = array();
foreach($urlar as $username) {
  $data1 = file_get_contents($username[0]);
  $items[] = json_decode($data1,true);
}

$items = call_user_func_array('array_merge_recursive', $items);

usort($items, function ($a, $b) {
    $dateA = DateTime::createFromFormat('Y-m-d H:i:s', $a['created']);
    $dateB = DateTime::createFromFormat('Y-m-d H:i:s', $b['created']);
    // ascending ordering, use `<=` for descending
    return $dateA <= $dateB;
});


$i = count($items);
$x = 0;

while($x < $i){

  echo "<div class='card my-3'><div class='card-body'>";
  //echo "<h4>".$items[$x]['byline']."</h4>";
  echo "<p>".$items[$x][0]['first_name']." ".$items[$x][0]['last_name']."</p>";
  echo "<p>".$items[$x]['text']."</p>";
  //$hs = bin2hex($str);
  echo "</div></div>";
  //echo "<img src='".$items[$x]['body']."'>";
  $x++;
}



//print_r($r[1]);
//print_r($json);
//print_r($r);


//print_r($characters);
//$mc_name = $r['records']['1'];
//print_r($mc_name);
//print_r($r[0][1]);
//echo $dc['price'];
//print_r($r[1]['description']);
//print_r($r['id']);
//echo multiRequest($data)[1][1];
?>