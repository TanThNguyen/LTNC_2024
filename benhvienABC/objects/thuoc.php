<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

class thuoc{
  
    // database connection and table name
    private $conn;
    private $table_name = "khothuoc";
  
    // object properties
    private $id;
    private $name;
    private $TacDung;
    private $soluong;
    private $gia;
    private $ql_id;
    private $update_at;
    private $lothuoc;

  
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

    public function getTacDung(){
        return $this->TacDung;
    }

    public function setTacDung($TacDung){
        $this->TacDung = $TacDung;
    } 

    public function getSoLuong(){
        return $this->soluong;
    }

    public function setSoLuong($soluong){
        $this->soluong = $soluong;
    }

    public function getGia(){
        return $this->gia;
    }

    public function setGia($gia){
        $this->gia = $gia;
    }  

    public function getQL_ID(){
        return $this->ql_id;
    }

    public function setQL_ID($ql_id){
        $this->ql_id = $ql_id;
    }

        public function check_exist($sql){
        return $this->conn->countRow($sql);
    }

    // add patient
    function add(){
        $dataIns = [
            'id' => $this->id,
            'ten' => $this->name,
            'TacDung' => $this->TacDung,
            'soluong' => $this->soluong,
            'gia' => $this->gia,
            'ql_id' => $this->ql_id,
            'update_at' => date('Y-m-d H:i:s')
        ];
        return $this->conn->insert($this->table_name, $dataIns);
    }


    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    *
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
            $query = "SELECT id FROM " . $this->table_name . " WHERE ten LIKE '%". $condition ."%' OR id LIKE '%". $condition ."%'" ;
        } else {
            $query = "SELECT id FROM " . $this->table_name . "";
        }
        
        return $this->conn->countRow($query);
    }



    function readOne(){
  
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = '". $this->id ."'";
        return $this->conn->oneRow($sql);
    }



    function update(){
        $dataUpd = [
            'id' => $this->id,
            'ten' => $this->name,
            'TacDung' => $this->TacDung,
            'soluong' => $this->soluong,
            'gia' => $this->gia,
            'ql_id' => $this->ql_id,
            'update_at' => date('Y-m-d H:i:s')
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
  
    }

    public function update_SL($SL){
        $dataUpd = [
            'soluong' => $SL
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
    }

    // delete the patient
    function delete(){
        $dataUpd = [
            'soluong' => 0
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
    }



    // read patients by search term
    public function search($search_term, $from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    ten LIKE '%". $search_term ."%' OR id LIKE '%". $search_term."%'
                ORDER BY
                    id ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
    
        return $this->conn->getRow($query);
    }
    
}
?>