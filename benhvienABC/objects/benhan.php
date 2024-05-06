<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

class benhan{
  
    // database connection and table name
    private $conn;
    private $table_name = "benhan";
  
    // object properties
    private $id;
    private $nv_id;
    private $bn_id;
    private $start;
    private $end;
    private $tenbenh;
    private $phuongphapKT;
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

    public function getnv_id(){
        return $this->nv_id;
    }

    public function setnv_id($nv_id){
        $this->nv_id = $nv_id;
    }

    public function getbn_id(){
        return $this->bn_id;
    }

    public function setbn_id($bn_id){
        $this->bn_id = $bn_id;
    }

    public function getstart(){
        return $this->start;
    }

    public function setstart($start){
        $this->start = $start;
    }

    public function getend(){
        return $this->end;
    }

    public function setend($end){
        $this->end = $end;
    }

    public function gettenbenh(){
        return $this->tenbenh;
    }

    public function settenbenh($tenbenh){
        $this->tenbenh = $tenbenh;
    }

    public function getphuongphapKT(){
        return $this->phuongphapKT;
    }

    public function setphuongphapKT($phuongphapKT){
        $this->phuongphapKT = $phuongphapKT;
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
            'id' => $this->id,
            'nv_id' => $this->nv_id,
            'bn_id' => $this->bn_id,
            'start' => date('Y-m-d H:i:s'),
            'end' => ($this->status == 'Da xong') ? date('Y-m-d H:i:s') : NULL,
            'tenbenh' => $this->tenbenh,
            'phuongphapKT' => $this->phuongphapKT,
            'status' => $this->status
        ];
        return $this->conn->insert($this->table_name, $dataIns);
    }


    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE bn_id = '" . $this->bn_id. "'
                ORDER BY
                    id DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
        return $this->conn->getRow($query);
    }


    public function countAll($condition = ''){
        if (!empty($condition)) {
            $query = "SELECT id FROM " . $this->table_name . " WHERE 
            (bn_id = '" . $this->bn_id. "') 
            AND 
            id LIKE '%". $condition ."%'" ;
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
            'nv_id' => $this->nv_id,
            'bn_id' => $this->bn_id,
            'start' => ($this->start == NULL) ? date('Y-m-d H:i:s') : $this->start,
            'end' => ($this->status == 'Da xong') ? date('Y-m-d H:i:s') : NULL,
            'tenbenh' => $this->tenbenh,
            'phuongphapKT' => $this->phuongphapKT,
            'status' => $this->status
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
  
    }



    // delete the patient
    function delete(){
        $dataUpd = [
            'start' => NULL
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
    }



    // read patients by search term
    public function search($search_term, $from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    id, tenbenh, phuongphapKT, start, end, status
                FROM
                    " . $this->table_name . "
                WHERE
                    (bn_id = '" . $this->bn_id. "') 
                    AND
                    id LIKE '%". $search_term ."%'
                ORDER BY
                    start DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
    
        return $this->conn->getRow($query);
    }
    
}
?>