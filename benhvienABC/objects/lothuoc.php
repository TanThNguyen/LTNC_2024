<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

class lothuoc{
  
    // database connection and table name
    private $conn;
    private $table_name = "lothuoc";
  
    // object properties
    private $id;
    private $thuoc_id;
    private $nhaphanphoi;
    private $NSX;
    private $HSD;
    private $soluong;
    private $gia;


  
    public function __construct($db){
        $this->conn = $db;
    }
    
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getThuoc_id(){
        return $this->thuoc_id;
    }

    public function setThuoc_id($thuoc_id){
        $this->thuoc_id = $thuoc_id;
    }

    public function getNhaPhanPhoi(){
        return $this->nhaphanphoi;
    }

    public function setNhaPhanPhoi($nhaphanphoi){
        $this->nhaphanphoi = $nhaphanphoi;
    }

    public function getNSX(){
        return $this->NSX;
    }

    public function setNSX($NSX){
        $this->NSX = $NSX;
    }

    public function getHSD(){
        return $this->HSD;
    }

    public function setHSD($HSD){
        $this->HSD = $HSD;
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



    public function check_exist($sql){
        return $this->conn->countRow($sql);
    }

    function add(){
        $dataIns = [
            'id' => $this->id,
            'thuoc_id' => $this->thuoc_id,
            'nhaphanphoi' => $this->nhaphanphoi,
            'NSX' => $this->NSX,
            'HSD' => $this->HSD,
            'soluong' => $this->soluong,
            'gia' => $this->gia
        ];
        return $this->conn->insert($this->table_name, $dataIns);
    }


    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE thuoc_id = '" . $this->thuoc_id. "'
                ORDER BY
                    id DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
        return $this->conn->getRow($query);
    }


    public function countAll($condition = ''){
        if (!empty($condition)) {
            $query = "SELECT id FROM " . $this->table_name ." WHERE
                    (thuoc_id = '" . $this->thuoc_id. "') 
                    AND 
                    (id LIKE '%". $search_term ."%' 
                    OR nhaphanphoi LIKE '%". $search_term."%')";
        } else {
            $query = "SELECT id FROM " . $this->table_name . "";
        }
        
        return $this->conn->countRow($query);
    }



    function readOne(){  
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = ". $this->id ."";
        return $this->conn->oneRow($sql);
    }



    function update(){
        $dataUpd = [
            'id' => $this->id,
            'thuoc_id' => $this->thuoc_id,
            'nhaphanphoi' => $this->nhaphanphoi,
            'NSX' => $this->NSX,
            'HSD' => $this->HSD,
            'soluong' => $this->soluong,
            'gia' => $this->gia
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id=$this->id");
  
    }

    public function search($search_term, $from_record_num, $records_per_page){
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    (thuoc_id = '" . $this->thuoc_id. "') AND (id LIKE '%". $search_term ."%' OR nhaphanphoi LIKE '%". $search_term."%')
                ORDER BY
                    id DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
    
        return $this->conn->getRow($query);
    }
    
}
?>