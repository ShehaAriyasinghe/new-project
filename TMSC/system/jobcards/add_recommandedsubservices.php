<?php

session_start();
include '../function.php'; 
extract($_POST);

if($_SERVER['REQUEST_METHOD']=="POST" && $operate=='add'){
  $db= dbconn();
  $sql="SELECT * FROM tbl_subservices WHERE subserviceid='$subserviceid'";
  $result=$db->query($sql);
  $row=$result->fetch_assoc();
  
  
   $_SESSION['assignrecommandedsubservices'][$subserviceid]=array('subservicename'=>$row['subservicename'],'subserviceprice'=>$row['subserviceprice']);

  header("Location:addrecommandedservices_jobcard.php?mode=$mode&jobcardid=$jobcardid");
  
}


?>