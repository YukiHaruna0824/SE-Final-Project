<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
require_once('../Model/GroupModel.php');

class GroupAccount
{
    private $account_name;
    private $id;
    private $account_model;
    //find this accountname has been used or not
    public function detect_name($inaccount_name)
    {
        return $this->account_model->CheckAccount($inaccount_name);
    }
    public function register($inaccountname,$password,$Gender,$Class)
    {
        //add new group
        if($this->account_model->Add($inaccountname,$password,$Gender,$Class)!=-1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function logout()
    {
        //delete group
        unset($_SESSION[$this->account_name]);
        unset($_SESSION['$inaccountname']);
    }
    public function get_account_name()
    {
        //get member list
        return $this->account_name;
    }
    public function __construct()
    {
        $this->account_model=new AccountModel();
        $this->account_name="";
    }
    public function add_friend($id)
    {
        //add new member
        if($this->account_name!="")
        {
            $tmpfriend=new FriendModel();
            if($tmpfriend->Add($this->account_name,$id)==1)
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }
}
?>