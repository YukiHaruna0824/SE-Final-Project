<?php

require_once('BaseGroup.php');

class MySQL_Group extends BaseGroup
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
        $command = "CREATE TABLE IF NOT EXISTS Groups 
                (id INTEGER not NULL AUTO_INCREMENT , PRIMARY KEY ( id ) , GroupName VARCHAR(30) not NULL , UNIQUE KEY ( GroupName ) )" ;
        $this->link->query($command);

        return 1;
    }

    public function CreateGroup($groupName, $account)
    {
        //總table
        $command = "Insert into Groups (GroupName)
             VALUES('$groupName')";
        $this->link->query($command);
        $last_id = mysqli_insert_id($this->link);

        //account
        $command = "SELECT * FROM account where Account = '$account'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $tableName = $row["Groups"];
            }
            $command = "Insert into $tableName (GroupName)
             VALUES('$groupName')";
            $this->link->query($command);
        }

        $command = "CREATE TABLE IF NOT EXISTS $groupName
            ( Member VARCHAR(30) not NULL , UNIQUE KEY ( Member )) ";
        $this->link->query($command);
        $command = "Insert into $groupName (Member)
             VALUES('$account')";
        $this->link->query($command);

        $GroupArticle = $groupName."_GroupArticle";
        $command = "CREATE TABLE IF NOT EXISTS $GroupArticle 
                (id INTEGER not NULL AUTO_INCREMENT , PRIMARY KEY ( id ) , Owner VARCHAR(30) not NULL
                , Title VARCHAR(30) not NULL, Content TEXT, DeliveryDate TIMESTAMP )" ;
        $this->link->query($command);

        return $last_id;
    }

    public function KillGroup($groupName)
    {

        $command = "DELETE FROM Groups WHERE GroupName =  '$groupName' ";
        $this->link->query($command);

        //account
        $command = "SELECT * FROM $groupName ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $member = $row["Member"];
                $command = "SELECT * FROM account where Account = '$member'";
                $result = $this->link->query($command);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tableName = $row["Groups"];
                        $command = "DELETE FROM $tableName WHERE GroupName =  '$groupName' ";
                        $this->link->query($command);
                    }
                }
            }
        }

        $command = "DROP TABLE $groupName";
        $this->link->query($command);

        return 1;
    }

    public function CheckGroup($groupName)
    {
        $command = "SELECT * FROM Groups where GroupName =  '$groupName'  LIMIT 1";
        $result = $this->link->query($command);
        //已存在
        if ($result && mysqli_num_rows($result) > 0) {
            return 1;
        }
        else
        {
            return-1;
        }

    }

    public function AddMember($groupName,$account)
    {
        $command = "SELECT * FROM account where Account = '$account'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $tableName = $row["Groups"];
            }
            $command = "Insert into $tableName (GroupName)
             VALUES('$groupName')";
            $result = $this->link->query($command);
        }

        $command = "Insert into $groupName (Member)
             VALUES('$account')";
        $this->link->query($command);

        return 1;
    }

    public function KickMember($groupName,$account)
    {
        $command = "DELETE FROM $groupName WHERE Member =  '$account' ";
        if(!$this->link->query($command))
            return -1;

        $command = "SELECT * FROM account where Account = '$account'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $tableName = $row["Groups"];
            }
            $command = "DELETE FROM $tableName WHERE GroupName =  '$groupName' ";
            $this->link->query($command);
        }
        return 1;
    }

    public function ListGroupAllMembers($groupName)
    {
        $command = "SELECT * FROM $groupName ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        }
        else
            return null;
    }

    public function ListAllGroups()
    {
        $command = "SELECT * FROM Groups ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        }
        else
            return null;
    }

    public function AddGroupArticle($group, $owner, $title, $content)
    {
        $tableName = $group."_GroupArticle";
        $command = "Insert into $tableName (Owner, Title, Content)
             VALUES('$owner', '$title', '$content')";
        $result = $this->link->query($command);
        $last_id = mysqli_insert_id($this->link);
        if ($result && mysqli_num_rows($result) > 0) {
            return $last_id;
        }
        else
            return -1;
    }

    public function DeleteGroupArticle($group,$articleID)
    {
        $tableName = $group."_GroupArticle";
        $command = "DELETE FROM $tableName WHERE id =  '$articleID' ";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return 1;
        }
        else
            return -1;
    }

    public function ListAllGroupArticle($group)
    {
        $tableName = $group."_GroupArticle";
        $command = "SELECT * FROM $tableName";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        }
        else
            return null;
    }


}