<?php

abstract class  BaseAccount
{
    public abstract function Connect();

    public abstract function Add($account, $password, $Gender, $Class);

    public abstract function  Delete($account);

    public abstract function  updatePassWord($account, $password);

    public abstract function  StoreDaSaBi($account,$money);
}