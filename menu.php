<?php
session_start();
?>
<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Black+Han+Sans&amp;display=swap&amp;subset=korean" rel="stylesheet">
<style>
#chk{
width:15px;
height:15px;
text-align:center
border:none;
}
input{
font-size:30px;
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
</head>
<body>
<div id="title">ㄹㅔㄱ</div>
<form action="main.php" method="post">
<table id="home2">
<tr>
<td>종</td>
<td width="250px">
<select name="jong">
    <option value="">종선택</option>
    <option value="레오파드게코">레오파드게코</option>
    <option value="볼파이톤">볼파이톤</option>
    <option value="킹스네이크">킹스네이크</option>
</select>
</td>
</tr>
<tr>
<td>성별</td>
<td>
<select name="gender" id="gender">
    <option value="">성별</option>
    <option value="m">수컷</option>
    <option value="w">암컷</option>
</select>
</td>
</tr>
<tr>
<td>임신여부</td>
<td>
<select name="baby">
    <option value="">임신 여부</option>
    <option value="o">O</option>
    <option value="x">X</option>
</select>
</td>
</tr>
<tr>
<td>탈피여부</td>
<td>
<select name="tal">
    <option value="">탈피 여부</option>
    <option value="O">O</option>
    <option value="X">X</option>
</select>
</td>

</tr>
</table>
<div>
<center>
<button type="submit">제출</button></center>
</form>    
</center>
</body></html>
