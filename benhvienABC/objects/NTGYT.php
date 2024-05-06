<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

abstract class NguoiThamGiaYTe{
    
    protected $id;
    protected $name;
    protected $ngaysinh;
    protected $gioitinh;
    protected $phone;
    protected $status;

    abstract public function add();

    abstract public function update();

    abstract public function delete();

    abstract public function khamBenh($benhan);  
    public function Hello(){
        echo "hellozz";
    }
}
?>