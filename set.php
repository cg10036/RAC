<?php
//DEFAULT
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
//DEFAULT
$array = array("set_t_1", "set_t_2", "set_h_1", "set_h_2");
for($i = 0;$i < count($array);$i++)
{
    if($_POST[$array[$i]] == "")
    {
        continue;
    }
    if($_POST[$array[$i]] != (string)(float)$_POST[$array[$i]])
    {
        die("<script>alert(\"값은 특수문자일 수 없습니다!\");location.href='./main.php';</script>");
    }
    if(substr($array[$i], 0, 5) == "set_t" && ((float)$_POST[$array[$i]] < 0 || (float)$_POST[$array[$i]] > 50))
    {
        die("<script>alert(\"온도의 설정 범위는 0~50 입니다.\");location.href='./main.php';</script>");
    }
    if(substr($array[$i], 0, 5) == "set_h" && ((float)$_POST[$array[$i]] < 20 || (float)$_POST[$array[$i]] > 70))
    {
        die("<script>alert(\"습도의 설정 범위는 20~70 입니다.\");location.href='./main.php';</script>");
    }
}
for($i = 0;$i < count($array);$i++)
{
    if($_POST[$array[$i]] == "")
    {
        continue;
    }
    $sql = "update ".$_SESSION['serial']." set ".$array[$i]." = '".$_POST[$array[$i]]."'";
    mysqli_query($sunrin_db, $sql);
}
die("<script>alert(\"완료\");location.href='./main.php';</script>");
?>