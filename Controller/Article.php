<?php session_start();?>
<?php
require_once('../Model/ArticleModel.php');
require_once('../Model/AccountModel.php');
require_once('../Model/ThumbupModel.php');
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
            //friend
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
    public function addarticle($title,$content)
    {
        //if($this->article_model->Add($this->thisaccount->get_account_name(),$title,$content)!=-1)
        if($this->article_model->Add("test",$title,$content)!=-1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //delete article id
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
    //對id文章按讚 article id
    public function support_ones_article($id)
    {
        $tmp=new ThumbUpModel();
        if($tmp->Add($id,$this->thisaccount->get_account_name())!=-1)
        {
            $this->thisaccount->add_DaSaBi(20);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //對id文章退讚 acricle id
    public function unsupport_ones_article($id)
    {
        $$tmp=new ThumbUpModel();
        if($tmp->Delete($id,$this->thisaccount->get_account_name())==1)
        {
            $this->thisaccount->take_DaSaBi(20);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //取得文章 article id
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
//add new article
if(isset($_POST['un'])&&isset($_POST['title'])&&isset($_POST['content']))
{
	$newArticlelist=new Article($username);
	if($newArticlelist->addarticle($_POST['title'],$_POST['content'])==TRUE)
	{
		echo "AC";
	}
	else
	{
		echo "ER";//can't edit
	}
    // $username=$_POST['un'];
    // if(isset($_SESSION[$username]))
    // {
        // $newArticlelist=new Article($username);
        // if($newArticlelist->addarticle($_POST['title'],$_POST['content'])==TRUE)
        // {
            // echo "AC";
        // }
        // else
        // {
            // echo "ER";//can't edit
        // }
    // }
    // else
    // {
        // echo "WN";//wrongname
    // }
}
//commit
elseif(isset($_POST['un'])&&isset($_POST['com']))
{
    $username=$_POST['un'];
    $commitjson=$_POST['com'];//commit json
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        if($newArticlelist->comment_article($commitjson)==TRUE)
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
//get article
elseif(isset($_POST['un'])&&isset($_POST['id'])&&isset($_POST['get']))//get 亂給直
{
    $username=$_POST['un'];
    $id=$_POST['id'];//article id
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        $json=$newArticlelist->get_article($id);
        return $json;
    }
    else
    {
        $json['id']=-1;
        return json_encode($json);
    }
}
//delete thumb
elseif(isset($_POST['un'])&&isset($_POST['us'])&&isset($_POST['id']))//us 亂給直
{
    $username=$_POST['un'];
    $id=$_POST['id'];//article id
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        if($newArticlelist->unsupport_ones_article($id)==TRUE)
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
//make thumb
elseif(isset($_POST['un'])&&isset($_POST['su'])&&isset($_POST['id']))//su 亂給直
{
    $username=$_POST['un'];
    $id=$_POST['id'];//article id
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        if($newArticlelist->support_ones_article($id)==TRUE)
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
//delete article
elseif(isset($_POST['un'])&&isset($_POST['id']))
{
    $username=$_POST['un'];
    $id=$_POST['id'];//article id
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        if($newArticlelist->deletearticle($id)==TRUE)
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