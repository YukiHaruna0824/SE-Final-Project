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
    private $commet_model;
    //外面要確保這個ACCOUNT NAME有存在
    public function __construct($inaccountname)
    {
        $this->article_model=new ArticleModel();
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
        $storage=$_SESSION['grouparticlelist'];
        $storage=json_decode($storage,true);
        if($storage['current']==0)
        {
            return json_encode (null);
        }
        $storage['current']-=1;
        $data=$storage[$storage['current']];
        $_SESSION['grouparticlelist']=json_encode($storage);
        return $data;
    }
    //取得下一頁
    public function get_next_page()
    {
        $storage=($_SESSION['grouparticlelist']);
        $storage=json_decode($storage,TRUE);
        //getthing
        if(isset($storage[$storage['current']+1]))
        {
            $storage['current']+=1;
            $data=$storage[$storage['current']];
            $_SESSION['grouparticlelist']=json_encode($storage);
            return $data;
        }
        else
        {
            return json_encode (null);
        }
    }
    public function first_get_into_main()
    {
        //擷取所有的貼文
        $storage=null;
        $storage['current']=0;
        $storage['count']=0;
        $count=0;
        $json;
        $allartical=$this->article_model->choseGroupAllArticle($_SESSION['groupname']);//
        if(!is_null($allartical))
        {
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
        else
        {
            return json_encode (null);
        }
        if(!is_null($json))
        {
            $storage[$storage['count']]=json_encode($json);
            $count=0;
            $storage['count']+=1;
        }
        if(is_null($storage))
        {
            return json_encode (null);
        }
        $_SESSION['grouparticlelist']=json_encode($storage);
        return $storage[0];
    }
    public function addarticle($title,$content)
    {
        //add article
        $name=$_SESSION['groupname'];
        if($this->article_model->Add($name,htmlentities($title),htmlentities($content))!=-1)
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
    public function support_ones_article($id,$name)
    {
        $tmp=new ThumbUpModel();
        if($tmp->Add($id,$_SESSION['$inaccountname'])!=-1)
        {
            $coin=new AccountModel();
            $coin->StoreDaSaBi($name,20);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    //對id文章退讚 acricle id
    public function unsupport_ones_article($id,$name)
    {
        $tmp=new ThumbUpModel();
        if($tmp->Delete($id,$_SESSION['$inaccountname'])==1)
        {
            $coin=new AccountModel();
            $coin->UseDaSaBi($name,20);
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
                    'Content'=> $rowll["Content"],
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
                'Content'=> ($row["Content"]),
                'commit'=>($commitjson),
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
        if($this->commet_model->Add($id,htmlentities($content),$inaccountname)==1)
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
        
        echo json_encode(null);
    }
}
//delete thumb
elseif(isset($_POST['na'])&&isset($_POST['id']))
{
    $username=$_POST['na'];
    $id=$_POST['id'];//article id
    if(isset($_SESSION['$inaccountname']))
    {
        $newArticlelist=new Article($_SESSION['$inaccountname']);
        if($newArticlelist->unsupport_ones_article($id,$username)==TRUE)
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
elseif(isset($_POST['na'])&&isset($_POST['id']))
{
    $username=$_POST['na'];
    $id=$_POST['id'];//article id
    if(isset($_SESSION['$inaccountname']))
    {
        $newArticlelist=new Article($_SESSION['$inaccountname']);
        if($newArticlelist->support_ones_article($id,$username)==TRUE)
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
        echo json_encode (null);
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
        echo json_encode (null);
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
        echo json_encode (null);
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
        echo json_encode (null);
    }
}
?>