<?php


abstract class BaseFriend
{
    public abstract function Add($account,$friendID);

    public abstract function  DeleteFriend($account,$friendID);

    public abstract function  FindAllFriend($account);

    public abstract function  IsFriend($account,$account2);
}