<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name0 = "bm_connections";
    private $table_name1 = "bm_keys";
  
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
  
    // read products
    function read(){

        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name0 . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY
                    p.created DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }  
    
    function post(){

        // select all query
        $query0 = "INSERT INTO
                    " . $this->table_name0 . "
                    (u_identifier_appr,c_identifier_appr,insert_by,url)
                VALUE
                    (:u_identifier_appr,:c_identifier_appr, :insert_by,:url)";

        $query1 = "INSERT INTO
                    " . $this->table_name1 . "
                    (identifier,akey)
                   VALUE
                    (:identifier,akey)";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
  
  function postkey(){

        // select all query
        $query = "INSERT INTO
                    " . $this->table_name1 . "
                    (identifier,akey)
                   VALUE
                    (:identifier,:akey)";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;    
    
  }
  
  
}