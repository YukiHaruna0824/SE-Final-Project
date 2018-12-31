<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
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
    private $commet_model;
    //外面要確保這個ACCOUNT NAME有存在
    public function __construct($inaccountname)
    {
        $this->article_model=new ArticleModel();
        $this->thisaccount=$_SESSION[$inaccountname];
        $this->level=1;
        $this->commet_model=new CommetModel();
    }
    /*session的格式就是
    json{
        'count':0//幾組，會停留在最上面那組
        'current':0//現在在第幾頁
        0:json{
            0:json{
                'id'=> $row["id"],
                'Owner'=> $row["Owner"],
                'Title'=> $row["Title"],
            }
            .
            .
            .
            20:json{
                'id'=> $row["id"],
                'Owner'=> $row["Owner"],
                'Title'=> $row["Title"],
            }
        }
        .
        .
        .
    }
    */
    //取得上一頁
    public function get_back_page()
    {
        $storage=$_SESSION['mainpage'];
        if($storage['current']==0)
        {
            return json_encode(array('null'=>1));
        }
        $storage['current']-=1;
        $data=$storage[$storage['current']];
        $_SESSION['mainpage']=$storage;
        return $data;
    }
    //取得下一頁
    public function get_next_page()
    {
        $storage=$_SESSION['mainpage'];
        //getthing
        if($storage['count']>$storage['current'])
        {
            $storage['current']+=1;
            $data=$storage[$storage['current']];
            $_SESSION['mainpage']=$storage;
            return $data;
        }
        if($storage['count'] == $storage['current'])
        {
            return json_encode(array('null'=>1));
        }
    }
    public function first_get_into_main()
    {
        $storage=null;
        $storage['current']=0;
        $storage['count']=0;
        $count=0;
        $json;
        //me
        $allartical=$this->article_model->choseAccountAllArticle($this->thisaccount->get_account_name());
        while($row=$allartical->fetch_assoc())
        {
            $tmp=array(
                'id'=> $row["id"],
                'Owner'=> $row["Owner"],
                'Title'=> $row["Title"],
            );
            $json[$count]=json_encode($tmp);
            $count+=1;
            if($count==20)
            {
                $storage[$storage['count']]=json_encode($json);
                $count=0;
                $storage['count']+=1;
                $json=null;
            }
        }
        //friend
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
                $json[$count]=json_encode($tmp);
                $count+=1;
                if($count==20)
                {
                    $storage[$storage['count']]=json_encode($json);
                    $count=0;
                    $storage['count']+=1;
                    $json=null;
                }
            }
        }
        //group 等groupdb用好
        if($storage==null)
            return json_encode(array('null'=>1));
        $_SESSION['mainpage']=json_encode($storage);
        return $storage[0];
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
        $thumbtmp=new ThumbUpModel();
        $json=array(
            'id'=> $row["id"],
            'Owner'=> $row["Owner"],
            'Title'=> $row["Title"],
            'Content'=> $row["Content"],
            'commit'=>$this->commet_model->GetAllComment($id),
            'thumb'=>$thumbtmp->GetNumberOfThumbUp($id)
        );
        return json_encode($json);
    }
    //取得文章id
    public function get_article_id($title)
    {
        $allartical=$this->article_model->ChooseByTitle($title);
        $row=$allartical->fetch_assoc();
        return $row["id"];
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
if(isset($_POST['data']))
{
    $username=$_SESSION['$inaccountname'];
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
//commit
elseif(isset($_POST['com']))
{
    $username=$_SESSION['$inaccountname'];
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
elseif(isset($_POST['id'])&&isset($_POST['get']))//get 亂給直
{
    $username=$_SESSION['$inaccountname'];
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
elseif(isset($_POST['us'])&&isset($_POST['id']))//us 亂給直
{
    $username=$_SESSION['$inaccountname'];
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
elseif(isset($_POST['su'])&&isset($_POST['id']))//su 亂給直
{
    $username=$_SESSION['$inaccountname'];
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
elseif(isset($_POST['id']))
{
    $username=$_SESSION['$inaccountname'];
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
//first main page
elseif(isset($_POST['mp']))//mp 亂給直
{
    $username=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        $json=$newArticlelist->first_get_into_main();
        echo $json;
    }
    else
    {
        $json['null']=0;
        echo json_encode($json);
    }
}
//next page
elseif(isset($_POST['np']))//np 亂給直
{
    $username=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        $json=$newArticlelist->get_next_page();
        echo $json;
    }
    else
    {
        $json['null']=0;
        echo json_encode($json);
    }
}
//back page
elseif(isset($_POST['bp']))//bp 亂給直
{
    $username=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        $json=$newArticlelist->get_back_page();
        echo $json;
    }
    else
    {
        $json['null']=0;
        echo json_encode($json);
    }
}
elseif(isset($_POST['title']))
{
    $title=$_POST['title'];
    $username=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        $tmp=array(
            'id'=>$newArticlelist->get_article_id($title)
        );
        echo json_encode($tmp);
    }
    else
    {
        $json['null']=0;
        echo json_encode($json);
    }
}
?>