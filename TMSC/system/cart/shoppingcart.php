<?php

session_start();
include '../function.php'; 
extract($_POST);
$categoryid;
$jobcardid;
if($_SERVER['REQUEST_METHOD']=="POST" && $operate=='add_cart'){
  $db= dbconn();
  $sql="SELECT c.catalogid,c.itemname,c.itemimage,s.sellingprice,s.discount FROM tbl_itemcatalog c INNER JOIN tbl_itemstock s ON s.catalogid=c.catalogid WHERE c.catalogid='$catalogid'";
  $result=$db->query($sql);
  $row=$result->fetch_assoc();
  
  $current_qty=$_SESSION['itemcart'][$catalogid]['qty']+=1;
  $_SESSION['itemcart'][$catalogid]=array('catalogid'=>$row['catalogid'],'itemname'=>$row['itemname'],'price'=>$row['sellingprice'],'image'=>$row['itemimage'],'discount'=>$row['discount'],'qty'=>$current_qty);

  header("Location:productview.php?categoryid=$categoryid&jobcardid=$jobcardid");

}

?>
