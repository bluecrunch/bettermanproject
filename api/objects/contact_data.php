<?php
class UData{
 
    // database connection and table name
    private $conn;
    private $table_name = "bm_personal_data";
 
    // object properties
    public $first_name; //first name
    public $last_name; //last name
    public $gen_name; //generic name
    public $nickname; //nickname
    public $category; //category -> 0 is individual

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
    function getuser(){
        // select all query
        $query = "SELECT
                    first_name, last_name, gen_name, nickname, category 
                FROM
                    " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;      
    }
}