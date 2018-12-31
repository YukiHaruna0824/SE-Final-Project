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
require_once('../Model/CommetModel.php');
require_once('../Model/FriendModel.php');
require_once('./Account.php');

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
        'count':0//幾組，會停留在最上面那組+1組
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
        $storage=json_decode($storage,true);
        if($storage['current']==0)
        {
            $tmp=array(
                "null"=>1
            );
            return json_encode($tmp);
        }
        $storage['current']-=1;
        $data=$storage[$storage['current']];
        $_SESSION['mainpage']=json_encode($storage);
        return $data;
    }
    //取得下一頁
    public function get_next_page()
    {
        $storage=($_SESSION['mainpage']);
        $storage=json_decode($storage,TRUE);
        //getthing
        if(isset($storage[$storage['current']+1]))
        {
            $storage['current']+=1;
            $data=$storage[$storage['current']];
            $_SESSION['mainpage']=json_encode($storage);
            return $data;
        }
        else
        {
            $tmp=array(
                "null"=>1
            );
            return json_encode($tmp);
        }
    }
    public function first_get_into_main()
    {
        $storage=null;
        $storage['current']=0;
        $storage['count']=0;
        $count=0;
        $json;
        $havething=0;
        //me
        $allartical=$this->article_model->choseAccountAllArticle($_SESSION['$inaccountname']);
        if(!is_null($allartical))
        {
            $havething=1;
            while($row=$allartical->fetch_assoc())
            {
                $accounttmp=new AccountModel();
                $ownerid=$accounttmp->GetID($row["Owner"]);
                $tmp=array(
                    'id'=>$row["id"],
                    'Ownerid'=>$ownerid,
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
        //friend
        $friend=new FriendModel();
        $allfriend = $friend->FindAllFriend($_SESSION['$inaccountname']);
        if(!is_null($allfriend))
        {
            $havething=1;
            while (($allfriend!=-1)&&($row = $allfriend->fetch_assoc()))
            {
                $tmpaccountmodel=new AccountModel(); 
                $allartical=$this->article_model->choseAccountAllArticle($tmpaccountmodel->GetAccount($row['id']));
                if(!is_null($allartical))
                {
                    while(($count<$number)&&($row=$allartical->fetch_assoc()))
                    {
                        $accounttmp=new AccountModel();
                        $ownerid=$accounttmp->GetID($row["Owner"]);
                        $tmp=array(
                            'id'=>$row["id"],
                            'Ownerid'=>$ownerid,
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
            }
        }
        if($havething==0)
        {
            $tmp=array(
                "null"=>1
            );
            return json_encode($tmp);
        }
        if($json!=null)
        {
            $storage[$storage['count']]=json_encode($json);
            $count=0;
            $storage['count']+=1;
        }
        //group 等groupdb用好
        if($storage==null)
        {
            $tmp=array(
                "null"=>1
            );
            return json_encode($tmp);
        }
        $_SESSION['mainpage']=json_encode($storage);
        return $storage[0];
    }
    //add article
    public function addarticle($title,$content)
    {
        $name=$_SESSION['$inaccountname'];
        if($this->article_model->Add($name,$title,$content)!=-1)
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
        if($tmp->Add($id,$_SESSION['$inaccountname'])!=-1)
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
        if($tmp->Delete($id,$_SESSION['$inaccountname'])==1)
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
        $commettmp=new CommetModel();
        $allcommet=$commettmp->GetAllComment($id);
        $commitjson=null;
        $count=0;
        if(!is_null($allcommet))
        {
            while(($rowll=$allcommet->fetch_assoc()))
            {
                $tmp=array(
                    'Owner'=> $rowll["Owner"],
                    'Title'=> $rowll["Content"],
                    'DeliveryDate'=>$rowll["DeliveryDate"]
                );
                $commitjson[$count]=$tmp;
                $count+=1;
            }
        }
        $allartical=$this->article_model->Choose($id);
        if(!is_null($allartical))
        {
            $row=$allartical->fetch_assoc();
            $thumbtmp=new ThumbUpModel();
            $json=array(
                'Owner'=> $row["Owner"],
                'Title'=> $row["Title"],
                'Content'=> $row["Content"],
                'commit'=>json_encode($commitjson),
                'thumb'=>$thumbtmp->GetNumberOfThumbUp($id),
                'DeliveryDate'=>$row["DeliveryDate"]
            );
            return json_encode($json);
        }
    }
    //取得文章id
    public function get_article_id($title)
    {
        $id=$this->article_model->ChooseByTitleid($title);
        if($id!=-1)
            return $id;
        else
            return -1;
    }
    //評論文章
    public function comment_article($id,$content,$inaccountname)
    {
        if($this->commet_model->Add($id,$content,$inaccountname)==1)
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
if(isset($_POST['title']))
{
    $username=$_SESSION['$inaccountname'];
    //echo $datajson;
    if(isset($_SESSION[$username]))
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
    }
    else
    {
        echo "WN";//wrongname
    }
}
//commit
elseif(isset($_POST['content'])&&isset($_POST['id']))
{
    $username=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$username]))
    {
        $newArticlelist=new Article($username);
        if($newArticlelist->comment_article($_POST['id'],$_POST['content'],$username)==TRUE)
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
        $json=$newArticlelist->get_article((int)$id);
        echo $json;
    }
    else
    {
        
        echo null;
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
        echo null;
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
        echo null;
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
        echo null;
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
        echo null;
    }
}
?>