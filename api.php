<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
switch($_GET['mode'])
{
case "get":
    if($_GET['serial'] == "")
    {
        die("KO"); //check serial
    }
    $sql = "select * from ".$_GET['serial'];
    $result = mysqli_query($sunrin_db, $sql);
    if(!$data = mysqli_fetch_array($result))
    {
        die("KO"); // check serial
    }
    $sql = "select * from randomkey";
    $result = mysqli_query($sunrin_db, $sql);
    $randomkey = mysqli_fetch_array($result)['randomkey'];
    for($i = 0;$i < 256;$i++)
    {
        $hash = $hash.$randomkey[$i].$data['serial'][$i];
    }
    $hash = md5($hash);
    if($_GET['hash'] != $hash)
    {
        die("KO");
    }
    die($data['set_t_1'].",".$data['set_t_2'].",".$data['set_h_1'].",".$data['set_h_2']);
    break;
case "set":
    if($_GET['serial'] == "")
    {
        die("KO"); // check serial
    }
    $sql = "select * from ".$_GET['serial'];
    $result = mysqli_query($sunrin_db, $sql);
    if(!$data = mysqli_fetch_array($result))
    {
        die("KO"); // check serial
    }
    $sql = "select * from randomkey";
    $result = mysqli_query($sunrin_db, $sql);
    $randomkey = mysqli_fetch_array($result)['randomkey'];
    for($i = 0;$i < 256;$i++)
    {
        $hash = $hash.$randomkey[$i].$data['serial'][$i];
    }
    $hash = md5($hash);
    if($_GET['hash'] != $hash)
    {
        die("KO");
    }
    $array = array('now_t_1', 'now_t_2', 'now_h_1', 'now_h_2');
    for($i = 0;$i < count($array);$i++)
    {
        if($_GET[$array[$i]] == "")
        {
            continue;
        }
        $sql = "update ".$_GET['serial']." set ".$array[$i]." = '".$_GET[$array[$i]]."';";
        mysqli_query($sunrin_db, $sql);
    }
    die("OK");
    break;
case "check":
    $sql = "select * from ".$_GET['serial'];
    $result = mysqli_query($sunrin_db, $sql);
    if($data = mysqli_fetch_array($result))
    {
        $sql = "select * from ".$_GET['serial'];
        $result = mysqli_query($sunrin_db, $sql);
        $data = mysqli_fetch_array($result);
        $sql = "select * from randomkey";
        $result = mysqli_query($sunrin_db, $sql);
        $randomkey = mysqli_fetch_array($result)['randomkey'];
        for($i = 0;$i < 256;$i++)
        {
            $hash = $hash.$randomkey[$i].$data['serial'][$i];
        }
        $hash = md5($hash);
        if($hash != $_GET['Serial'])
        {
            die("KO");
        }
    }
    else if(strlen($_GET['Serial']) <= 32)
    {
        die("register");
    }
    else
    {
        $sql = "create table ".$_GET['serial']." ( now_t_1 varchar(10) default '0', now_t_2 varchar(10) default '0', now_h_1 varchar(10) default '0', now_h_2 varchar(10) default '0', set_t_1 varchar(10) default '0', set_t_2 varchar(10) default '0', set_h_1 varchar(10) default '0', set_h_2 varchar(10) default '0', serial varchar(10000) not null )";
        mysqli_query($sunrin_db, $sql);
        $sql = "insert into ".$_GET['serial']."(serial) values ('".$_GET['Serial']."')";
        mysqli_query($sunrin_db, $sql);
    }
    die("OK");
    break;
case "ip":
    //$strTok =explode(';' , $String);
    if($_GET['ips'] == "")
    {
        die("KO"); // check ips
    }
    $sql = "select * from ".$_GET['serial'];
    $result = mysqli_query($sunrin_db, $sql);
    $data = mysqli_fetch_array($result);
    $sql = "select * from randomkey";
    $result = mysqli_query($sunrin_db, $sql);
    $randomkey = mysqli_fetch_array($result)['randomkey'];
    for($i = 0;$i < 256;$i++)
    {
        $hash = $hash.$randomkey[$i].$data['serial'][$i];
    }
    $hash = md5($hash);
    if($_GET['hash'] != $hash)
    {
        die("KO");
    }
    $array = explode(";", $_GET['ips']);
    for($i = 0;$i < count($array);$i++)
    {
        if($array[$i] == "")
        {
            continue;
        }
        if($array[$i] == "*")
        {
            $sql = "drop table ".$_GET['serial']."_ip";
            mysqli_query($sunrin_db, $sql);
            $sql = "create table ".$_GET['serial']."_ip ( ip varchar(50) not null )";
            mysqli_query($sunrin_db, $sql);
            $sql = "insert into ".$_GET['serial']."_ip(ip) values ('*')";
            mysqli_query($sunrin_db, $sql);
            die("OK");
        }
        if(filter_var($array[$i], FILTER_VALIDATE_IP) == false)
        {
            if(filter_var($array[$i], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) == false)
            {
                die("KO");// check ips //die("ERROR : IP[".$i."] : ".$array[$i]);
            }
        }
    }
    $sql = "drop table ".$_GET['serial']."_ip";
    mysqli_query($sunrin_db, $sql);
    $sql = "create table ".$_GET['serial']."_ip ( ip varchar(50) not null )";
    mysqli_query($sunrin_db, $sql);
    for($i = 0;$i < count($array);$i++)
    {
        if($array[$i] == "")
        {
            continue;
        }
        $sql = "insert into ".$_GET['serial']."_ip(ip) values ('".$array[$i]."')";
        mysqli_query($sunrin_db, $sql);
    }
    die("OK");
    break;
case "randomkey":
    generateRandomkey();
    die();
    break;
default:
    break;
}

function generateRandomkey()
{
    $sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
    $randomkey = generateRandomString();
    $sql = "update randomkey set randomkey = '".$randomkey."'";
    mysqli_query($sunrin_db, $sql);
}

function generateRandomString($length = 256) 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//create table asdf( now_t_1 varchar(10) default '0', now_t_2 varchar(10) default '0', now_h_1 varchar(10) default '0', now_h_2 varchar(10) default '0', set_t_1 varchar(10) default '0', set_t_2 varchar(10) default '0', set_h_1 varchar(10) default '0', set_h_2 varchar(10) default '0' );
//http://sunrin.duckdns.org/api.php?mode=set&serial=asdf&now_t_1=10&now_t_2=10&now_h_1=10&now_h_2=10&set_t_1=10&set_t_2=10&set_h_1=10&set_h_2=10
?>
