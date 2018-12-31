<?php

require_once('BaseFriend.php');


class MySQL_Friend extends BaseFriend
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


    public function Add($account,$friendID)//傳id不怕改名子, 雙向都加好友
    {
        $command = "SELECT * FROM account where Account = '$account'";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
                while($row = $result->fetch_assoc()) {
                    $FriendSheet = $row["FriendSheet"];
                    $friendID2 = $row["id"];
                }
            $command = "SELECT * FROM account where id = '$friendID'";
            $result = $this->link->query($command);
                if(mysqli_num_rows($result) <= 0)
                    return -1;
                $command = "Insert into $FriendSheet (id) values('$friendID')";
                if($this->link->query($command))
                {
                    $command = "SELECT * FROM account where id = '$friendID'";
                    $result = $this->link->query($command);
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $FriendSheet = $row["FriendSheet"];
                        }
                        $command = "Insert into $FriendSheet (id) values('$friendID2')";
                        if($this->link->query($command))
                            return 1;
                        else
                            return -1;
                    }
                }
                else
                {
                    return -1;
                }
        }
        else
            return -1;
    }

    public  function  DeleteFriend($account,$friendID)//雙向都刪好友
    {
       $command = "SELECT * FROM account where Account =  '$account'  LIMIT 1";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $FriendSheet = $row["FriendSheet"];
                $friendID2 = $row["id"];
            }
            $command = "DELETE FROM $FriendSheet  WHERE id = '$friendID' ";
            if($this->link->query($command))
            {
                $command = "SELECT * FROM account where id =  '$friendID'  LIMIT 1";
                $result = $this->link->query($command);
                if ($result && mysqli_num_rows($result) > 0) {
                    while($row = $result->fetch_assoc()) {
                        $FriendSheet = $row["FriendSheet"];
                    }
                    $command = "DELETE FROM $FriendSheet  WHERE id = '$friendID2' ";
                    if($this->link->query($command))
                        return 1;
                    else
                        return -1;
                }
            }
            else
                return -1;
        }
        return -1;
    }

    public  function  FindAllFriend($account)
    {
        $command = "SELECT * FROM account where Account =  '$account'  LIMIT 1";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $FriendSheet = $row["FriendSheet"];
            }
            $command = "SELECT * FROM $FriendSheet";
            $result = $this->link->query($command);
            if($result && mysqli_num_rows($result) > 0)
                return $result;
            else
                return null;
        }
        else
            return null;
    }

    public function  IsFriend($account,$account2)
    {
        $command = "SELECT * FROM account where Account =  '$account'  LIMIT 1";
        $result = $this->link->query($command);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                $id =  $row["id"];
            }
            $command = "SELECT * FROM account where Account =  '$account2'  LIMIT 1";
            $result = $this->link->query($command);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $FriendSheet = $row["FriendSheet"];
                }
                $command = "SELECT * FROM $FriendSheet where id =  '$id'  LIMIT 1";
                $result = $this->link->query($command);
                if($result && mysqli_num_rows($result) > 0)
                {
                    return 1;
                }
                else
                    return -1;
            }
        }
        return -1;
    }
}