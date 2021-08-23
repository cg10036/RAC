<?php
session_start();
if($_POST['serial'] == "")
{
    header('Location: ./login.php');
}
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
if($_POST['serial'] != preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['serial']))
{
    #die("No Characters! ONLY ENGLISH! <br><s>NO HACKS </s>~_~<meta http-equiv=\"refresh\" content=\"3;url=http://www.naver.com/\">");
    echo "<script>alert(\"No Characters! ONLY ENGLISH AND NUMBERS! \\nSQL INJECTION BOOOOOOOOO ~_~\");location.href='./login.php';</script>";
    die();
}
$sql = "select * from ".$_POST['serial'];
$result = mysqli_query($sunrin_db, $sql);
if(!mysqli_fetch_array($result))
{
    echo "<script>alert(\"Not Exist\");location.href='./login.php';</script>";
    die();
}
$sql = "select * from ".$_POST['serial']."_ip";
$result = mysqli_query($sunrin_db, $sql);
while($data = mysqli_fetch_array($result))
{
    if($data['ip'] == $_SERVER['REMOTE_ADDR'] || $data['ip'] == "*")
    {
        session_start();
        $_SESSION['serial'] = $_POST['serial'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        if($data['ip'] == "*")
        {
            echo "<script>alert(\"Setting IP WHITELIST to '*' is not recommended.\\nYOUR IP_ADRESS IS ".$_SERVER['REMOTE_ADDR']."\");location.href='./main.php';</script>";
        }
        else
        {
            header('Location: ./main.php');
        }
        die();
    }
}
echo "<script>alert(\"IP BLOCKED!\\nYou should add your IP to ip_whitelist.txt in your sdcard or * to allow all ips.\\nYOUR IP_ADRESS IS ".$_SERVER['REMOTE_ADDR']."\");location.href='./login.php';</script>";
?>
