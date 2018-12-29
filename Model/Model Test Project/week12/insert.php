<?php
	//載入 db.php 檔案，讓我們可以透過它連接資料庫
	require_once 'db.php';
	
?>
<!DOCTYPE html>
<html lang="zh-TW">
	<head>
		<title>新增資料 INSERT，新增資料到資料表</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!-- 給行動裝置或平板顯示用，根據裝置寬度而定，初始放大比例 1 -->	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- 載入 bootstrap 的 css 方便我們快速設計網站-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
		
	</head>

	<body>
		<!-- div 類別為 container-fluid 代表是滿版的區塊 -->
		<div class="container-fluid">
			<!-- 建立第一個 row 空間，裡面準備放格線系統 -->
			<div class="row">
				<!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
				<div class="col-xs-12">
					<h2 class="text-center">INSERT 新增</h2>
					新增一筆資料，到user資料表中
					<pre>INSERT INTO `user` (`username`, `password`, `user`) VALUE ('thor', 'hammer', '索爾');</pre>
					使用php執行的寫法
					<pre>//載入 db.php 檔案，讓我們可以透過它連接資料庫
require_once 'db.php';

//將查詢語法當成字串，記錄在$sql變數中
$sql = "INSERT INTO `user` (`username`, `password`, `name`) VALUE ('thor', 'hammer', '索爾');";

//用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
$result = mysqli_query($sql);

//如果有異動到數量，代表有跟新資料;
if(mysqli_affected_rows($link) > 0)
{
  $new_id = mysqli_insert_id($link);
  echo "執行成功，新增後的 id 為 {$new_id}";
}
elseif(mysqli_affected_rows($link) == 0)
{
  echo "無資料更新";
}
else
{
  echo  "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($link);
}
</pre>
					<h3>執行結果</h3>
					<div class="well well-sm">
						<?php
						//將查詢語法當成字串，記錄在$sql變數中
						$sql = "INSERT INTO `user` (`username`, `password`, `name`) VALUE ('thor', 'hammer', '索爾');";
						
						//用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
						$result = mysqli_query($link, $sql);
						
            //如果有異動到數量，代表有跟新資料;
            if(mysqli_affected_rows($link) > 0)
            {
              $new_id = mysqli_insert_id($link);
              echo "執行成功，新增後的 id 為 {$new_id}";
            }
            elseif(mysqli_affected_rows($link) == 0)
            {
              echo "無資料新增";
            }
            else
            {
              echo  "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($link);
            }
						
						?>
					</div>
					
				</div>
			</div>
		</div>
		<?php 
		//結束mysql連線
		mysqli_close($link);
		?>
	</body>
</html>
