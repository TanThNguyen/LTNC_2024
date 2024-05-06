<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

class donthuoc{
  
    // database connection and table name
    private $conn;
    private $table_name = "donthuoc";
  
    // object properties
    private $id;
    private $nv_id;
    private $bn_id;
    private $ba_id;
    private $chiphidieutri;

  
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

    public function getba_id(){
        return $this->ba_id;
    }

    public function setba_id($ba_id){
        $this->ba_id = $ba_id;
    }

    public function getchiphidieutri(){
        return $this->chiphidieutri;
    }

    public function setchiphidieutri($chiphidieutri){
        $this->chiphidieutri = $chiphidieutri;
    }


    public function check_exist($sql){
        return $this->conn->countRow($sql);
    }

    function add(){
        $dataIns = [
            'nv_id' => $this->nv_id,
            'bn_id' => $this->bn_id,
            'ba_id' => $this->ba_id,
            'create_at' => date('Y-m-d H:i:s')
        ];
        return $this->conn->insert($this->table_name, $dataIns);
    }


    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                ORDER BY
                    create_at DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
        return $this->conn->getRow($query);
    }


    public function countAll($condition = ''){
        if (!empty($condition)) {
            $query = "SELECT id FROM " . $this->table_name ." WHERE
                    id LIKE '%". $search_term ."%' 
                    OR nv_id LIKE '%". $search_term."%'
                    OR bn_id LIKE '%". $search_term."%'
                    OR ba_id LIKE '%". $search_term."%'";
        } else {
            $query = "SELECT id FROM " . $this->table_name;
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
            'nv_id' => $this->nv_id,
            'bn_id' => $this->bn_id,
            'ba_id' => $this->ba_id,
            'create_at' => date('Y-m-d H:i:s'),
            'chiphidieutri' => $this->chiphidieutri
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
  
    }

    public function search($search_term){
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    id LIKE '%". $search_term ."%'
                    OR nv_id LIKE '%". $search_term."%'
                    OR bn_id LIKE '%". $search_term."%'
                    OR ba_id LIKE '%". $search_term."%'
                ORDER BY
                    create_at DESC";
    
        return $this->conn->getRow($query);
    }

    function delete(){
        $dataUpd = [
            'create_at' => NULL
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
    }
    
    public function add_thuoc($dataIns){
        return $this->conn->insert('donthuoc_thuoc',$dataIns);
    }

    public function update_chiphidieutri($soluong, $tenthuoc){
        $sql = "SELECT soluong ,gia FROM khothuoc WHERE ten = '". $tenthuoc ."'";
        $query = $this->conn->oneRow($sql);
        $sql1 = "SELECT chiphidieutri FROM donthuoc WHERE id = ". $this->id;
        $queryChiPhi = $this->conn->oneRow($sql1);
        $this->chiphidieutri = $queryChiPhi['chiphidieutri'] + $soluong * $query['gia'];
        $dataUpd_SL = [
            'soluong' => ($query['soluong']-$soluong)
        ];
        $this->conn->update('khothuoc', $dataUpd_SL, "ten = '$tenthuoc'");
        $dataUpd = [
            'chiphidieutri' => $this->chiphidieutri
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
    }
}
?>