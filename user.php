<?php
    class User{
        // Connection
        private $conn;
        // Table
        private $db_table = "bio_data";

        // Columns
        public $id;
        public $firstname;
        public $lastname;
        public $age;
        
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getUsers(){
            $sqlQuery = "SELECT id, first_name, last_name, age FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE A USER
        public function createUser(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        firstname = :first_name, 
                        lastname = :last_name, 
                        age = :age";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->age=htmlspecialchars(strip_tags($this->age));
            
        
            // bind data
            $stmt->bindParam(":first_name", $this->firstname);
            $stmt->bindParam(":last_name", $this->lastname);
            $stmt->bindParam(":age", $this->age);
            
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }



        // READ single user
        public function getSingleUser(){
            $sqlQuery = "SELECT
                        id, 
                        first_name, 
                        last_name, 
                        age
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->firstname = $dataRow['first_name'];
            $this->lastname = $dataRow['last_name'];
            $this->age = $dataRow['age'];
            
        }        


