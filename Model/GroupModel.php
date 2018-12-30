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

    public function ListGroupAllMembers($groupName)
    {
        return $this->group->ListGroupAllMembers($groupName);
    }

    public function ListAllGroups()
    {
        return $this->group->ListAllGroups();
    }
}