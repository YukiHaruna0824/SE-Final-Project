<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
require_once('../Model/ADModel.php');
class AD
{
    private $ADModel;
    public function __construct()
    {
        $ADModel=new ADModel();
    }
    //add AD with title, content
    public function addAD($title, $content)
    {
        if($thie->ADModel->Add($title,$content,$_SESSION['$inaccountname'])!=-1)
            return TRUE;
        else
            return FALSE;
    }
    //get AD
    public function getAD()
    {
        $result = $this->ADModel->ListAllAD();
        $data;
        $count=0;
        if(!is_null($result))
        {
            while ($row = $result->fetch_assoc()) 
            {
                $tmp=array(
                    "owner"=>$row["Owner"],
                    "title"=>$row["Title"],
                    "content"=>$row["Content"]
                );
                $data[$count]=$tmp;
                $count+=1;
            }
            $ones=rand(0,($count-1));
            return json_encode($data[$ones]);
        }
        else
            return json_encode(null);
    }
}
//add AD
if(isset($_POST['tit'])&&isset($_POST['con']))
{
    $username=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$username]))
    {
        $newAD=new AD();
        if($newAD->addAD($_POST['tit'],$_POST['con'])==TRUE)
            return "AC";
        else
            return "ER";
    }
    else
    {
        return "WN";
    }
}
//get one ad
elseif(isset($_POST['rad']))//隨便給rad
{
    $username=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$username]))
    {
        $newAD=new AD();
        echo $newAD->getAD();
    }
    else
    {
        echo json_encode (null);
    }
}
?>