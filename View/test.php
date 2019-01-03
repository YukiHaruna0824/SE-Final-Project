<?php

// http://www.wibibi.com/test.php?tid=333&tid2=333
// echo $_SERVER['HTTP_HOST'];//顯示 www.wibibi.com
// echo $_SERVER['REQUEST_URI'];//顯示 /test.php?tid=333&tid2=333
// echo $_SERVER['PHP_SELF'];//顯示 /test.php
// echo $_SERVER['QUERY_STRING'];//顯示 tid=333&tid2=333
$ary = $_SERVER['QUERY_STRING'];
$ary = explode("&",$ary);
for($i=0;$i<count($ary);$i++){
	echo $ary[$i];
	echo "</br>";
}
?>