<html lang="ko">
<head>
<title>ㄹ ㅔ ㄱ CHAT</title>
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Black+Han+Sans&amp;display=swap&amp;subset=korean" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style2.css">
<style>
button{
width:400px;
background-color:white;
border: 3.5px solid black;		
	border-radius: 10px 10px 10px 10px;
	border-color:black;
font-size:25px;
margin-left: auto; margin-right: auto; 
font-family: 'Black Han Sans', sans-serif;
  text-align: center;
  }
form{
background-color:white;
border:3.5px solid black;
border-radius:10px 10px 10px 10px;
border-color:black;
}
</style>
<script type="text/javascript" src="chat.js"></script>
<link rel="stylesheet" type="text/css" href="chat.css" />
</head>
<body>
<dl id="list"style="width:400px;background-color: white;border:3.5px solid black;border-radius:15px 15px 15px 15px;">
<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from chat";
$result = mysqli_query($sunrin_db, $sql);
while($row = mysqli_fetch_array($result))
{
echo "<dt>".$row['name']."</dt><dd>".$row['msg']."</dd>";
}
echo '</dl>
<form style="width:400px;"onsubmit="chatManager.write(this); return false;">
<input name="name"placeholder="이름을 입력해주세요."style="width:400px;border:1px solid black;border-radius:3px 3px 3px 3px;" id="name" type="text" />
<input name="msg"placeholder="내용을 입력해주세요."style="width:400px;border:1px solid black;border-radius:3px 3px 3px 3px;" id="msg" type="text" />
<button name="btn"style="width:400px;border:1px solid black;border-radius:3px 3px 3px 3px;" id="btn" type="submit">입력</button>
</form>
<button type="button"style="width:409px; height:50px;" onclick="location.href=\'../main.php\'">메뉴</button>
</body>
</html>';
?>
