<?php

abstract class  BaseAccount
{
    public abstract function Add($account, $password, $Gender, $Class);

    public abstract function  CheckAccount($account);

    public abstract function LoginCheck($account,$password);

    public abstract function  Delete($account);

    public abstract function  updatePassWord($account, $password);

    public abstract function find($account);

    public abstract function RandomChoose($account);

    public abstract function  StoreDaSaBi($account,$money);

    public abstract function  UseDaSaBi($account,$money);
}