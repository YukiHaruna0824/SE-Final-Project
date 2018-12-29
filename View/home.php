<!DOCTYPE html>
<html lang="zh-TW">
<script>
	// $(document).ready(function(){
		// console.log(123);
		// $('[id="name"]').click(function(){
			// console.log(123);
			// var txt = document.getElementById("pp");
			// txt.innerHTML = "Hello <b>world!</b>";
		// });
		// $('[id="article"]').click(function(){
			// var txt = document.getElementById("pp");
			// txt.innerHTML = "world!</b>";
		// });
	// });
</script>

<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="gamer/forum.css">
	<link rel="stylesheet" href="gamer/basic.css">
	<script src="jquery/jquery.min.js"></script>
	<script src="bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
</head>
	
<body>

<div class="container-fluid">
  <h1>Hello World!</h1>
  <p>Resize the browser window to see the effect.</p>
  <p>The columns will automatically stack on top of each other when the screen is less than 768px wide.</p>
  <div class="row">
    <div class="col-sm-4" style="background-color:lavender;">.col-sm-4</div>
    <div class="col-sm-4" style="background-color:lavenderblush;">.col-sm-4</div>
    <div class="col-sm-4" style="background-color:lavender;">.col-sm-4</div>
  </div>
</div>

</br>

<div class="container"> 
	<div id="main">
		<ul class="b-tags">
			<li class="b-tags__item">
				<a href="#抽卡">抽卡</a>
			</li>
		</ul>
		<div class="b-list-wrap">
			<table class="b-list">
				<tbody>
					<tr class="b-list__head">
						<td>使用者名稱</td>
						<td>文章</td>
					</tr>
					<!--取得文章資料-->
					<?php
					
					for($i=0;$i<20;$i++){
						echo "
							<tr class=\"b-list__row\">
								<td class=\"b-list__account\" id=\"name\">
									<a href=\"#名字\" class=\"b-list__account__user\">名字</a>
								</td>
								<td class=\"b-list__main\" id=\"article\">
									<a href=\"#文章\" class=\"b-list__main__title\">文章名稱</a>
								</td>
							</tr>";
					}
					?>
			
				</tbody>
			</table>
		</div>
	</div>
</div>	

<!--
<form name = "form" method = "POST" action = "back.php">
	<input type = "text" name = "front" /><br>
	<input type = "submit" value = "123" />
</form>
-->

</body>
</html>
