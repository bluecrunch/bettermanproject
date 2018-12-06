<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "bm_posts";
 
    // object properties
    public $pid; //post_id
    public $ttle; //title
    public $byln; //byline
    public $ldst; //lead statement
    public $bdy; //body
    public $img; //image
    public $crtd; //created
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
    function read($a){

        // select all query
        $query = "SELECT
                    bmp.id AS id, 
                    bmp.title AS title, 
                    bmp.byline AS byline, 
                    bmp.lead_statement AS lead_statement, 
                    bmp.body AS body, 
                    bmp.image AS image, 
                    bmp.created AS created,
                    bmpd.first_name AS bfn,
                    bmpd.last_name AS bln,
                    bmpd.nickname AS bnm,
                    bmc.c_identifier_inqu AS bmcc,
                    bmc.u_identifier_appr AS bmcu,
                    bmc.url AS url
                  FROM
                    bm_posts bmp
                  JOIN bm_personal_data bmpd
                  JOIN (
                  	SELECT * FROM bm_connections WHERE c_identifier_inqu = '$a' AND insert_by = 'u'
                  ) bmc
                  ORDER BY created DESC LIMIT 0,10";  
      
      
//       $query = "SELECT
//                     id, title, byline, lead_statement, body, image, created
//                 FROM
//                     " . $this->table_name . " ORDER BY created DESC LIMIT 0,10";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function readpost($a){

        // select all query
        $query = "SELECT
                    id, 
                    title, 
                    byline, 
                    lead_statement, 
                    body, 
                    image, 
                    created
                  FROM
                    bm_posts
                  WHERE id = '$a'";  
      
      
//       $query = "SELECT
//                     id, title, byline, lead_statement, body, image, created
//                 FROM
//                     " . $this->table_name . " ORDER BY created DESC LIMIT 0,10";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }  

      function readcomments($a){

        // select all query
        $query = "SELECT
                   bpr.text AS text,
                   bpr.c_id AS c_id,
                   bpr.created AS created,
                   bmc.url AS url
                  FROM
                   bm_posts_replies bpr
                  LEFT JOIN bm_connections bmc ON bmc.c_identifier_inqu = bpr.c_id
                  WHERE bpr.post_id = '$a' AND bmc.insert_by = 'u'";
//         $query = "SELECT
//                     text,
//                     c_id,
//                     created
//                   FROM
//                     bm_posts_replies
//                   WHERE post_id = '$a'";  
      
      
//       $query = "SELECT
//                     id, title, byline, lead_statement, body, image, created
//                 FROM
//                     " . $this->table_name . " ORDER BY created DESC LIMIT 0,10";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }  
  
    // create product
    function create(){

        // query to insert record
        $query = "INSERT INTO
                    bm_posts_replies
                SET
                    post_id=:aid, text=:txt, c_id=:usr, image=:img";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->aid=htmlspecialchars(strip_tags($this->aid));
        $this->txt=htmlspecialchars(strip_tags($this->txt));
        $this->usr=htmlspecialchars(strip_tags($this->usr));
        $this->img=htmlspecialchars(strip_tags($this->img));

        // bind values
        $stmt->bindParam(":aid", $this->aid);
        $stmt->bindParam(":txt", $this->txt);
        $stmt->bindParam(":usr", $this->usr);
        $stmt->bindParam(":img", $this->img);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }  
  
}

// SELECT
// bmc.id, 
// bmc.title, 
// bmc.byline, 
// bmc.lead_statement, 
// bmc.body, 
// bmc.image, 
// bmc.created,
// bmpd.first_name,
// bmpd.last_name,
// bmpd.nickname
// FROM
// bm_posts bmc
// JOIN bm_personal_data bmpd
// ORDER BY created DESC LIMIT 0,10