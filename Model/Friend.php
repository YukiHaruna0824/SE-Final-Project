<?php

class Friend
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

    public function Connect()
    {
        $this->link = mysqli_connect($this->host, $this->dbuser, $this->dbpw, $this->dbname);
        if ($this->link) {
            mysqli_query($this->link, "SET NAMES utf8");
            return 1;
        }
        else {
            //否則就代表連線失敗 mysqli_connect_error() 是顯示連線錯誤訊息
            echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
            return 0;
        }
    }

    public function Add($account,$friendID)
    {
        $command = "SELECT * FROM account where Account = '$account'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
                while($row = $result->fetch_assoc()) {
                    $FriendSheet = $row["FriendSheet"];
                }
                $command = "Insert into $FriendSheet (id) values('$friendID')";
                return $this->link->query($command);;
        }
        else
            return 0;
    }

    public  function  DeleteAritcle($account,$friendID)
    {
       $command = "SELECT * FROM account where Account =  '$account'  LIMIT 1";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $FriendSheet = $row["FriendSheet"];
            }
            $command = "DELETE FROM $FriendSheet  WHERE Friends = '$friendID' ";
            return $this->link->query($command);;
        }
        return 0;
    }

    public  function  FindLL()
    {

    }

    public  function  FindName()
    {

    }
}