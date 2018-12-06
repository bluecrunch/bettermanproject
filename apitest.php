<?php
 
function multiRequest($data, $options = array()) {
 
  // array of curl handles
  $curly = array();
  // data to be returned
  $result = array();
 
  // multi handle
  $mh = curl_multi_init();
 
  // loop through $data and create curl handles
  // then add them to the multi-handle
  foreach ($data as $id => $d) {
 
    $curly[$id] = curl_init();
 
    $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
    curl_setopt($curly[$id], CURLOPT_URL,            $url);
    curl_setopt($curly[$id], CURLOPT_HEADER,         0);
    curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
 
    // post?
    if (is_array($d)) {
      if (!empty($d['post'])) {
        curl_setopt($curly[$id], CURLOPT_POST,       1);
        curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
      }
    }
 
    // extra options?
    if (!empty($options)) {
      curl_setopt_array($curly[$id], $options);
    }
 
    curl_multi_add_handle($mh, $curly[$id]);
  }
 
  // execute the handles
  $running = null;
  do {
    curl_multi_exec($mh, $running);
  } while($running > 0);
 
 
  // get content and remove handles
  foreach($curly as $id => $c) {
    $result[$id] = curl_multi_getcontent($c);
    curl_multi_remove_handle($mh, $c);
  }
 
  // all done
  curl_multi_close($mh);
 
  return $result;
}
 
$data = array(
  'https://betterman-krampchristian543146.codeanyapp.com/api/posts/read.php',
  'https://betterman-krampchristian543146.codeanyapp.com/api/posts/read.php'
);
$r = multiRequest($data);

$items = array();
foreach($data as $username) {
  $data1 = file_get_contents($username);
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
echo count($items);
print_r($items);
echo '</pre>';
//print_r($r[1]);
//print_r($json);
//print_r($r);


//print_r($characters);
//$mc_name = $r['records']['1'];
//print_r($mc_name);
//print_r($r[0][1]);
//echo $dc['price'];
echo '<pre>';
//print_r($r[1]['description']);
//print_r($r['id']);
//echo multiRequest($data)[1][1];
?>