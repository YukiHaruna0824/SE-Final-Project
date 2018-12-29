<?php

require_once('BaseAccount.php');
class  MySQL_Account extends BaseAccount {

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
            }
             else {
                //否則就代表連線失敗 mysqli_connect_error() 是顯示連線錯誤訊息
                echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
                return 0;
            }
            $command = "CREATE TABLE IF NOT EXISTS account 
                (id INTEGER not NULL AUTO_INCREMENT , PRIMARY KEY ( id ) , Account VARCHAR(30) not NULL , UNIQUE KEY ( Account ) 
                , Password TEXT , Gender TEXT , Class TEXT , DaSaBi INT(32) , FriendSheet TEXT , Articles TEXT )" ;
            if($this->link->query($command)==true)
                echo "create table su";
            return 1;
    }

    public  function  Add($account, $password, $Gender, $Class)
    {
        $command = "SELECT * FROM account where Account =  '$account'  LIMIT 1";
        $result = $this->link->query($command);
        //已存在
        if ($result && mysqli_num_rows($result) > 0) {
            echo "Already exit";
            return 0;
        }

        $FriendSheet = $account."_FriendSheet";
        $Articles =  $account."_Articles";
        $command = "Insert into account(Account, Password, Gender, Class, DaSaBi, FriendSheet, Articles)
             VALUES('$account' , '$password' , '$Gender' , '$Class' , '0' , '$FriendSheet' , '$Articles')";
        $this->link->query($command);
        $last_id = mysqli_insert_id($this->link);

        //friend Table
        $command = "CREATE TABLE IF NOT EXISTS $FriendSheet
            ( id INT not NULL , UNIQUE KEY ( id )) ";
        $this->link->query($command);

        //Articles Table
       $command = "CREATE TABLE IF NOT EXISTS $Articles
            (id INTEGER not NULL) ";
        $this->link->query($command);

        return $last_id;
    }

    public  function  Delete($account)
    {
        $command = "SELECT * FROM account where Account =  '$account'  LIMIT 1";
        $result = $this->link->query($command);
        //已存在
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $ArticlesTable = $row["FriendSheet"];
                $FriendSheetTable = $row["Articles"];
                $id = $row["id"];
            }

            $command = "DROP TABLE $ArticlesTable";
            $this->link->query($command);
            $command = "DROP TABLE $FriendSheetTable";
            $this->link->query($command);
            $command = "DELETE FROM account WHERE Account =  '$account' ";
            $this->link->query($command);
            return $id;
        }
        else
            return 0;
    }

    public  function  updatePassWord($account, $password)
    {
        $command = "SELECT * FROM account where Account = '$account' LIMIT 1";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $command = "UPDATE account 
                SET PassWord =  '$password' WHERE Account = '$account' ";
                $this->link->query($command);
                return $id;
            }
        }
        else
            return 0;
    }

    public  function  StoreDaSaBi($account,$money)
    {
        $command = "SELECT * FROM account where Account =  '$account' LIMIT 1";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $DaSaBi = $row["DaSaBi"];
                $DaSaBi += $money;
                $command = "UPDATE account 
                SET DaSaBi =  '$DaSaBi' WHERE Account = '$account' ";
                $this->link->query($command);
                $id = $row["id"];
                return $id;
            }
        }
        else
            return 0;
    }

}

?>