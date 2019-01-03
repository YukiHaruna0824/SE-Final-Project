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


//有檔案名稱進入
if(isset($_FILES['file']['name']))
{
    //檢查是否為JPG,JPEG,PNG
    if($_FILES['file']['type'] == "image/png" || $_FILES['file']['type'] == "image/jpg" || $_FILES['file']['type'] == "image/jpeg"){
        
    }else{
        echo '<script>alert("廣告只接受JPG,JPEG,PNG形式");window.location.href = "../View/buyAdView.php"</script>';
    }
}
else
{
    echo '<script>alert("查無檔案，點擊確定返回");window.location.href = "../View/buyAdView.php"</script>';
}

?>