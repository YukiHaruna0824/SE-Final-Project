<!DOCTYPE html>
<head>
	<title>台科交友網站</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="gamer/forum.css">
	<link rel="stylesheet" href="gamer/basic.css">
	<script src="jquery/jquery.min.js"></script>
	<script src="bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
</head>

<script>
	$(document).ready(function(data){
		var urlVar = window.location.search.substring(1).split("&");
		var i,tmpVal,tmpID,tmpName = "test";
		for(i=0;i<urlVar.length;i++){
			tmpVal = urlVar[i].split("=");
			if(tmpVal[0]=="name"){
				tmpName = tmpVal[1];
			}
		}
		var isRun = false;
		
		$(".login").submit(function(){
			if(isRun) return false;
			isRun = true;
			$.ajax({
				type : "POST",
				url : "../Controller/GroupAccount.php",
				data : {
				  gn : $("#title").val(),
				},
				dataType : 'html'
			}).done(function(data){
                console.log(data);
				if(data == "AC")
				{
				  alert("新增成功");
				}
				else
				{
				  alert("新增失敗");
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
				alert("有錯誤產生，請看 console log");//失敗的時候
				console.log(jqXHR.responseText);
			});
			return false;
		});
	});
</script>

<html>
	<div class="content">
      <div class="container">
        <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
        <div class="row">
          <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
          <div class="col-xs-12 col-sm-4 col-sm-offset-4">
			<div class="jumbotron">
				<h1 class="text-center">新增群組</h1>
			</div>
			<br>
			<br>
            <form class="login">
              <div class="form-group">
                <label for="title">群組名稱</label>
                <input type="text" class="form-control" id="title" name="title" required>
              </div>
              <button type="submit" class="b-list__filter__expert">
                新增
              </button>
            </form>
						<br>
						<button onclick="history.back()" class="b-list__filter__expert">
                返回文章頁面
            </button>
          </div>
        </div>
      </div>
    </div>
</html>