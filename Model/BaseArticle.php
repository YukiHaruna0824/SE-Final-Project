<?php


abstract class BaseArticle
{
    public abstract function Add($account,$title,$content);

    public abstract  function  DeleteAritcle($id);

    public abstract function  UpdateTitle($id,$Title);

    public abstract function  UpdateContent($id,$Content);

    public abstract function Choose($id);

    public abstract function  choseAccountArticle($accont,$Range,$Range2);

    public abstract function ChooseRange($Range,$Range2);
}