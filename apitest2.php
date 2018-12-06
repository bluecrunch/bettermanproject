<?php
include_once 'api/config/database.php';
$database = new Database();
$db = $database->getConnection();

$urlar = array();
$sql = "SELECT url,u_identifier_appr,c_identifier_inqu FROM bm_connections WHERE insert_by = 'u'";
$result = $db->query($sql); 
if($result !== false) {
    // use $result here as that you PDO::Statement object
    $allRows = $result->fetchAll(PDO::FETCH_OBJ); 

    // Parse the result set
    foreach($allRows as $row) {
        // also amend here to address the contents of the allRows i.e. $row as objects
      $apipsvar = 'api/posts/read.php?u='.$row->u_identifier_appr.'&c='.$row->c_identifier_inqu;
      $stack = array($row->url.$apipsvar, $apipsvar);
      $urlar[] =  $stack;

    }
}

print_r($urlar);

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

echo '<pre>';
print_r($items);
echo '</pre>';
$i = count($items);
$x = 0;

while($x < $i){

  echo "<div class='card my-3'><div class='card-body'>";
  echo "<h1>".$items[$x]['title']."</h1>";
  if(!empty($items[$x]['byline'])){
    echo "<h4>".$items[$x]['byline']."</h4>";
  }

  echo "<p>".$items[$x]['body']."</p>";
  if(!empty($items[$x]['image'])){
    echo "<img src='".$items[$x]['image']."'>";
  }

  $aid = bin2hex($items[$x]['c_ident'].'&'.$items[$x]['u_ident'].'&'.$items[$x]['id'].'&'.$items[$x]['url']);

  echo "<a href='post.php?pic=".$aid."'>Go to Post</a>"; //post ident codification
  echo "</div></div>";

  $x++;
}
?>