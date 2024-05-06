<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('NTGYT');

class benhnhan extends NguoiThamGiaYTe{
    private $conn;
    private $table_name = "benhnhan";
  
    // object properties
    private $BaoHiem;
    private $diachi;
    private $update_at;

  
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

    public function getBaoHiem(){
        return $this->BaoHiem;
    }

    public function setBaoHiem($BaoHiem){
        $this->BaoHiem = $BaoHiem;
    }

    public function getNgaysinh(){
        return $this->ngaysinh;
    }

    public function setNgaysinh($Ngaysinh){
        $this->ngaysinh = $Ngaysinh;
    }

    public function getDiaChi(){
        return $this->diachi;
    }

    public function setDiaChi($diachi){
        $this->diachi = $diachi;
    }

    public function getGioiTinh(){
        return $this->gioitinh;
    }

    public function setGioiTinh($gioitinh){
        $this->gioitinh = $gioitinh;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPhone($phone){
        $this->phone = $phone;
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
        $this->status = 1;
        $dataIns = [
            'id' => $this->id,
            'ten' => $this->name,
            'BaoHiem' => $this->BaoHiem,
            'ngaysinh' => $this->ngaysinh,
            'diachi' => $this->diachi,
            'gioitinh' => $this->gioitinh,
            'SDT' => $this->phone,
            'update_at' => date('Y-m-d H:i:s'),
            'status' => $this->status
        ];
        return $this->conn->insert($this->table_name, $dataIns);
    }


    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, ten, SDT, BaoHiem, status, update_at
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
            $query = "SELECT id FROM " . $this->table_name . " WHERE ten LIKE '%". $condition ."%' OR BaoHiem LIKE '%". $condition ."%'" ;
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
            'BaoHiem' => $this->BaoHiem,
            'ngaysinh' => $this->ngaysinh,
            'diachi' => $this->diachi,
            'gioitinh' => $this->gioitinh,
            'SDT' => $this->phone,
            'update_at' => date('Y-m-d H:i:s'),
            'status' => $this->status
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
  
    }



    // delete the patient
    function delete(){
        $dataUpd = [
            'status' => 0
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id='$this->id'");
    }



    // read patients by search term
    public function search($search_term, $from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    id, ten, SDT, BaoHiem, status, update_at
                FROM
                    " . $this->table_name . "
                WHERE
                    ten LIKE '%". $search_term ."%' OR BaoHiem LIKE '%". $search_term."%'
                ORDER BY
                    id ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
    
        return $this->conn->getRow($query);
    }
    
    public function khamBenh($benhan){
        return $benhan->readOne();
    }

}
?>