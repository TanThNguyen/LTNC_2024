<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

class User{
  
    // database connection and table name
    private $conn;
    private $table_name = "users";
  
    // object properties
    private $id;
    private $name;
    private $email;
    private $phone;
    private $password;
    private $status;
  
    public function __construct($db){
        $this->conn = $db;
    }
    
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPhone($phone){
        $this->phone = $phone;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }    




    public function check_exist($sql){
        return $this->conn->countRow($sql);
    }
    // add patient
    function add(){
        $dataIns = [
            'fullname' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
            'status' => $this->status,
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        return $this->conn->insert($this->table_name, $dataIns);
    }


    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, fullname, email, phone, password, status
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
        return $this->conn->getRow($query);
    }

    public function countAll($condition = ''){
        if (!empty($condition)) {
            $query = "SELECT id FROM " . $this->table_name . " WHERE fullname LIKE '%". $condition ."%' OR email LIKE '%". $condition ."%'";
        } else {
            $query = "SELECT id FROM " . $this->table_name . "";
        }
        
        return $this->conn->countRow($query);
    }



    function readOne(){
  
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = ". $this->id;
        return $this->conn->oneRow($sql);
    }



    function update(){
        $dataUpd = [
            'fullname' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'update_at' => date('Y-m-d H:i:s')
        ];
        if (!empty($this->password)) {
            $dataUpd['password'] = password_hash($this->password, PASSWORD_DEFAULT);
        }
        return $this->conn->update($this->table_name, $dataUpd, "id=$this->id");
  
    }

    function delete(){
        return $this->conn->delete($this->table_name, "id=$this->id");
    }

    public function search($search_term, $from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    id, fullname, email, phone, password, status
                FROM
                    " . $this->table_name . "
                WHERE
                    fullname LIKE '%". $search_term ."%' OR email LIKE '%". $search_term ."%'
                ORDER BY
                    update_at ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
    
        return $this->conn->getRow($query);
    }   
}
?>