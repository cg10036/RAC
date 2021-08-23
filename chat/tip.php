<?php
session_Start();
?>
<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Black+Han+Sans&amp;display=swap&amp;subset=korean" rel="stylesheet">
<style>
#chk{
width:30px;
height:30px;
text-align:center
border:none;
}
select{
border:none;
width:150px;
height:50px;
font-size:20px;
}

</style>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style2.css">
<?php
$jong = $_SESSION['jong'];
$gender = $_SESSION['gender'];
$baby = $_SESSION['baby'];
$tal = $_SESSION['tal'];
$sep;
$tem;
$cal;
$feed;
$ground;
if($jong=="레오파드게코"){
	if($tal=="O"){
	$tem="28C";
	$sep="50%";
	}
	else if($baby=="o"){
	$sep="50%";
	$tem="29C";
	}
	else
	{
	$sep = "40%";
	$tem = "28C";
	}
	$cal ="칼슘제";
	$feed = "밀웜,귀뚜라미,슈퍼밀웜";
	$ground = "키친타올,신문지";
}
?>
</head>
<body>
<div id="title">ㄹㅔㄱ</div>
<form action="main.php" method="post">
<table id="home2">
<tr style="float:left;margin-top:10%;margin-left:100px;">
<td>Tip</td>
</tr>
<tr>
<td> <?php echo "당신의 종은 $jong 입니다." ?></td>
</tr>
<tr>
<td> <?php echo "추천 온도는 $tem  입니다." ?></td>
</tr>
<tr>
<td> <?php echo "추천 영양제는 $feed 입니다. " ?></td>
</tr>
<tr>
<td> <?php echo "추천 바닥제는 $ground 입니다. " ?>  </td>
</tr>
</table>

</body></html>
