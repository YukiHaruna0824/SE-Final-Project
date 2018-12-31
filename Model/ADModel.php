<?php

require_once('MySQL_AD.php');


class ADModel
{
    private $ad;

    function __construct()
    {
        return $this->ad = new MySQL_AD();
    }

    public function Add($Title, $Content, $owner)
    {
        return $this->ad->Add($Title, $Content, $owner);
    }

    public function Delete($ADID)
    {
        return $this->ad->Delete($ADID);
    }

    //  $row[""];  id,Title,Content,Owner
    public function UpDateContent($id, $tontent)
    {
        return $this->ad->UpDateContent($id, $tontent);
    }

    //  $row[""];  id,Title,Content,Owner
    public function ListAllAccountAD($owner)
    {
        return $this->ad->ListAllAccountAD($owner);
    }
}