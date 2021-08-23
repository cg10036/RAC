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
