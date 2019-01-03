<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>

<?php
require_once('../Model/ADModel.php');
require_once('../Model/AccountModel.php');
class AD
{
    private $AD_Model;
    public function __construct()
    {
        $this->AD_Model=new ADModel();
    }
    //add AD with title, content
    public function addAD($file, $price,$filesta)
    {
        if($price==0)
            return FALSE;
        $topmoney=$this->AD_Model->GetCurrentDaSaBi();
        $tmpaccount=new AccountModel();
        if(($this->AD_Model->Add("Title", "Content", "owner", $price)!=-1)&&($tmpaccount->UseDaSaBi($_SESSION['$inaccountname'],$price)!=-1))
        {
            move_uploaded_file($file,"../AD/output.jpg");
            return TRUE;
        }
        else
            return FALSE;
    }
    //get AD
    public function getcurrentcoin()
    {
        if($this->AD_Model->GetCurrentDaSaBi()==-1)
            return 0;
        else
            return $this->AD_Model->GetCurrentDaSaBi();
    }
}

if(isset($_POST['get']))
{
    $name=$_SESSION['$inaccountname'];
    if(isset($_SESSION[$name]))
    {
        $newAD=new AD();
        $json=array(
            "coin"=>$newAD->getcurrentcoin()
        );
        echo json_encode($json);
    }
}
//有檔案名稱進入
elseif(isset($_FILES['file']['name'])&&isset($_POST['price']))
{
    //檢查是否為JPG,JPEG,PNG
    if($_FILES['file']['type'] == "image/jpg" || $_FILES['file']['type'] == "image/jpeg")
    {
        $name=$_SESSION['$inaccountname'];
        if(isset($_SESSION[$name]))
        {
            $newAD=new AD();
            if($newAD->addAD($_FILES["file"]["tmp_name"],$_POST['price'],$_FILES['file']['type'])==FALSE)
                echo '<script>alert("台科幣不足或是出價過低");window.location.href = "../View/buyAdView.php"</script>';
            else
                echo '<script>alert("購買成功");window.location.href = "../View/buyAdView.php"</script>';
        }
    }else{
        echo '<script>alert("廣告只接受JPG,JPEG形式");window.location.href = "../View/buyAdView.php"</script>';
    }
}
else
{
    echo '<script>alert("查無檔案，點擊確定返回");window.location.href = "../View/buyAdView.php"</script>';
}

?>