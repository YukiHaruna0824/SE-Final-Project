<?php

require_once('MySQL_Account.php');

class AccountModel
{
    private $account;

    function __construct()
    {
        $this->account = new MySQL_Account();
    }

    //如果有回傳1 沒有-1
    public  function  CheckAccount($account)
    {
        return $this->account->CheckAccount($account);
    }

    //成功回傳該ID 失敗回傳-1
    public function LoginCheck($account,$password)
    {
        return $this->account->LoginCheck($account,$password);
    }

    //成功回傳該ID 失敗回傳-1
    public  function  Add($account, $password, $Gender, $Class)
    {
        return $this->account->Add($account,$password,$Gender,$Class);
    }

    //成功回傳該ID 失敗回傳-1
    public  function  Delete($account)
    {
        return $this->account->Delete($account);
    }

    //成功回傳該ID 失敗回傳-1
    public  function  updatePassWord($account, $password)
    {
        return $this->account->updatePassWord($account,$password);
    }

    //跟下面一樣
    public function find($account)
    {
        return $this->account->find($account);
    }

    //回傳ID, 失敗-1
    public function GetID($account)
    {
        return $this->account->GetID($account);
    }

    //回傳該ID 對應的account 的 "name"而已 失敗-1
    public function GetAccount($id)
    {
        return $this->account->GetAccount($id);
    }

    /* usage example
      $m = new AccountModel();
$result = $m->RandomChoose("1");
while ($row = $result->fetch_assoc()) {
    echo $row["Account"];
} */
    public function RandomChoose($account)
    {
        return $this->account->RandomChoose($account);
    }

    //成功回傳該ID 失敗回傳-1
    public  function  StoreDaSaBi($account,$money)
    {
        return $this->account->StoreDaSaBi($account,$money);
    }

    //成功回傳該ID 失敗||沒錢回傳-1
    public function UseDaSaBi($account,$money)
    {
        return $this->account->UseDaSaBi($account,$money);
    }

    /* usage example
  $m = new AccountModel();
$result = $m->ListAllGroup("ss");
while ($row = $result->fetch_assoc()) {
echo $row["GroupName"];
} */
    public function ListAllGroup($account)
    {
        return $this->account->ListAllGroup($account);
    }


}