<?php
class Verify{
 
    // database connection and table name
    private $conn;
    private $table_name = "bm_connections";
 
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
    function check($a,$b){

        // select all query
        $query = "SELECT
                    u_identifier_appr, c_identifier_inqu, insert_by
                FROM
                    " . $this->table_name . " WHERE u_identifier_appr = '$a' AND c_identifier_inqu = '$b' AND insert_by = 'c'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if( !$row)
        {
            return false;
        }
        else {
            return true;
        }

    }
}

?>