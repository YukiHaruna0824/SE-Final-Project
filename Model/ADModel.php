<?php

require_once('MySQL_AD.php');


class ADModel
{
    private $ad;

    function __construct()
    {
        return $this->ad = new MySQL_AD();
    }

    //  成功ID 失敗-1
    public function Add($Title, $Content, $owner, $DaSaBi)
    {
        return $this->ad->Add($Title, $Content, $owner, $DaSaBi);
    }

    //  成功1 失敗-1
    public function Delete()
    {
        return $this->ad->Delete();
    }


    /*
    $result = $m->GetAD();
    while ($row = $result->fetch_assoc()) {
        echo $row["Owner"];
        echo "\n";
        echo $row["Title"];
        echo "\n";
        echo $row["Content"];
        echo "\n";
        echo $row["DaSaBi"];
        echo "\n";
    }*/
    public function GetAD()
    {
        return $this->ad->GetAD();
    }

    public function GetCurrentDaSaBi()
    {
        return $this->ad->GetCurrentDaSaBi();
    }

}