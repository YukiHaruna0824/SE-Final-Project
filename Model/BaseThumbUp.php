<?php


abstract class BaseThumbUp
{
    public abstract function Add($articleID, $account);

    public abstract function Delete($articleID, $account);

    public abstract function GetAll($articleID);
}