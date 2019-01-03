<?php

require_once('MySQL_Group.php');

class GroupModel
{
    private $group;

    function __construct()
    {
        return $this->group = new MySQL_Group();
    }

    public function CreateGroup($groupName, $account)
    {
        return $this->group->CreateGroup($groupName, $account);
    }

    public function CheckGroup($groupName)
    {
        return $this->group->CheckGroup($groupName);
    }

    public function KillGroup($groupName)
    {
        return $this->group->KillGroup($groupName);
    }

    public function CheckMember($groupName,$account)
    {
        return $this->group->CheckMember($groupName,$account);
    }

    public function AddMember($groupName, $ManagerAccount, $account)
    {
        return $this->group->AddMember($groupName, $ManagerAccount, $account);
    }

    public function KickMember($groupName, $ManagerAccount, $account)
    {
        return $this->group->KickMember($groupName, $ManagerAccount, $account);
    }

    /* usage example
     $result = $m->ListGroupAllMembers("dqw");
while ($row = $result->fetch_assoc()) {
    echo $row["Member"];
    echo "\n";
}
     */
    public function ListGroupAllMembers($groupName)
    {
        return $this->group->ListGroupAllMembers($groupName);
    }

    /* usage example
     $result = $m->ListAllGroups();
while ($row = $result->fetch_assoc()) {
    echo $row["GroupName"];
    echo "\n";
}
     */
    public function ListAllGroups()
    {
        return $this->group->ListAllGroups();
    }

    //成功回傳ID 失敗-1
    public function AddGroupArticle($group, $owner, $title, $content)
    {
        return $this->group->AddGroupArticle($group, $owner, $title, $content);
    }

    //成功回傳1 失敗-1
    public function DeleteGroupArticle($group,$articleID)
    {
        return $this->group->DeleteGroupArticle($group,$articleID);
    }
/* usage example
  $result = $m->ListAllGroupArticle("kkd");
while ($row = $result->fetch_assoc()) {
echo $row["Owner"];
echo "\n";
echo $row["Title"];
echo "\n";
echo $row["Content"];
echo "\n";
}*/
    public function ListAllGroupArticle($group)
    {
        return $this->group->ListAllGroupArticle($group);
    }

    public function AddComment($groupName, $groupArticleID, $content, $account)
    {
        return $this->group->AddComment($groupName, $groupArticleID, $content, $account);
    }

    /* usage example
$result = $m->GetAllComment("suck","1");
while ($row = $result->fetch_assoc()) {
    echo $row["Owner"];
    echo "\n";
    echo $row["Content"];
    echo "\n";
}*/
    public function GetAllComment($groupName, $groupArticleID)
    {
        return $this->group->GetAllComment($groupName, $groupArticleID);
    }

    public function AddThumbUp($groupName, $groupArticleID, $account)
    {
        return $this->group->AddThumbUp($groupName, $groupArticleID, $account);
    }

    public function GetNumberOfThumbUp($groupName, $groupArticleID)
    {
        return $this->group->GetNumberOfThumbUp($groupName, $groupArticleID);
    }
}