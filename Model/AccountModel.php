<?php

require_once('MySQL_Account.php');

class AccountModel
{
    private $account;

    function __construct()
    {
        $this->account = new MySQL_Account();
    }

    public  function  Add($account, $password, $Gender, $Class)
    {
        return $this->account->Add($account,$password,$Gender,$Class);
    }

    public  function  Delete($account)
    {
        return $this->account->Delete($account);
    }

    public  function  updatePassWord($account, $password)
    {
        return $this->account->updatePassWord($account,$password);
    }

    public  function  StoreDaSaBi($account,$money)
    {
        return $this->account->StoreDaSaBi($account,$money);
    }
}