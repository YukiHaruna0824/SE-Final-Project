<?php

require_once('MySQL_Friend.php');


class FriendModel
{
    private $friend;

    function __construct()
    {
       return $this->friend = new MySQL_Friend();
    }

    //成功 1, 失敗-1
    public function Add($account,$friendID)
    {
        return $this->friend->Add($account,$friendID);
    }

    //成功 1, 失敗-1
    public  function  DeleteFriend($account,$friendID)
    {
        return $this->friend->DeleteFriend($account,$friendID);
    }


    //回傳該帳好所有的好友ID 失敗-1
    /* usage example
      $result = $friend->FindAllFriend("sd");
while ($row = $result->fetch_assoc()) {
    echo $row["id"];
}
     */
    public  function  FindAllFriend($account)
    {
        return  $this->friend->FindAllFriend($account);
    }

    //回傳兩帳號是否為好友  不適-1
    public function IsFriend($account,$account2)
    {
        return $this->friend->IsFriend($account,$account2);
    }
}