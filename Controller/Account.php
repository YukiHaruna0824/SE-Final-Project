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
        if($this->account_model->Add($inaccountname,md5($password),$Gender,$Class)!=-1)
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
        $this->id=$this->account_model->LoginCheck($inaccountname,($password));
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
    //logout
    public function logout()
    {
        unset($_SESSION[$this->account_name]);
        unset($_SESSION['$inaccountname']);
    }
    //change password
    public function alter_password($password)
    {
        if($this->account_model->updatePassWord($_SESSION['$inaccountname'],$password))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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
    public function get_info_naco()
    {
        //get info
        $tmp=new AccountModel();
        $result = $tmp->find($_SESSION['$inaccountname']);
        $people=$result->fetch_assoc();
        $tmp=array(
            "un"=>$_SESSION['$inaccountname'],
            "co"=>$people["DaSaBi"]
        );
        return json_encode($tmp);
    }
    public function get_info_full()
    {
        $friend=new FriendModel();
        $friendtmpjson;
        $count=0;
        $allfriend = $friend->FindAllFriend($_SESSION['$inaccountname']);
        if(!is_null($allfriend))
        {
            while ($row = $allfriend->fetch_assoc())
            {
                $accounttmp=new AccountModel();
                $allinfo=$accounttmp->find($accounttmp->GetAccount($row["id"]));
                if(!is_null($allinfo))
                {
                    $tmp=array(
                        "username"=>$allinfo["Account"],
                        "gender"=>$allinfo["Gender"],
                        "Class"=>$allinfo["Class"],
                    );
                    $friendtmpjson[$count]=$tmp;
                    $count+=1;
                }
            }
        }
        $tmpmodel=new AccountModel();
        $result = $tmpmodel->find($_SESSION['$inaccountname']);
        $people=$result->fetch_assoc();
        $json=array(
            "username"=>$_SESSION['$inaccountname'],
            "gender"=>$people["Gender"],
            "Class"=>$people["Class"],
            "coin"=>$people["DaSaBi"],
            "friend"=>$friendtmpjson
        );
        return json_encode($json);
    }
}
//alter password
if(isset($_POST['ps']))
{
    $name=$_SESSION['$inaccountname'];
    $newpassword=$_POST['ps'];
    if(isset($_SESSION[$name]))
    {
        $newAccount=new Account();
        if($newAccount->alter_password($newpassword)==TRUE)
        {
            echo "AC";
        }
        else
        {
            echo "ER";
        }
    }
    else
    {
        echo "WN";
    }
}
//get all info
elseif(isset($_POST['getfullinfo']))
{
    $name=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$name]))
    {
        $newAccount=new Account();
        echo $newAccount->get_info_full();
    }
    else
    {
        echo json_encode(null);
    }
}
elseif(isset($_POST['naco']))
{
    $name=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$name]))
    {
        $newAccount=new Account();
        echo $newAccount->get_info_naco();
    }
    else
    {
        echo json_encode(null);
    }
}
//logout
elseif(isset($_POST['apple']))
{
    $name=$_SESSION['$inaccountname'];
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
elseif(isset($_POST['addfriend']))
{
    $name=$_SESSION['$inaccountname'];
    $friendname=$_POST['addfriend'];
    $tmpaccountmodel=new AccountModel();
    $id=$tmpaccountmodel->GetID($friendname);
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