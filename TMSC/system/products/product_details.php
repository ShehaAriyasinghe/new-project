<?php
include '../function.php';

extract($_GET);

echo $productid;
    
$sql="SELECT * FROM tbl_products where productid='$productid'";
$db= dbconn();
$result=$db->query($sql);

$row=$result->fetch_assoc();

echo $row['productname'];
echo $row['productdescription'];

?>    