<?php session_start();?>
<?php
require_once('../Model/ArticleModel.php');
require_once('../Model/AccountModel.php');
require_once('./AccountModel.php');
require_once('./CommetModel.php');

class Article
{
    private $article_model;
    private $thisaccount;
    private $level;
    private $commet_model;
    //外面要確保這個ACCOUNT NAME有存在
    public function __construct($inaccountname)
    {
        $this->article_model=new ArticleModel();
        $this->thisaccount=$_SESSION[$inaccountname];
        $this->level=1;
        $this->commet_model=new CommetModel();
    }
    public function get_friend_article($number)
    {
        //return the number of the friend, group article
        $oldlevel=$this->level-1;
        $count=0;
        $json;
        while(($count<$number)&&($oldlevel!=($this->level-1)))
        {
            //me
            if($this->level==1)
            {
                $allartical=$this->article_model->choseAccountAllArticle($this->thisaccount->get_account_name());
                while(($count<$number)&&($row=$allartical->fetch_assoc()))
                {
                    $tmp=array(
                        'id'=> $row["id"],
                        'Owner'=> $row["Owner"],
                        'Title'=> $row["Title"],
                    );
                    $json[count]=json_encode($tmp);
                    $count+=1;
                }
            }
            //friend 等friendDB做完
            elseif($this->level==2)
            {
                $allfriend = $friend->FindAllFriend($this->thisaccount->get_account_name());
                while ($row = $allfriend->fetch_assoc()) 
                {
                    $tmpaccountmodel=new AccountModel(); 
                    $allartical=$this->article_model->choseAccountAllArticle($tmpaccountmodel->GetAccount($row['id']));
                    while(($count<$number)&&($row=$allartical->fetch_assoc()))
                    {
                        $tmp=array(
                            'id'=> $row["id"],
                            'Owner'=> $row["Owner"],
                            'Title'=> $row["Title"],
                        );
                        $json[count]=json_encode($tmp);
                        $count+=1;
                    }
                }
            }
            elseif($this->level==3)
            {
                //group 等groupDB做完
            }
            $this->level=($this->level+1);
            $this->level=($this->level%4);
        }
        $json['count']=$count;
        return json_encode($json);
    }
    //add article
    public function addarticle($json)
    {
        if($this->article_model->Add($this->thisaccount->get_account_name(),$json['title'],$json['content'])!=-1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //delete article
    public function deletearticle($id)
    {
        if($this->article_model->DeleteAritcle($id)!=-1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    public function support_ones_article($id)
    {
        //對id文章按讚
        $this->thisaccount->add_DaSaBi(20);
    }
    public function unsupport_ones_article($id)
    {
        //對id文章退讚
        $this->thisaccount->add_DaSaBi(-20);
    }
    //取得文章
    public function get_article($id)
    {
        $allartical=$this->article_model->Choose($id);
        $row=$allartical->fetch_assoc();
        $json=array(
            'id'=> $row["id"],
            'Owner'=> $row["Owner"],
            'Title'=> $row["Title"],
            'Content'=> $row["Content"],
            'commit'=>$this->commet_model->GetAllComment($id)
        );
        return json_encode($json);
    }
    //評論文章
    public function comment_article($json)
    {
        if($this->commet_model->CommetModel($json['id'],$json['content'],$this->thisaccount->get_account_name())==1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
if(isset($_POST['un'])&&isset($_POST['data']))
{
    $username=$_POST['un'];
    $datajson=$_POST['data'];//how much amount want to take
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        if($newArticlelist->addarticle($datajson)==TRUE)
        {
            echo "AC";
        }
        else
        {
            echo "ER";//can't edit
        }
    }
    else
    {
        echo "WN";//wrongname
    }
}
//get friend and group and me aticle
elseif(isset($_POST['un']))
{
    $username=$_POST['un'];
    $number=$_POST['am'];//how much amount want to take
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        $json=$newArticlelist->get_friend_article($number);
        return $json;
    }
    else
    {
        $json['count']=0;
        return json_encode($json);
    }
}
?>