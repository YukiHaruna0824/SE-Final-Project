<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<title>台科交友網站</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="gamer/forum.css">
	<link rel="stylesheet" href="gamer/basic.css">
	<script src="jquery/jquery.min.js"></script>
	<script src="bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
</head>

<script>


$(document).ready(function(data) {
	//拿資料
	$.ajax({
		type : "POST",
		url : "../Controller/Article.php",
		data : {
			mp : "文章"
		},
		dataType : 'json',
	}).done(function(data){
		//console.log(data);
		$('#articles > tbody').html(getHTML(data));
	}).fail(function(jqXHR, textStatus, errorThrown){
		alert("有錯誤產生，請看 console log");
		console.log(jqXHR.responseText);
	});
	
	//抽卡按鈕註冊
	$("#drawcard").click(function(){
		$.ajax({
			type : "POST",
			url : "../Controller/Card.php",
			dataType : 'json'
			}).done(function(data) {
				if(data != null)
				{
					var otherUserName = document.getElementById("otherUserName");
					var otherGender = document.getElementById("otherGender");
					var otherClass = document.getElementById("otherClass");

					otherUserName.innerHTML = "使用者名稱 : " + data['Account'];
					otherGender.innerHTML = "使用者性別 : " + ((data['Gender'] == 0) ? "男" : "女");
					otherClass.innerHTML = "使用者系所 : " + data['Class'];

					//把新增好友的按鈕動態加入到後面
					if(!document.getElementById("AddFriend"))
					{
						$("#otherClass").after('<div><button id="AddFriend" class="btn--sm btn--normal">新增好友</button></div></br>');
						//註冊新增按鈕
						$("#AddFriend").click(function(){
							var othername = $("#otherUserName").text().split(": ");

							$.ajax({
								type : "POST",
								url : "../Controller/Account.php",
								dataType : 'html',
								data : {
									addfriend : othername[1]
								}
							}).done(function(data) {
								if(data == "AC")
									alert("新增好友成功");
								else if(data == "ER")
									alert("已存在此好友");
							}).fail(function(jqXHR, textStatus, errorThrown) {
								//失敗的時候
								alert("有錯誤產生，請看 console log");
								console.log(jqXHR.responseText);
							});
						});
					}
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
			//失敗的時候
			alert("有錯誤產生，請看 console log");
			console.log(jqXHR.responseText);
		});
	});
	
	//logout按鈕註冊
	$("#logout").click(function(){
		$.ajax({
			type : "POST",
			url : "../Controller/Account.php",
			data : {
              apple : "asd"
            },
			dataType : 'html'
			}).done(function(data) {
				console.log(data);
			if(data=="bye")
			{
				alert("登出成功，請按確認後登出");
              	window.location.href = "LoginView.php"; //跳到文章頁面
			}
			}).fail(function(jqXHR, textStatus, errorThrown) {
			//失敗的時候
			alert("有錯誤產生，請看 console log");
			console.log(jqXHR.responseText);
		});
	});
});


function getHTML(data){
	var tmpHTML = 
		"<tr class=\"b-list__head\">"
			+"<td style=\"width: 135px;\">使用者名稱</td>"
			+"<td style=\"max-width: 600px;\">文章</td>"
		+"</tr>" ;
	var i;
	if(data != null)
	{
		for(i=0;i<Object.keys(data).length;i++){
			var tmpData = data[i].split("\"");
			tmpHTML += 
				"<tr class=\"b-list__row\">"
					+"<td class=\"b-list__account\">"
						+"<a href=\"ProfileView.php?id="+tmpData[7]+"\" class=\"b-list__account__user\">"
							+tmpData[11]
						+"</a>"
					+"</td>"
					+"<td class=\"b-list__main\">"
						+"<a href=\"ArticleView.php?id="+tmpData[3]+"\" class=\"b-list__main__title\">"
							+tmpData[15]
						+"</a>"
					+"</td>"
				+"</tr>";
		}		
	}
	return tmpHTML
}

function nextPage() {
	$.ajax({
		type : "POST",
		url : "../Controller/Article.php",
		data : {
			np : "下一頁文章"
		},
		dataType : 'json',
	}).done(function(data){
		if(data == null){
			return;
		}
		$('.pagenow').each(function(){
			$(this).html(Number($(this).text())+1);
		});
		$('#articles > tbody').html(getHTML(data));
	}).fail(function(jqXHR, textStatus, errorThrown){
		alert("有錯誤產生，請看 console log");
		console.log(jqXHR.responseText);
	});
}

function prePage() {
	$.ajax({
		type : "POST",
		url : "../Controller/Article.php",
		data : {
			bp : "上一頁文章"
		},
		dataType : 'json',
	}).done(function(data){
		if(data == null){
			return;
		}
		$('.pagenow').each(function(){
			$(this).html(Number($(this).text())-1);
		});
		$('#articles > tbody').html(getHTML(data));
	}).fail(function(jqXHR, textStatus, errorThrown){
		alert("有錯誤產生，請看 console log");
		console.log(jqXHR.responseText);
	});
}
</script>
	
<body>

<!--不會被覆蓋-->
<div class="TOP-bh">
	<input type="button" id="logout" value="我想登出" style="float:right;width:10%">
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
					<a href="javascript:void(0);" onclick="prePage();">上一頁</a>
					<a class="pagenow">1</a>
					<a href="javascript:void(0);" onclick="nextPage();">下一頁</a>
				</p>
			</div>
		</div>
		
		<!--抽卡介面-->
		<ul class="b-tags">
			<li class="b-tags__item">
				<a href="newArticleView.php">新增文章</a>
			</li>
		</ul>

		<div id="otherUserName"></div>
		<div id="otherGender"></div>
		<div id="otherClass"></div>
		<button type="button" id="drawcard" class="btn--sm btn--normal">抽卡</button>

		<!--文章區-->
		<div class="b-list-wrap">
			<table class="b-list" id="articles">
				<tbody><!--dynamic--></tbody>
			</table>
		</div>
		<!--換頁-->
		<div class="b-pager pager">
			<div id="BH-pagebtn">
				<p class="BH-pagebtnA">
					<a href="javascript:void(0);" onclick="prePage();">上一頁</a>
					<a class="pagenow">1</a>
					<a href="javascript:void(0);" onclick="nextPage();">下一頁</a>
				</p>
			</div>
		</div>
		<div id="bh-banner" class="bh-banner"></div>
	</div>
</div>	

</body>
</html>