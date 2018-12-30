<?php


abstract class BaseComment
{
    public abstract function Add($articleID, $content, $account);

    public abstract function Delete($articleID,$commentID);

    public abstract function GetAllComment($articleID);
}