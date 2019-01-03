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
    private $group_model;
    public function detect_name($inaccount_name)
    {
        //find this groupname has been used or not
        return $this->account_model->CheckAccount($inaccount_name);
    }
    //add new group
    public function addnewgroup($groupname)
    {
        if($this->group_model->CreateGroup($groupname,$_SESSION['$inaccountname'])!=-1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function getin($groupname)
    {
        //click in group
        if($this->account_model->LoginCheck($groupname,$_SESSION['$inaccountname'])!=-1)//detect is the member in it
        {
            $_SESSION['groupname']=$groupname;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //click out group
    public function getout()
    {
        unset($_SESSION['groupname']);
    }
    public function __construct()
    {
        $this->group_model=new GroupModel();
    }
    public function add_member($addaccountname)
    {
        //add new member
        if($this->account_model->AddMember($_SESSION['groupname'],$addaccountname,$_SESSION['$inaccountname'])==TRUE)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
//add group
if(isset($_POST['gn']))//groupname
{
    $name=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$name]))
    {
        $newgroup=new GroupAccount();
        if($newgroup->addnewgroup($_POST['gn'])==TRUE)
        {
            echo "AC";
        }
        else
        {
            echo "ER";
        }
    }
    else
        echo "WN";
}
//click in
elseif(isset($_POST['ci']))//ci 給groupname
{
    $name=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$name]))
    {
        $newgroup=new GroupAccount();
        if($newgroup->getin($_POST['ci'])==TRUE)
        {
            echo "AC";
        }
        else
        {
            echo "ER";
        }
    }
    else
        echo "WN";
}
//click out
elseif(isset($_POST['co']))//co 給groupname
{
    $name=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$name]))
    {
        $newgroup=new GroupAccount();
        if($newgroup->getout($_POST['co'])==TRUE)
        {
            echo "AC";
        }
        else
        {
            echo "ER";
        }
    }
    else
        echo "WN";
}
//add member
elseif(isset($_POST['aan']))//aan 要加的account name
{
    $name=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$name]))
    {
        $newgroup=new GroupAccount();
        if($newgroup->add_member($_POST['aan'])==TRUE)
        {
            echo "AC";
        }
        else
        {
            echo "ER";
        }
    }
    else
        echo "WN";
}
?>