<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
require_once('./Account.php');
require_once('../Model/AccountModel.php');
require_once('../Model/FriendModel.php');

class Card
{
    private $account_name;
    private $account_model;
    //外面要確保這個ACCOUNT NAME有存在
    public function __construct($inaccountname)
    {
        $this->account_model=new AccountModel();
        $this->account_name=$inaccountname;
    }
    
    //get random people not yourself
    public function choose_a_people()
    {
        if($this->account_name!=""/*&&($this->account_model->UseDaSaBi($this->account_name,10)!=-1)*/)
        {
            $card=($this->account_model->RandomChoose($this->account_name))->fetch_assoc();
            $json=array(
                'Account'=>$card["Account"],
                'Gender'=>$card["Gender"],
                'Class'=>$card["Class"]
            );
            return json_encode($json);
        }
        else
        {
            $json['wrong']=1;
            return json_encode($json);//something wrong
        }
    }
}
//getnewcard
$username=$_SESSION['$inaccountname'];
$newCard=new Card($username);
echo $newCard->choose_a_people();
?>