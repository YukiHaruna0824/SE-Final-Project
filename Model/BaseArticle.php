<?php
/**
 * Created by PhpStorm.
 * User: shion
 * Date: 2018/12/29
 * Time: 上午 11:39
 */

abstract class BaseArticle
{
    public abstract function Add($account,$title,$content);

    public abstract  function  DeleteAritcle($id);

    public abstract function  UpdateTitle($id,$Title);

    public abstract function  UpdateContent($id,$Content);

    public abstract function Choose($id);

    public abstract function ChooseRange($Range,$Range2);
}