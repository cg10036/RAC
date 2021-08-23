<?php
$sunrin_db = mysqli_connect("localhost", "sunrin_db", "sunrinkmc", "sunrin_db");
$sql = "select * from randomkey";
$result = mysqli_query($sunrin_db, $sql);
if($data = mysqli_fetch_array($result))
{
    die($data['randomkey']);
}
die("KO");
?>