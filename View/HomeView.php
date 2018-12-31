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
	$('#articles > tbody').html(getHTML());
});

function getHTML(data){
	var tmpHTML = 
		"<tr class=\"b-list__head\">"
			+"<td style=\"width: 135px;\">使用者名稱</td>"
			+"<td style=\"max-width: 600px;\">文章</td>"
		+"</tr>" ;
	var i;
	for(i=0;i<data.length;i+=3){
		tmpHTML += 
			"<tr class=\"b-list__row\">"
				+"<td class=\"b-list__account\">"
					+"<a href=\"test.php?id="+data[i]['id']+"\" class=\"b-list__account__user\"  id=\"name"+data[2][i]['id']+"\">"
						+"名字"
					+"</a>"
				+"</td>"
				+"<td class=\"b-list__main\">"
					+'<a class="b-list__main__title">'
						+"文章名稱文章名稱文章名稱文章名稱"
					+"</a>"
				+"</td>"
			+"</tr>";
	}
	return tmpHTML
}

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
		$('#articles > tbody').html(getHTML(data));
	}).fail(function(jqXHR, textStatus, errorThrown){
		alert("有錯誤產生，請看 console log");
		console.log(jqXHR.responseText);
	});
	
	$("a").click(function(){
		$.ajax({
			type : "POST",
			url : "../Controller/Article.php",
			data : {
				title : $(this).html() //文章標題
			},
			dataType : 'json',
		}).done(function(data){
			$(this).attr("href","ArticleView.php?id=" + data['id']);//決定文章id，前往下層article拆解id內容

		}).fail(function(jqXHR, textStatus, errorThrown){
			alert("有錯誤產生，請看 console log");
            console.log(jqXHR.responseText);
		});
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
						$("#otherClass").after('<div><button id="AddFriend">新增好友</button></div>');
					}
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
			//失敗的時候
			alert("有錯誤產生，請看 console log");
			console.log(jqXHR.responseText);
		});
	});
});
	
function nextPage() {
	jQuery.post('../Controller/Article.php',{np : "下一頁文章"},
	function(data) {
		if(data == null){
			return;
		}
		$('.pagenow').each(function(){
			$(this).html(Number($(this).text())+1);
		});
		$('#articles > tbody').html(getHTML(data));
	}, "json");
}

function prePage() {
	jQuery.post('../Controller/Article.php',{bp : "上一頁文章"},
	function(data) {
		if(data == null){
			return;
		}
		$('.pagenow').each(function(){
			if(Number($(this).text())==1)
				return;
			$(this).html(Number($(this).text())-1);
		});
		$('#articles > tbody').html(getHTML(data));
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
					<a href="javascript:void(0);" onclick="prePage();">上一页</a>
					<a class="pagenow">1</a>
					<a href="javascript:void(0);" onclick="nextPage();">下一页</a>
				</p>
			</div>
		</div>
		<div id="bh-banner" class="bh-banner"></div>
	</div>
</div>	

</body>
</html>