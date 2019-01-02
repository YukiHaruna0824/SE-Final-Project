<!DOCTYPE html>
<html lang="zh-TW">
  <head>
    <title>台科交友網站</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- 給行動裝置或平板顯示用，根據裝置寬度而定，初始放大比例 1 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 載入 bootstrap 的 css 方便我們快速設計網站-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../View/css/style.css"/>
    <link rel="shortcut icon" href="images/favicon.ico">
  </head>

  <body>
    <!-- 頁首 -->
    <?php
      include_once 'MenuView.php';
    ?>
    <!-- 網站內容 -->
    <div class="content">
      <div class="container">
        <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
        <div class="row">
          <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
          <div class="col-xs-12 col-sm-4 col-sm-offset-4">
          	<h1>登入</h1>
            <form class="login">
              <div class="form-group">
                <label for="username">帳號</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="請輸入帳號" required>
              </div>
              <div class="form-group">
                <label for="password">密碼</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼" required>
              </div>
              <button type="submit" class="btn btn-default">
                登入
              </button>

              <a href="RegisterView.php">
                註冊帳號
              </a>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- 在表單送出前，檢查確認密碼是否輸入一樣 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
      //當文件準備好時，
      $(document).on("ready", function() {
				//當表單 sumbit 出去的時候
			$("form.login").on("submit", function(){
					$.ajax({
            type : "POST",
            url : "../Controller/Account.php",
            data : {
              un : $("#username").val(), //使用者帳號
              pw : $("#password").val() //使用者密碼
            },
            dataType : 'html' //設定該網頁回應的會是 html 格式
          }).done(function(data) {
            //成功的時候
            if(data == "AC")
            {
              alert("登入成功，請按確認後登入");
              window.location.href = "HomeView.php"; //跳到文章頁面
            }
            else
            {
              alert("登入失敗，請確認帳號密碼");
            }
            
          }).fail(function(jqXHR, textStatus, errorThrown) {
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(jqXHR.responseText);
          });
	        //回傳 false 為了要阻止 form 繼續送出去。由上方ajax處理即可
          return false;
				});
      });
    </script>
  </body>
</html>
