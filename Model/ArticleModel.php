<?php

require_once('MySQL_Article.php');

class ArticleModel
{
    private $article;

    function __construct()
    {
        $this->article = new MySQL_Article();
    }

    //成功回傳ID 失敗-1
    public function Add($account,$title,$content)
    {
        return $this->article->Add($account,$title,$content);
    }

    //成功回傳1 失敗-1
    public  function  DeleteAritcle($id)
    {
        return $this->article->DeleteAritcle($id);
    }

    //成功回傳1 失敗-1
    public  function  UpdateTitle($id,$Title)
    {
        return $this->article->UpdateTitle($id,$Title);
    }

    //成功回傳1 失敗-1
    public  function  UpdateContent($id,$Content)
    {
        return $this->article->UpdateTitle($id,$Content);
    }


    /* useage example
$m = new ArticleModel();
$result = $m->Choose("sd");

while ($row = $result->fetch_assoc()) {
//拿資料
echo $row["id"];
echo $row["Owner"];
echo $row["Title"];
echo $row["Content"];
echo $row["DeliveryDate"];
echo "\n";
}*/
    public function Choose($id)
    {
        return $this->article->Choose($id);
    }

    public function ChooseByTitleDate($title,$date)
    {
        return $this->article->ChooseByTitleDate($title,$date);
    }

    //取得這個帳號目前有多少文章 return int , 失敗 -1
    public function  GetTotalNumberAccountArticle($account)
    {
        return $this->article->GetTotalNumberAccountArticle($account);
    }

    /* useage example
  $m = new ArticleModel();
$result = $m->choseAccountArticle("sd",0,10);

while ($row = $result->fetch_assoc()) {
//拿資料
echo $row["id"];
echo $row["Owner"];
echo $row["Title"];
echo $row["Content"];
echo $row["DeliveryDate"];
echo "\n";
}*/
    public function  choseAccountArticle($account,$Range,$Range2)
    {
        return $this->article->choseAccountArticle($account,$Range,$Range2);
    }


    //根上面一樣
    public function ChooseRange($Range,$Range2)
    {
        return $this->article->ChooseRange($Range,$Range2);
    }

    //根上面一樣
    public function AllArticle()
    {
        return $this->article->AllArticle();
    }

    //取得這個資料庫目前有多少文章 return int , 失敗 -1
    public function GetTotalNumber()
    {
        return $this->article->GetTotalNumber();
    }

}