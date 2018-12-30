<!DOCTYPE html>
<html lang="zh-TW">
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
	$(document).ready(function(data) {
		
		console.log(data.length);
		console.log(data);
		$("a").click(function(){
			var txt = $(this).attr("href");
			console.log(txt);
		});
	});
	
function nextPage() {
	jQuery.post('forum_next',{},
	function(data) {
		if(data == null){
			return;
		}
		$('.pagenow').each(function(){
			$(this).html(Number($(this).text())+1);
		});
	}, "json");
}
 
function prePage() {
	jQuery.post('forum_pre',{},
	function(data) {
		if(data == null){
			return;
		}
		$('.pagenow').each(function(){
			if(Number($(this).text())==1)
				return;
			$(this).html(Number($(this).text())-1);
		});
	}, "json");
}
</script>
	
<body>

<!--不會被覆蓋-->
<div class="TOP-bh">
	<input type="button" value="我想登出" style="float:right;width:10%">
</div>
<!--將頁面往下挪以免btn被蓋住-->
<div id="bh-banner" class="bh-banner"></div>
<!--主畫面-->
<div class="container"> 
	<div id="main">
		<p></p>
		<!--換頁-->
		<div class="b-pager pager">
			<div id="BH-pagebtn">
				<p class="BH-pagebtnA">
					<a href="javascript:void(0);" onclick="prePage();">上一页</a>
					<a class="pagenow">1</a>
					<a href="javascript:void(0);" onclick="nextPage();">下一页</a>
				</p>
			</div>
		</div>
		
		<!--btn-->
		<ul class="b-tags">
			<li class="b-tags__item">
				<a href="#抽卡">抽卡</a>
			</li>
		</ul>
		<!--文章區-->
		<div class="b-list-wrap">
			<table class="b-list">
				<tbody>
					<tr class="b-list__head">
						<td style="width: 135px;">使用者名稱</td>
						<td style="max-width: 600px;">文章</td>
					</tr>
					<form method="post" action>
						<!--取得文章資料-->
						<?php
						for($i=0;$i<20;$i++){
							echo "
								<tr class=\"b-list__row\">
									<td class=\"b-list__account\">
										<a href=\"test.php?id=".$i."&id2=".$i."\" class=\"b-list__account__user\"  id=\"name".$i."\">
											名字
										</a>
									</td>
									<td class=\"b-list__main\">
										<a href=\"article.php\" class=\"b-list__main__title\" id=\"article".$i."\">
											文章名稱文章名稱文章名稱文章名稱
										</a>
									</td>
								</tr>";
						}
						?>
					</form>
				</tbody>
			</table>
		</div>
		<!--換頁-->
		<div class="b-pager pager">
			<div id="BH-pagebtn">
				<p class="BH-pagebtnA">
					<a href="javascript:void(0);" onclick="prePage();">上一页</a>
					<a class="pagenow">1</a>
					<a href="javascript:void(0);" onclick="nextPage();">下一页</a>
				</p>
			</div>
		</div>
		<div id="bh-banner" class="bh-banner"></div>
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
