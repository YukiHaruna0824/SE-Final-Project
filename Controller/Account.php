<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
require_once('../Model/AccountModel.php');
require_once('../Model/FriendModel.php');

class Account
{
    private $account_name;
    private $id;
    private $account_model;
    //find this accountname has been used or not
    public function detect_name($inaccount_name)
    {
        return $this->account_model->CheckAccount($inaccount_name);
    }
    //add new account
    public function register($inaccountname,$password,$Gender,$Class)
    {
        if($this->account_model->Add($inaccountname,$password,$Gender,$Class)!=-1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //find is this account exist
    public function login($inaccountname,$password)
    {
        $this->id=$this->account_model->LoginCheck($inaccountname,$password);
        if($this->id!=-1)
        {
            $this->account_name=$inaccountname;
            $_SESSION[$inaccountname]=$this;
            $_SESSION['$inaccountname']=$inaccountname;
            return TRUE;
        }
        else
        {
            $this->account_name="";
            return FALSE;
        }
    }
    public function logout()
    {
        unset($_SESSION[$this->account_name]);
        unset($_SESSION['$inaccountname']);
    }
    public function get_account_name()
    {
        return $this->account_name;
    }
    public function __construct()
    {
        $this->account_model=new AccountModel();
        $this->account_name="";
    }
    //add money元
    public function add_DaSaBi($money)
    {
        if($this->account_name!="")
        {
            if($this->account_model->StoreDaSaBi($account_name,$money)!=-1)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    //take money元
    public function take_DaSaBi($money)
    {
        if($this->account_name!="")
        {
            if($this->account_model->StoreDaSaBi($account_name,$money)!=-1)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    //add new friend
    public function add_friend($id)
    {
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
//logout
if((isset($_POST['dm'])&&isset($_POST['un'])&&(!isset($_POST['gd']))))
{
    $name=$_POST['un'];
    if(isset($_SESSION[$name]))
    {
        $_SESSION[$name]->logout();
        echo "bye";
    }
    else
        echo "not exist";
}
//register 
elseif(isset($_POST['dm'])&&isset($_POST['pw']))
{
    $name=$_POST['un'];
    $password=$_POST['pw'];
    $department=$_POST['dm'];
    $gender=$_POST['gd'];
    $newAccount=new Account();
    if($newAccount->register($name,$password,$gender,$department)==TRUE)
        echo "AC";
    else
        echo "";
}
//login
elseif(isset($_POST['un'])&&isset($_POST['pw']))
{
    $username=$_POST['un'];
    $password=$_POST['pw'];
    $newAccount= new Account();
    if($newAccount->login($username,$password)==TRUE)
        echo "AC";
    else
        echo "";
}
//add friend
elseif(isset($_POST['un'])&&isset($_POST['id']))
{
    $name=$_POST['un'];
    $id=$_POST['id'];
    if(isset($_SESSION[$name]))
    {
        if($_SESSION[$name]->add_friend($id)==TRUE)
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
//detect the name duplicate
elseif(isset($_POST['un']))
{
    $username=$_POST['un'];
    $newAccount=new Account();
    if($newAccount->detect_name($username)==-1)
        echo "use";
    else
        echo "";
}
?>