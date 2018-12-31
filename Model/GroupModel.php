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
        return $this->group->CreateGroup($account, $groupName);
    }

    public function KillGroup($groupName)
    {
        return $this->group->KillGroup($groupName);
    }

    public function AddMember($groupName,$account)
    {
        return $this->group->AddMember($groupName,$account);
    }

    public function KickMember($groupName,$account)
    {
        return $this->group->KickMember($groupName,$account);
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
}