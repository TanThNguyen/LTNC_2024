<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

class Database
{

    // specify your own database credentials
    private $host = _HOST;
    private $db_name = _DB;
    private $username = _USER;
    private $password = _PASS;
    public $conn;

    // get the database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            if (class_exists('PDO')) {
                $dsn = 'mysql:dbname=' . $this->db_name . ';host=' . $this->host;
                $option = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',    //set utf8
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION         //Tạo thông báo ra ngoại lệ khi gặp lỗi
                ];
                $this->conn = new PDO($dsn, $this->username, $this->password, $option);
            }
        } catch (Exception $exp) {
            echo '<div style="color:red;padding: 5px 15px; border: 1px solid red;">';
            echo $exp->getMessage() . '<br>';
            echo '</div>';
            die();
        }

        return $this->conn;
    }

    public function query($sql, $data = [], $check = false)
    {
        $kq = false;
        try {
            $stmt = $this->conn->prepare($sql);
            if (!empty($data)) {
                $kq = $stmt->execute($data);
            } else {
                $kq = $stmt->execute();
            }
        } catch (Exception $exp) {
            echo '<div style="color:red;padding: 5px 15px; border: 1px solid red;">';
            echo $exp->getMessage() . '<br>';
            echo '</div>';
            die();
        }

        if ($check) {
            return $stmt;
        }
        return $kq;
    }

    public function insert($table, $data)
    {
        $key = array_keys($data);
        $truong = implode(',',$key);
        $value = ':'.implode(',:',$key);
        $sql = 'INSERT INTO ' . $table.'('.$truong.')'.' VALUES('.$value.')';
        $kq = $this->query($sql,$data);
        return $kq;
    }

    public function update($table, $data, $condition = '')
    {
        $update = '';
        foreach ($data as $key => $value) {
            $update .= $key . '=:' . $key . ',';
        }
        $update = trim($update, ',');

        if (!empty($condition)) {
            $sql = 'UPDATE ' . $table . ' SET ' . $update . ' WHERE ' . $condition;
        } else {
            $sql = 'UPDATE ' . $table . ' SET ' . $update;
        }
        return $this->query($sql, $data);
    }

    public function delete($table, $condition = '')
    {
        if (!empty($condition)) {
            $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
        } else {
            $sql = 'DELETE FROM ' . $table;
        }
        return $this->query($sql);
    }

    public function getRow($sql)
    {
        $kq = $this->query($sql, '', true);
        if (is_object($kq)) {
            $dataFetch = $kq->fetchAll(PDO::FETCH_ASSOC);
        }
        return $dataFetch;
    }

    public function oneRow($sql)
    {
        $kq = $this->query($sql, '', true);
        if (is_object($kq)) {
            $dataFetch = $kq->fetch(PDO::FETCH_ASSOC);
        }
        return $dataFetch;
    }

    //Đếm số dòng dữ liệu
    public function countRow($sql)
    {
        $kq = $this->query($sql, '', true);
        if (is_object($kq)) {
            return $kq->rowCount();
        }
    }
}
