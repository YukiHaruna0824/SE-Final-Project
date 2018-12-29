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

    //成功回傳該ID 失敗回傳-1
    public  function  StoreDaSaBi($account,$money)
    {
        return $this->account->StoreDaSaBi($account,$money);
    }
}