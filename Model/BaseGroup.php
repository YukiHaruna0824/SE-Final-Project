<?php


abstract class BaseGroup
{
    public abstract function CreateGroup($account, $groupName);

    public abstract function KillGroup($groupName);

    public abstract function AddMember($groupName,$account);

    public abstract function KickMember($groupName,$account);

    public abstract function ListGroupAllMembers($groupName);

    public abstract function ListAllGroups();
}