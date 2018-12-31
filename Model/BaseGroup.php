<?php


abstract class BaseGroup
{
    public abstract function CreateGroup($groupName, $account);

    public abstract function KillGroup($groupName);

    public abstract function AddMember($groupName,$account);

    public abstract function KickMember($groupName,$account);

    public abstract function ListGroupAllMembers($groupName);

    public abstract function ListAllGroups();

    public abstract function AddGroupArticle($group, $owner, $title, $content);

    public abstract function DeleteGroupArticle($group,$articleID);

    public abstract function ListAllGroupArticle($group);
}