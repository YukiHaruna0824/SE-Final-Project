<?php

require_once('MySQL_comment.php');

//***留言的model***
class CommetModel
{
    private $comment;

    function __construct()
    {
        return $this->comment = new MySQL_comment();
    }

    //成功回傳ID 失敗-1
    public function Add($articleID, $content, $account)
    {
        return $this->comment->Add($articleID, $content, $account);
    }

    //成功1 失敗-1
    public function Delete($articleID,$commentID)
    {
        return $this->comment->Delete($articleID,$commentID);
    }

    /* usage example
     $result = $m->GetAllComment(1);
while ($row = $result->fetch_assoc()) {
    echo $row["id"];
    echo "\n";
    echo $row["Owner"];
    echo "\n";
    echo $row["Content"];
    echo "\n";
    echo $row["DeliveryDate"];
    echo "\n";
}
     */
    public function GetAllComment($articleID)
    {
        return $this->comment->GetAllComment($articleID);
    }
}