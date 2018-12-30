<?php

require_once('MySQL_ThumbUp.php');

class ThumbUpModel
{
    private $ThumbUp;

    function __construct()
    {
        return $this->ThumbUp = new MySQL_ThumbUp();
    }

    //成功回傳ID 失敗-1
    public function Add($articleID, $account)
    {
        return $this->ThumbUp->Add($articleID, $account);
    }

    //成功1 失敗-1
    public function Delete($articleID, $account)
    {
        return $this->ThumbUp->Delete($articleID, $account);
    }

    /* usage example
      $m = new ThumbUpModel();
$result = $m->GetAll(1);
while ($row = $result->fetch_assoc()) {
    echo $row["Account"];
    echo "\n";
    echo $row["DeliveryDate"];
    echo "\n";
}
     */
    public function GetAll($articleID)
    {
        return $this->ThumbUp->GetAll($articleID);
    }
}