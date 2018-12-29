<?php

require_once('BaseArticle.php');

class Article
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
        }
        else {
            //否則就代表連線失敗 mysqli_connect_error() 是顯示連線錯誤訊息
            echo '無法連線mysql資料庫 :<br/>' . mysqli_connect_error();
            return 0;
        }

        $command = "CREATE TABLE IF NOT EXISTS allArticles 
                (id INTEGER not NULL AUTO_INCREMENT , PRIMARY KEY ( id ) , Owner VARCHAR(30) not NULL
                , Title VARCHAR(30) not NULL, Content TEXT, DeliveryDate TIMESTAMP)" ;
        if($this->link->query($command)==true)
            echo "create table su";
        return 1;
    }

    public function Add($account,$title,$content)
    {
        $command = "SELECT * FROM account where Account = '$account'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {

            $command = "Insert into allArticles(Owner, Title, Content)
             VALUES('$account' , '$title' , '$content')";
            if($this->link->query($command)==true)
            {
                $last_id = mysqli_insert_id($this->link);
                while($row = $result->fetch_assoc()) {
                    $tableName = $row["Articles"];
                }
                $command = "Insert into $tableName (id) values('$last_id')";
                $this->link->query($command);
                return $last_id;
            }
        }
        else
            return 0;
    }

    public  function  DeleteAritcle($id)
    {
        $command = "SELECT * FROM allArticles where id = '$id'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $Owner = $row["Owner"];
            }
            $command = "DELETE FROM allArticles WHERE id =  '$id' ";
            $this->link->query($command);
            //刪除user Table的資料
            $command = "SELECT * FROM account where Account = '$Owner'";
            $result = $this->link->query($command);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $Articles = $row["Articles"];
                    $command = "DELETE FROM $Articles WHERE id =  '$id' ";
                    $this->link->query($command);
                }
            }
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public  function  UpdateTitle($id,$Title)
    {
        $command = "UPDATE allArticles 
                SET Title =  '$Title' WHERE id = '$id' ";
        return $this->link->query($command);
    }

    public  function  UpdateContent($id,$Content)
    {
        $command = "UPDATE allArticles 
                SET Content =  '$Content' WHERE id = '$id' ";
        return $this->link->query($command);;
    }

    public function Choose($id)//*******************************************
    {
        $command = "SELECT * FROM allArticles where id = '$id'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
             }
        }
        return 0;
    }



    public function ChooseRange($Range,$Range2)
    {
        $command = "SELECT * FROM allArticles ORDER BY name ASC LIMIT $Range, $Range2";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
           return $result;
        }
        return 0;
    }
}