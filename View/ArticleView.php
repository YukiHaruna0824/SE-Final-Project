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
		//name id
		var urlVar = window.location.search.substring(1).split("&");
		var i,tmpVal,tmpID;
		for(i=0;i<urlVar.length;i++){
			tmpVal = urlVar[i].split("=");
			if(tmpVal[0]=="id"){
				tmpID = tmpVal[1];
			}
		}
		
		$.ajax({
			type : "POST",
			url : "../Controller/Article.php",
			data : {
				id:tmpID,
				get:"拿文章"
			},
			dataType : 'json',
		}).done(function(data){
			console.log(data);
			$('#name').text(data["Owner"]);
			$('#content').text(data["Content"]);
			$('#title').text(data["Title"]);
		}).fail(function(jqXHR, textStatus, errorThrown){
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
					<h1 class="c-post__header__title " id="title">標題</h1>
						<div class="c-post__header__author">
							<h2 id="name">名字</h2>
							<!--案讚-->
							<div class="postcount">
								<span class="postbp">讚<span>32</span></span><div class="fb-like fb_iframe_widget" data-href="https://forum.gamer.com.tw/C.php?bsn=60076&amp;snA=3722490" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false" fb-xfbml-state="rendered" fb-iframe-plugin-query="action=like&amp;app_id=668497826514848&amp;container_width=78&amp;href=https%3A%2F%2Fforum.gamer.com.tw%2FC.php%3Fbsn%3D60076%26snA%3D3722490&amp;layout=button&amp;locale=zh_TW&amp;sdk=joey&amp;share=false&amp;show_faces=false&amp;size=small"><span style="vertical-align: bottom; width: 40px; height: 20px;"><iframe name="f282a6be206258" width="1000px" height="1000px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" title="fb:like Facebook Social Plugin" src="https://www.facebook.com/plugins/like.php?action=like&amp;app_id=668497826514848&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter%2Fr%2Fj-GHT1gpo6-.js%3Fversion%3D43%23cb%3Df301b28892a32f4%26domain%3Dforum.gamer.com.tw%26origin%3Dhttps%253A%252F%252Fforum.gamer.com.tw%252Ff2cb2c38233722%26relation%3Dparent.parent&amp;container_width=78&amp;href=https%3A%2F%2Fforum.gamer.com.tw%2FC.php%3Fbsn%3D60076%26snA%3D3722490&amp;layout=button&amp;locale=zh_TW&amp;sdk=joey&amp;share=false&amp;show_faces=false&amp;size=small" style="border: none; visibility: visible; width: 40px; height: 20px;" class=""></iframe></span></div>
							</div>
						</div>
					<div class="c-post__header__info">
					<h5>2017-01-21 23:37:05 編輯</h5>
				</div>
		</div>
		
		<div class="c-post__body">
<!--內文-->
<article class="c-article FM-P2" id="cf40985403">
	<p id="content"></p>
</article>

<!--留言區-->
<div class="c-post__body__buttonbar">
	<div class="bp">
		<button class="ef-btn ef-bounce tippy-gpbp" onclick="addgpbp(this, 60076, 40985403, 2, event)" type="button" id="bp_40985403" data-tooltipped="" aria-describedby="tippy-tooltip-128" data-original-title="我要噓⋯">
			<div class="ef-btn__effect">
				<i class="icon material-icons"></i>
			</div>
		</button>
		<a class="count tippy-gpbp-list" href="javascript:;" data-tippy="{&quot;bsn&quot;:60076,&quot;sn&quot;:40985403,&quot;type&quot;:2}" data-tooltipped="" aria-describedby="tippy-tooltip-235">32</a>
	</div>
	<div class="more">
		<button class="tippy-option-menu" data-tippy="{&quot;bsn&quot;:60076,&quot;snA&quot;:3722490,&quot;sn&quot;:&quot;40985403&quot;,&quot;author&quot;:&quot;since9697981&quot;,&quot;title&quot;:&quot;\u3010\u60c5\u5831\u3011\u6211\u6539\u4e86\u4e00\u4e9b\u59c6\u54aaGIF (12\/23\u66f4\u65b0~)&quot;,&quot;dc_c1&quot;:&quot;0&quot;,&quot;dc_c2&quot;:&quot;0&quot;,&quot;dc_type&quot;:&quot;1&quot;,&quot;dc_machine&quot;:&quot;262144,3&quot;,&quot;dc_name&quot;:&quot;\u5834\u5916\u4f11\u61a9\u5340&quot;,&quot;subbsn&quot;:0,&quot;isLogin&quot;:false,&quot;noReward&quot;:true,&quot;isBM&quot;:0,&quot;owner&quot;:false,&quot;readingAuthor&quot;:null,&quot;area&quot;:&quot;C&quot;,&quot;canEdit&quot;:null,&quot;parent&quot;:0}" type="button" data-tooltipped="" aria-describedby="tippy-tooltip-54"><i class="material-icons"></i></button>
	</div>
	<div class="jumptocomment">
	<!--回復按鈕-->
		<button class="btn--sm btn--normal" type="button" onclick="location.href='post1.php?bsn=60076&amp;type=2&amp;re=1&amp;snA=3722490&amp;sn=40985403&amp;subbsn=0&amp;re=1'">
			<i class="btn__icon material-icons"></i>
			<span class="btn__content">回覆</span>
		</button>
	</div>
</div>

<div class="c-post__footer c-reply">
	<div class="c-reply__head nocontent">
		<!--留言開始-->
		<div class="old-reply" id="moreCommentBtn_40985403" style="display:none">
			<a href="javascript:;" onclick="extendComment(60076, 40985403);">顯示舊留言</a>
		</div>
	</div>
	<div id="Commendlist_40985403">
		<div class="c-reply__item" id="Commendcontent_2024393" data-comment="{&quot;bsn&quot;:60076,&quot;snB&quot;:40985403,&quot;sn&quot;:2024393,&quot;isLogin&quot;:false,&quot;deletable&quot;:false,&quot;editable&quot;:false,&quot;content&quot;:&quot;\u7b11\u6b7b&quot;}">
			<div>
			<button type="button" class="more tippy-reply-menu" data-tooltipped="" aria-describedby="tippy-tooltip-90">
				<i class="material-icons"></i>
			</button>
			<div class="reply-content">
				<h2>邱暐盛</h2>
				<article class="reply-content__article c-article ">
					<span data-formatted="yes">很帥</span>
				</article>
				<div class="reply-content__footer">
					<div class="edittime" data-tooltipped="" aria-describedby="tippy-tooltip-272" data-original-title="留言時間 2018-06-30 03:07:05">
						2018-06-30 03:07:05
					</div>
					<div class="buttonbar">
						<button type="button" onclick="Forum.C.commentGp(this);" class="gp" title="推一個！"><i class="material-icons"></i></button>
						<a data-gp="0" href="javascript:;" class="gp-count"></a>
						<button type="button" onclick="Forum.C.commentBp(this);" class="bp" title="我要噓…"><i class="material-icons"></i></button>
						<a data-bp="0" href="javascript:;" class="bp-count"></a>
					</div>
				</div>
			</div>
			</div>
		</div>
		<!--留言結束-->
		<!--你自己的留言區-->
	</div>
	<div class="c-reply__editor">
		<div class="reply-input" data-tooltipped="" aria-describedby="tippy-tooltip-216" data-original-title="超過80個字了喔～">
			<textarea data-bsn="60076" data-snb="40985403" class="content-edit" placeholder="留言⋯"></textarea>
			<div class="comment_icon">
			</div>
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
