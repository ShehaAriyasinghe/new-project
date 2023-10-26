<?php

//clean inputs
function cleanInput($input = NULL) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}

//db connection

function dbconn() {

    //create variable to connect db
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "servicecentre";

    //create mysqli object
    $conn = new mysqli($server, $username, $password, $dbname);
    //check db connection has error
    if ($conn->connect_error) {
        die("connection Error :" . $conn->connect_error);
    } else {

        return $conn;
    }
}



//Success message
function showSuccMeg(){
    
  $meg = "Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Record has been saved successfully..!',
  showConfirmButton: false,
  timer: 1500
})";
    echo "<script>";
    echo "window.onload =(event)=>{";
    echo $meg;
    echo "}";
    echo "</script>";
    
   
}




function showEditSucc(){
    
  $meg = "Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Record has been updated successfully..!',
  showConfirmButton: false,
  timer: 1500
})";
    echo "<script>";
    echo "window.onload =(event)=>{";
    echo $meg;
    echo "}";
    echo "</script>";

}












?>