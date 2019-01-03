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
	$(document).ready(function() {
		var urlVar = window.location.search.split("="); // ?id=xx
		var articleid = urlVar[1];//得到文章Id
		
		//初始化文章
		$.ajax({
			type : "POST",
			url : "../Controller/Article.php",
			dataType : 'json',
			data : {
				id : articleid,
				get : "123"
			}
			}).done(function(data) {
				if(data != null)
				{
					var PostUser = document.getElementById("name");//發文者
					var Title = document.getElementById("title");//標題
					var Content = document.getElementById("content");//內容
					var Thumb = document.getElementById("thumb");//按讚數
					var PostTime = document.getElementById("posttime");//發文時間
					
					PostUser.innerText = "PostMan : " + data['Owner'];
					Title.innerText = "Title : " + data['Title'];
					Content.innerText = data['Content'];
					Thumb.innerText = data['thumb'];
					PostTime.innerText = "PostTime : " + data['DeliveryDate'];

					if(data['commit'] != null){
						var comment = data['commit'];//獲取留言資訊
						var message = "";

						for(var i = 0; i < Object.keys(comment).length; i++)
						{
							var json = comment[i];
							var postman = json['Owner'];//每筆資料的留言者
							var content = json['Content'];//每筆資料留言的留言內容
							var time = json['DeliveryDate'];//取得時間

							message += '<div class="reply-content"><h2 class="reply-content__user">' + postman +
							'</h2><article class="reply-content__article c-article ">&nbsp' + content +
							'</article><div class="reply-content__footer"><div class="edittime" data-tooltipped="" aria-describedby="tippy-tooltip-272">' + 
							time + '</div></div></div><br>';
						}
						$("#comment").html(message);
					}
					else{
						$("#comment").html("");
					}
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
			//失敗的時候
			alert("有錯誤產生，請看 console log");
			console.log(jqXHR.responseText);
		});
		
		//點讚
		$("#sendthumb").click(function(){
			let urlVar = window.location.search.split("="); // ?id=xx
			let articleid = urlVar[1];//得到文章Id
			let PostUserName = document.getElementById("name").innerText.split(": "); //發文者名稱

			$.ajax({
				type : "POST",
				url : "../Controller/Article.php",
				data : {
					id : articleid,
					na : PostUserName[1]
				},
				dataType : 'html'
			}).done(function(data){
				console.log(data);
				if(data == "AC"){
					$("#thumb").text(Number($("#thumb").text()) + 1);
				}else if(data == "ER"){
					alert("你已點過讚了喔");
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
				//失敗的時候
				alert("有錯誤產生，請看 console log");
				console.log(jqXHR.responseText);
			});

		});

		//送出留言
		$("#submitmessage").click(function(){
			$.ajax({
				type : "POST",
				url : "../Controller/Article.php",
				data : {
					id : articleid,
					content : $("#message").val()
				},
				dataType : 'html'
				}).done(function(data) {
					window.location.href = "ArticleView.php?id=" + articleid; 
				}).fail(function(jqXHR, textStatus, errorThrown) {
				//失敗的時候
				alert("有錯誤產生，請看 console log");
				console.log(jqXHR.responseText);
			});
		});	

		//back按鈕註冊
		$("#back").click(function(){
			window.location.href="HomeView.php";
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

				if(data == "bye")
				{
					alert("登出成功，請按確認後登出");
					window.location.href="LoginView.php";
				}
				}).fail(function(jqXHR, textStatus, errorThrown) {
				//失敗的時候
				alert("有錯誤產生，請看 console log");
				console.log(jqXHR.responseText);
			});
		});	
	});
</script>
	
<body>

	<!--不會被覆蓋-->
	<div class="TOP-bh"></div>
	</div>

	<div id="BH-menu-path" class="BH-menu">
		<ul class="BH-menuE">
			<li class="dropList"><a href="#">文章區</a></li>
			<li class="dropList"><a id="back"><span style="color:orange;">返回</span></a></li>
			<li><a id="logout"><span style="color:red;">登出</span></a></li>
		<ul>
	</div>

	<!--將頁面往下挪以免btn被蓋住-->
	<div id="bh-banner" class="bh-banner">
	</div>

	<!--主畫面-->
	<div class="container"> 
		<div id="main">
			<!--文章區-->
			<div class="b-list-wrap">
				<table class="b-list">
					<tbody>
						<div class="c-post__header">
							<h1 class="c-post__header__title" id="title"></h1>
							<div class="c-post__header__author">
								<h2 id="name"></h2>
							</div>
							<div class="c-post__header__info">
								<h5 id="posttime"></h5>
							</div>
						</div>
				
						<div class="c-post__body">
							<!--內文-->
							<article class="c-article FM-P2">
								<p id="content"></p>
							</article>
							<!--按讚-->
							<div class="c-post__body__buttonbar">
								<button type="button" class="btn--sm btn--normal" id="sendthumb">讚</button>
								<span id="thumb"></span>
							</div>

							<div class="c-post__footer c-reply">

								<!--他人留言開始-->
								<div class="c-reply__item" id="comment">
									<!--dynamic-->
								</div>
								<!--他人留言結束-->

								<!--你自己的留言區-->
								<div class="c-reply__editor">
									<div class="reply-input">
										<textarea class="content-edit" id="message" placeholder="留言⋯"></textarea>
									</div>
									<button type="button" id="submitmessage" class="btn--sm btn--normal">留言</button>
								</div>
								
							</div>
						</div>
					</tbody>
				</table>
			</div>
		</div>
	</div>	

</body>
</html>