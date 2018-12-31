<?php

require_once('BaseThumbUp.php');

class MySQL_ThumbUp extends BaseThumbUp
{
    //先設定資料庫資訊，主機通常都用本機
    public $host = "localhost";
//以root管理者帳號進入資料庫
    public $dbuser = "root";
//root的資料庫密碼
    public $dbpw = "";
//登入後要使用的資料庫
    public $dbname = "ntust";

    public $link =null;

    public function __construct()
    {
        $this->link = mysqli_connect($this->host, $this->dbuser, $this->dbpw, $this->dbname);
        if ($this->link) {
            mysqli_query($this->link, "SET NAMES utf8");
            return 1;
        }
        else {
            //否則就代表連線失敗 mysqli_connect_error() 是顯示連線錯誤訊息
            echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
            return -1;
        }
    }

    public function Add($articleID, $account)
    {
        $command = "SELECT * FROM allArticles where id = '$articleID' ";
        $result = $this->link->query($command);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $table = $row["ThumbUp"];
                $number = $row["ThumbUpNnumber"];
                $number+=1;
                $command = "UPDATE allArticles 
                SET ThumbUpNnumber =  '$number' WHERE id = '$articleID' ";
                $this->link->query($command);
            }
            $command = "Insert into $table(Account)
             VALUES('$account')";
            if($this->link->query($command))
                return  mysqli_insert_id($this->link);
            else
                return -1;
        }
        else
            return -1;
    }

    public function Delete($articleID, $account)
    {
        $command = "SELECT * FROM allArticles where id = '$articleID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $table = $row["ThumbUp"];
                $number = $row["ThumbUpNnumber"];
                if($number<=0)
                    return -1;
                $number-=1;
                $command = "UPDATE allArticles 
                SET ThumbUpNnumber =  '$number' WHERE id = '$articleID' ";
                $this->link->query($command);
            }
            $command = "DELETE FROM $table WHERE Account =  '$account' ";
            if($this->link->query($command))
                return  1;
            else
                return -1;
        }
        else
            return -1;
    }

    public function GetAll($articleID)
    {
        $command = "SELECT * FROM allArticles where id = '$articleID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $table = $row["ThumbUp"];
            }
            $command = "SELECT * FROM $table ORDER BY DeliveryDate ASC";
            $result = $this->link->query($command);
            if ($result && mysqli_num_rows($result) > 0) {
                return $result;
            }
        }
    }

    public function GetNumberOfThumbUp($articleID)
    {
        $command = "SELECT * FROM allArticles where id = '$articleID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["ThumbUpNnumber"];
            }
        }
        else
            return -1;
    }
}