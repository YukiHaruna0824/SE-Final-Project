<?php session_start();?>
<?php
require_once('../Model/ArticleModel.php');
require_once('./Account.php');

class Article
{
    private $article_model;
    private $thisaccount;
    private $level;
    //外面要確保這個ACCOUNT NAME有存在
    public function __construct($inaccountname)
    {
        $this->article_model=new ArticleModel();
        $this->thisaccount=$_SESSION[$inaccountname];
        $this->level=1;
    }
    public function get_friend_article($number)
    {
        //return the number of the friend, group article
        $oldlevel=$this->level-1;
        $count=0;
        $json;
        while(($count<$number)&&($oldlevel!=($this->level-1)))
        {
            if($this->level==1)
            {
                //me
                $allartical=$this->article_model->allRange($this->thisaccount->get_account_name());
                while(($count<$number)&&($row=$allartical->fetch_assoc()))
                {
                    $json[count]=$row;
                    $count+=1;
                }
            }
            elseif($this->level==2)
            {
                //friend 等friendDB做完
            }
            elseif($this->level==3)
            {
                //group 等groupDB做完
            }
            $this->level=($this->level+1);
            $this->level=($this->level%4);
        }
        $json['count']=$count;
        return $json;
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
    public function get_article($date)
    {
        //取得文章
        $allartical=$this->article_model->allRange($this->thisaccount->get_account_name());
        $json;
        while($row=$allartical->fetch_assoc())
        {
            if($row['DeliveryDate']==$date)
            {
                $json=$row;
                break;
            }
        }
        return $json;
    }
    //評論文章
    public function comment_article($json)
    {
        if($this->article_model->UpdateContent($json['id'],$json['content'])==1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
/*//get friend and group and me aticle
if(isset($_POST['un']))
{
    $username=$_POST['un'];
    $number=$_POST['am'];//how much amount want to take
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        $json=$newArticlelist->get_friend_article($number);
    }
    else
    {
        //return false
    }
}*/
?>