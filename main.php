<?php
session_start();
if($_SESSION['serial'] == "")
{
    session_destroy();
    header("Location: ./login.php");
    die();
}
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
if(!mysqli_fetch_array($result))
{
    session_destroy();
    header("Location: ./login.php");
    die();
}
if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])
{
    session_destroy();
    echo "<script>alert(\"IP Changed! Login again.\");location.href='./login.php';</script>";
}
$sql = "select * from ".$_SESSION['serial']."_ip";
$result = mysqli_query($sunrin_db, $sql);
$bool = 0;
while($data = mysqli_fetch_array($result))
{
    if($data['ip'] == $_SERVER['REMOTE_ADDR'] || $data['ip'] == "*")
    {
        $bool = 1;
        break;
    }
}
if($bool == 0)
{
    session_destroy();
    echo "<script>alert(\"IP BLOCKED!\\nYou should add your IP to the ip_whitelist.txt in your sdcard or disable it.\\nYOUR IP_ADRESS IS ".$_SERVER['REMOTE_ADDR']."\");location.href='./login.php';</script>";
    die();
}
?>
<?php
$jong=$_POST['jong'];
$gender = $_POST['gender'];
$baby=$_POST['baby'];
$tal=$_POST['tal'];
$_SESSION['gender'] = $gender;
$_SESSION['baby'] = $baby;
$_SESSION['tal']=$tal;
$_SESSION['jong']=$jong;
if($_POST['jong'] != "" && $_POST['gender'] != "" && $_POST['baby'] != "" && $_POST['tal'] != "")
{
    header("Location: ./tip.php");
}
?>
<!doctype html>

<html>
<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">

 #pop{
  width:350px; height:450px; background:#3d3d3d; color:#fff;
  position:absolute; top:10px; left:100px; text-align:center;
  border:2px solid #000;
  border-radius:10px 10px 10px 10px;	
  opacity: 0.5;
   }
</style>
<link href="https://fonts.googleapis.com/css?family=Black+Han+Sans&amp;display=swap&amp;subset=korean" rel="stylesheet">

<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
<div id="title">ㄹㅔㄱ</div>
<form action="set.php" method="post">
<div style="margin-left:0px;float:left;width:50%;">
<table id="home1">
<tbody><tr><td><button style="border:none;margin-left:10px;width:130px;float:left; height:50px;color:black;" disabled="">사육장 1 </button></td>
</tr><tr>
<td>온도 입력&nbsp;<input type="text" name="set_t_1" id="set_t_1" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['set_t_1']."\"";
?>></td>
</tr>
<tr>
<td>습도 입력&nbsp;<input type="text" name="set_h_1" id="set_h_1" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['set_h_1']."\"";
?>></td>
</tr>
<tr>
<td>현재 온도&nbsp;<input type="text" name="now_t_1" id="now_t_1" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['now_t_1']."\"";
?>  readonly=""></td>
</tr>
<tr>
<td>현재 습도&nbsp;<input type="text" name="now_h_1" id="now_h_1" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['now_h_1']."\"";
?> readonly=""></td>
</tr>
</tbody></table>
</div>
<div style="width:50%float:right;">
<table id="home2">
<tbody><tr><td><button style="border:none;margin-left:10px;width:130px;float:left; height:50px;color:black;" disabled="">사육장 2</button></td>
</tr><tr>
<td>온도 입력&nbsp; <input type="text" name="set_t_2" id="set_t_2" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['set_t_2']."\"";
?>></td>
</tr>
<tr>
<td>습도 입력&nbsp;<input type="text" name="set_h_2" id="set_h_2" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['set_h_2']."\"";
?>></td>
</tr>
<tr>
<td>현재 온도&nbsp;<input type="text" name="now_t_2" id="now_t_2" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['now_t_2']."\"";
?> readonly=""></td>
</tr>
<tr>
<td>현재 습도&nbsp;<input type="text" name="now_h_2" id="now_h_2" value=<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from ".$_SESSION['serial'];
$result = mysqli_query($sunrin_db, $sql);
echo "\"".mysqli_fetch_array($result)['now_h_2']."\"";
?> readonly=""></td>
</tr>
    </tbody></table>
    </div>
    <br>
    <center>
    <button type="submit" style="width:200px; height:50px;">설정</button>
    <button type="button"style="width:200px; height:50px;" onclick="location.href='menu.php'">팁</button>
<button type="button" style="width:200px; height:50px;" onclick="location.href='/chat'">채팅</button>
<button type="button"style="width:200px; height:50px;" onclick="location.href='./logout.php'">로그아웃</button>
	
</center>    
</form>

</body></html>

