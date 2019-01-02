<?php

class MySQL_AD
{

//先設定資料庫資訊，主機通常都用本機
    public $host = "localhost";
//以root管理者帳號進入資料庫
    public $dbuser = "root";
//root的資料庫密碼
    public $dbpw = "root";
//登入後要使用的資料庫
    public $dbname = "ntust";

    public $link =null;
    function __construct()//CREATE DATABASE mydatabase CHARACTER SET utf8 COLLATE utf8_general_ci;
    {
        $this->link = mysqli_connect($this->host, $this->dbuser, $this->dbpw, $this->dbname);
        if ($this->link) {
            mysqli_query($this->link, "SET NAMES utf8");
        }
        else {
            //否則就代表連線失敗 mysqli_connect_error() 是顯示連線錯誤訊息
            echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
            return -1;
        }
        $command = "CREATE TABLE IF NOT EXISTS AllAD 
                (id INTEGER not NULL AUTO_INCREMENT , PRIMARY KEY ( id ) , Title VARCHAR(30) not NULL , UNIQUE KEY ( Title ), Content TEXT, Owner VARCHAR(30) not NULL )" ;
        $this->link->query($command);
        return 1;
    }

    public function Add($Title, $Content, $owner)
    {
        $command = "Insert into AllAD(Title, Content, Owner)
             VALUES('$Title' , '$Content' , '$owner')";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
           return mysqli_insert_id($this->link);
        }
        else
            return -1;
    }

    public function Delete($ADID)
    {
        $command = "DELETE FROM AllAD WHERE id =  '$ADID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return 1;
        }
        else
            return -1;
    }

    public function UpDateContent($ADID, $content)
    {
        $command = "UPDATE AllAD 
                SET Content =  '$content' WHERE id = '$ADID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0)
            return 1;
        else
            return -1;
    }

    public function ListAllAccountAD($owner)
    {
        $command = "SELECT * FROM AllAD WHERE Owner = '$owner'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        }
        return null;
    }

    public function ListAllAD()
    {
        $command = "SELECT * FROM AllAD ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        }
        return null;
    }
}