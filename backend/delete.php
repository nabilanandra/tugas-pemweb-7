<?php 
require_once '../config/db.php';
 
$id = $_GET['id'];
 
mysqli_query($db_connect,"delete from products where id='$id'");
header("location:../show.php");
 
?>