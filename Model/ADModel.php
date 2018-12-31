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
    public function Add($Title, $Content, $owner)
    {
        return $this->ad->Add($Title, $Content, $owner);
    }

    //  成功1 失敗-1
    public function Delete($ADID)
    {
        return $this->ad->Delete($ADID);
    }

    //  成功1 失敗-1
    public function UpDateContent($id, $content)
    {
        return $this->ad->UpDateContent($id, $content);
    }

    /*
    $result = $m->ListAllAccountAD("ss");
    while ($row = $result->fetch_assoc()) {
        echo $row["Owner"];
        echo "\n";
        echo $row["Title"];
        echo "\n";
        echo $row["Content"];
        echo "\n";
    }*/
        public function ListAllAccountAD($owner)
        {
            return $this->ad->ListAllAccountAD($owner);
        }

        /*
     $result = $m->ListAllAD();
    while ($row = $result->fetch_assoc()) {
    echo $row["Owner"];
    echo "\n";
    echo $row["Title"];
    echo "\n";
    echo $row["Content"];
    echo "\n";
    }*/
    public function ListAllAD()
    {
        return $this->ad->ListAllAD();
    }
}