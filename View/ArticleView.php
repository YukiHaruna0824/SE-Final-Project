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
			dataType : 'json'
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

					PostUser.innerHTML = data['Owner'];
					Title.innerHTML = data['Title'];
					Content.innerHTML = data['Content'];
					Thumb.innerHTML = data['thumb'];

					var comment = data['commit'];//獲取留言資訊
					for(var i = 0; i < Object.keys(comment).length; i++)
					{
						var postman = data[i.toString()]['Owner'];//每筆資料的留言者
						var content = data[i.toString()]['content'];//每筆資料留言的留言內容

						$("#comment").html() += 
						'<div class="reply-content"><h2 class="reply-content__user">' + postman +
						'</h2><article class="reply-content__article c-article ">' + content +
						'</article><div class="reply-content__footer"><div class="edittime" data-tooltipped="" aria-describedby="tippy-tooltip-272" data-original-title="留言時間 2018-06-30 03:07:05">2018-06-30 03:07:05</div></div></div><br>';
					}
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
			//失敗的時候
			alert("有錯誤產生，請看 console log");
			console.log(jqXHR.responseText);
		});		
	});
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
			<!--文章區-->
			<div class="b-list-wrap">
				<table class="b-list">
					<tbody>
						<div class="c-post__header">
							<h1 class="c-post__header__title" id="title">台科最爛交友網站上線了</h1>
							<div class="c-post__header__author">
								<h2 id="name">名字</h2>
							</div>
							<div class="c-post__header__info">
								<h5>2017-01-21 23:37:05 編輯</h5>
							</div>
						</div>
				
						<div class="c-post__body">
							<!--內文-->
							<article class="c-article FM-P2">
								<p id="content">茗翔垃圾資料庫</p>
							</article>
							<!--按讚-->
							<div class="c-post__body__buttonbar">
								<button type="button">真香</button>
								<span id="thumb">12</span>
							</div>

							<div class="c-post__footer c-reply">

								<!--他人留言開始-->
								<div class="c-reply__item" id="comment">

									<div class="reply-content">
										<h2 class="reply-content__user">邱暐盛</h2>
										<article class="reply-content__article c-article ">
											跟狗一樣
										</article>
										<div class="reply-content__footer">
											<div class="edittime" data-tooltipped="" aria-describedby="tippy-tooltip-272" data-original-title="留言時間 2018-06-30 03:07:05">
												2018-06-30 03:07:05
											</div>
										</div>
									</div>
									<br>

									<div class="reply-content">
										<h2 class="reply-content__user">范茗翔</h2>
										<article class="reply-content__article c-article ">
											資料庫有夠雷
										</article>
										<div class="reply-content__footer">
											<div class="edittime" data-tooltipped="" aria-describedby="tippy-tooltip-272" data-original-title="留言時間 2018-06-30 03:07:05">
												2018-06-30 03:07:05
											</div>
										</div>
									</div>
									<br>

									<div class="reply-content">
										<h2 class="reply-content__user">鄭鈺哲</h2>
										<article class="reply-content__article c-article ">
											我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強我超強
										</article>
										<div class="reply-content__footer">
											<div class="edittime" data-tooltipped="" aria-describedby="tippy-tooltip-272" data-original-title="留言時間 2018-06-30 03:07:05">
												2018-06-30 03:07:05
											</div>
										</div>
									</div>
									<br>

								</div>
								<!--他人留言結束-->

								<!--你自己的留言區-->
								<div class="c-reply__editor">
									<div class="reply-input" data-tooltipped="" aria-describedby="tippy-tooltip-216" data-original-title="超過80個字了喔～">
										<textarea data-bsn="60076" data-snb="40985403" class="content-edit" placeholder="留言⋯"></textarea>
									</div>
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