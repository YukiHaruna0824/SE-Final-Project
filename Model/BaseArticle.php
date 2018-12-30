<?php


abstract class BaseArticle
{
    public abstract function Add($account,$title,$content);

    public abstract  function  DeleteAritcle($id);

    public abstract function  UpdateTitle($id,$Title);

    public abstract function  UpdateContent($id,$Content);

    public abstract function Choose($id);

    public abstract function ChooseByTitleDate($title,$date);

    public abstract function  choseAccountArticle($accont,$Range,$Range2);

    public abstract function  GetTotalNumberAccountArticle($account);

    public abstract function ChooseRange($Range,$Range2);

    public abstract function AllArticle();

    public abstract function GetTotalNumber();
}