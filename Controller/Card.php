<?php session_start();?>
<?php
require('../Model/AccountModel.php');

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
        if($this->account_name!=""&&($this->account_model->UseDaSaBi($this->account_name,10)!=-1))
        {
            $card=$this->account_model->RandomChoose($this->account_name);
            $json=array(
                'Accoount'=>$card['Account'],
                'Gender'=>$card['Gender'],
                'Class'=>$card['Class']
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
if(isset($_POST['un']))
{
    $username=$_POST['un'];
    if(isset($_SESSION[$username]))
    {
        $newCard=new Card($username);
        return $newCard->choose_a_people();
    }
    else
    {
        $json['wrong']=1;
        return json_encode($json);//something wrong
    }
}
?>