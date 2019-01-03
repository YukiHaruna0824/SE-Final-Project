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
                (Title VARCHAR(30) not NULL , UNIQUE KEY ( Title ), Path TEXT, Owner VARCHAR(30) not NULL, DaSaBi INT(32) )" ;
        $this->link->query($command);
        return 1;
    }

    public function Add($Title, $path, $owner, $DaSaBi)
    {
        $command = "SELECT * FROM AllAD ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $DaSaBi2 = $row["DaSaBi"];
            }
            if($DaSaBi<=$DaSaBi2)
                return -1;
            $command = "DELETE FROM AllAD ";
            $this->link->query($command);
            $command = "Insert into AllAD (Title, Path, Owner, DaSaBi)
             VALUES('$Title' , '$path' , '$owner', '$DaSaBi')";
            $this->link->query($command);
            return 1;
        }
        $command = "Insert into AllAD (Title, Path, Owner, DaSaBi)
             VALUES('$Title' , '$path' , '$owner', '$DaSaBi')";
        $this->link->query($command);
        return 1;
    }

    public function Delete()
    {
        $command = "DELETE FROM AllAD ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return 1;
        }
        else
            return -1;
    }



    public function GetAD()
    {
        $command = "SELECT * FROM AllAD ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        }
        return null;
    }

    public function GetCurrentDaSaBi()
    {
        $command = "SELECT * FROM AllAD ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                return $row["DaSaBi"];
            }
        }
        else
            return -1;
    }

}