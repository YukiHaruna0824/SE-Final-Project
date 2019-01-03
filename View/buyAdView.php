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
        /*$.ajax({
            type : "POST",
            url : "../Controller/AD.php",
            data : {
                
            },
            dataType : 'json'
        }).done(function(data){
            let currentPrice = 123;//接收當前廣告標價
            $("#currentprice").text(currentPrice);

        }).fail(function(jqXHR, textStatus, errorThrown) {
				//失敗的時候
				alert("有錯誤產生，請看 console log");
				console.log(jqXHR.responseText);
		});*/

        /*$(".login").submit(function(){
			$.ajax({
				type : "POST",
				url : "../Controller/AD.php",
				data : {
                    p : $("#price").val(),
				},
				dataType : 'html'
			}).done(function(data){
				window.location.href = "HomeView.php"; //跳到文章頁面
			}).fail(function(jqXHR, textStatus, errorThrown) {
				alert("有錯誤產生，請看 console log");//失敗的時候
				console.log(jqXHR.responseText);
			});
			return false;
		});*/

        $(".login").submit(function(){
			console.log($("#file").val());
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
				<h1 class="text-center">購買廣告</h1>
			</div>
			<br>
			<br>
            <form class="Ad">
                <div class="form-group">
                    <label for="currentprice">當前廣告標價</label>
                    <h1 id="currentprice"></h1>
                </div>
                <div class="form-group">
                    <label for="price">標價</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="file">上傳廣告</label>
                    <input type="file" id="file" name="file" required>
                </div>
                <button type="submit" class="b-list__filter__expert">
                    購買
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