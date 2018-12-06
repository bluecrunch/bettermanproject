<?php
$code = $_GET['pic'];
$code = pack("H*",$code);
$b = (explode("&",$code));
//$c = print
$usr = $b[1];//usr
$cnt = $b[0];//contact
$aid = $b[2];//article_id
$url = $b[3];
//
$apipsvar = 'api/posts/read_post.php?u='.$usr.'&c='.$cnt.'&aid='.$aid;
$getcomm = 'post_comments.php?u='.$usr.'&c='.$cnt.'&aid='.$aid;
$tpst = 'api/posts/create_post.php';
$stack = $url.$apipsvar;
$cpst = $url.$tpst;
$data1 = file_get_contents($stack);
$items = json_decode($data1,true);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
<?php
  include 'css/css.html';
?>
  </head>
<body>
  <div class="mx-auto" style="width:30%;">
    <?php
    echo "<div class='my-3'>";
    echo "<h1>".$items[0]['title']."</h1>";
    if(!empty($items[0]['byline'])){
      echo "<h4>".$items[0]['byline']."</h4>";
    }
    //echo "<h4>".$items[$x]['byline']."</h4>";
    echo "<p>".$items[0]['body']."</p>";
    if(!empty($items[0]['image'])){
      echo "<img src='".$items[0]['image']."'>";
    }
    //$hs = bin2hex($str);
    echo "</div>";
    //echo "<img src='".$items[$x]['body']."'>";
    ?>
    
    <div class="my-5">
      <p class="h4">
        Comments
      </p>
      <form>
        <input name="txt" id="txt" placeholder="Your text"><br>
        <input name="submit" id="updvis" type="submit" value="Submit">
      </form>      
      
<?php
   require 'post_comments.php';
?>
    </div>
  </div>
</body>
<?php
  include 'js/js.html';
?>  
    <script>
      
    $(function () {

    $('#updvis').click(function () {
          var txt = document.getElementById("txt").value;    
          var aid = '<?php echo $aid; ?>';  
          var usr = '<?php echo $cnt; ?>';  
          var url = '<?php echo $url; ?>';    
          event.preventDefault();

          $.ajax({
             type: "POST",
             url: 'api/posts/create_post.php',
             data: {txt: txt, aid: aid, usr: usr, url:url},
             cache: false,
             success: function(data){
               //if(data.success == true){ // if true (1)
                   location.reload(); // then reload the page.(3)
               //}
             }})

        });

      });
    </script>      
</html>
