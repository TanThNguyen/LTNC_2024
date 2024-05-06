<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('NTGYT');

class Nhanvien extends NguoiThamGiaYTe{
  
    // database connection and table name
    private $conn;
    private $table_name = "nhanvien";
  
    private $CCCD;
    private $diachi;
    private $email;
    private $chuyenmon;
    private $ngayvaolam;
    private $luong;
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

    public function getCCCD(){
        return $this->CCCD;
    }

    public function setCCCD($CCCD){
        $this->CCCD = $CCCD;
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

    public function getChuyenMon(){
        return $this->chuyenmon;
    }

    public function setChuyenMon($chuyenmon){
        $this->chuyenmon = $chuyenmon;
    }

    public function setNgayVaoLam($ngayvaolam){
        $this->ngayvaolam = $ngayvaolam;
    }

    public function getLuong(){
        return $this->luong;
    }

    public function setLuong($luong){
        $this->luong = $luong;
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
    public function add(){
        $this->status = 1;
        $dataIns = [
            'id' => $this->id,
            'ten' => $this->name,
            'CCCD' => $this->CCCD,
            'ngaysinh' => $this->ngaysinh,
            'diachi' => $this->diachi,
            'gioitinh' => $this->gioitinh,
            'email' => $this->email,
            'SDT' => $this->phone,
            'chuyenmon' => $this->chuyenmon,
            'ngayvaolam' => date('Y-m-d H:i:s'),
            'luong' => $this->luong,
            'update_at' => date('Y-m-d H:i:s'),
            'status' => $this->status
        ];
        return $this->conn->insert($this->table_name, $dataIns);
    }


    public function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, ten, email, SDT, chuyenmon,status, update_at
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
        return $this->conn->getRow($query);
    }


    // used for paging patients
    public function countAll($condition = ''){
        if (!empty($condition)) {
            $query = "SELECT id FROM " . $this->table_name . " WHERE ten LIKE '%". $condition ."%' OR email LIKE '%". $condition ."%' OR id LIKE '%". $condition ."%'" ;
        } else {
            $query = "SELECT id FROM " . $this->table_name . "";
        }
        
        return $this->conn->countRow($query);
    }



    public function readOne(){
  
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = ". $this->id;
        return $this->conn->oneRow($sql);
    }



    public function update(){
        $dataUpd = [
            'id' => $this->id,
            'ten' => $this->name,
            'CCCD' => $this->CCCD,
            'ngaysinh' => $this->ngaysinh,
            'diachi' => $this->diachi,
            'gioitinh' => $this->gioitinh,
            'email' => $this->email,
            'SDT' => $this->phone,
            'chuyenmon' => $this->chuyenmon,
            'ngayvaolam' => $this->ngayvaolam,
            'luong' => $this->luong,
            'update_at' => date('Y-m-d H:i:s'),
            'status' => $this->status
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id=$this->id");
  
    }



    // delete the patient
    public function delete(){
        $dataUpd = [
            'status' => 0
        ];
        return $this->conn->update($this->table_name, $dataUpd, "id=$this->id");
    }



    // read patients by search term
    public function search($search_term, $from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    id, ten, email, SDT, chuyenmon,status, update_at
                FROM
                    " . $this->table_name . "
                WHERE
                    ten LIKE '%". $search_term ."%' OR email LIKE '%". $search_term ."%' OR id LIKE '%". $search_term ."%'
                ORDER BY
                    id ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
    
        return $this->conn->getRow($query);
    }

    public function khamBenh($benhan){
        return $benhan->add();
    }
    
}
?>