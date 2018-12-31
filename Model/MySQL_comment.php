<?php

require_once('BaseComment.php');

class MySQL_comment extends BaseComment
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

    public function Add($articleID, $content, $account)
    {
        $command = "SELECT * FROM allArticles where id = '$articleID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $table = $row["Comment"];
            }
            $command = "Insert into $table(Owner, Content)
             VALUES('$account' , '$content')";

            if($this->link->query($command))
                return  mysqli_insert_id($this->link);
            else
                return -1;
        }
        else
            return -1;
    }

    public function Delete($articleID,$commentID)
    {
        $command = "SELECT * FROM allArticles where id = '$articleID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $table = $row["Comment"];
            }
            $command = "DELETE FROM $table WHERE id =  '$commentID' ";
            if($this->link->query($command))
                return  1;
            else
                return -1;
        }
        else
            return -1;
    }

    public function GetAllComment($articleID)
    {
        $command = "SELECT * FROM allArticles where id = '$articleID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $table = $row["Comment"];
            }
            $command = "SELECT * FROM $table ORDER BY DeliveryDate ASC";
            $result = $this->link->query($command);
            if ($result && mysqli_num_rows($result) > 0) {
                return $result;
            }
            else
                return
                    null;
        }
        else
            return
                null;
    }
}