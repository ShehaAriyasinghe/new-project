<?php
session_start();
include 'function.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ThusithaServiceCentre-HONDA</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/login.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/mystyle.css" rel="stylesheet" type="text/css"/>
        


<style>
    body {
        background-image: url('assets/images/center20.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        
        
    }
</style>



        
        
        
        
        
    </head>
    <body class="text-center">
        <div class="container">
            <div class="row ">

                <div class="col-md-8">
                    <!--<img src="assets/images/center21.jpg" alt="..." width="580" height="350">-->

                </div>




                <div class="col-md-4 form-signin">
                    <div class="card bg-dark p-2">
                        <img src="assets/images/honda.png" class="card-img" width="250px" height="120px" alt="...">
                        
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
                            
                            <h1 class="h3 mb-3 fw-normal my-card">Please Sign In</h1>


                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                //Get post variable data
                                extract($_POST);
                                //create errors array
                                $messages = array();

                                //required validation
                                if (empty($user_name)) {

                                    $messages['error_user_name'] = "The Email address should not be empty...!";
                                }

                                if (empty($password)) {

                                    $messages['error_password'] = "The Password should not be empty...!";
                                }  
                               
                                //check valid login
                                if (empty($messages)) {
                                    $db = dbconn();
                                    $password = sha1($password);
                                    $sql = "SELECT u.username,u.password,u.userid,u.accountstatus,e.firstname,"
                                            . "e.lastname,u.userrole,e.designation,e.image FROM tbl_users u INNER JOIN "
                                            . "tbl_employees e ON e.userid=u.userid WHERE u.username='$user_name' "
                                            . "AND u.password='$password' AND u.accountstatus='active' AND "
                                            . "u.deletestatus='1'";
                                    $result = $db->query($sql);
                                    if ($result->num_rows <= 0) {
                                        $messages['error_login'] = "Invalid Username or Password";
                                    } else {
                                        $row = $result->fetch_assoc();
                                        // load data to session variables
                                        $_SESSION['userid'] = $row['userid'];
                                        $_SESSION['firstname'] = $row['firstname'];
                                        $_SESSION['lastname'] = $row['lastname'];
                                        $_SESSION['userrole'] = $row['userrole'];
                                        $_SESSION['username'] = $row['username'];
                                        $_SESSION['image']=$row['image'];
                                        header("Location:index.php");
                                    }
                                }
                            }
                            ?>
                            
                            
                            <div>
                                <p class="text-danger"><?php echo @$messages['error_user_name']; ?></p>
                                <p class="text-danger"><?php echo @$messages['error_password']; ?></p>
                                <p class="text-danger"><?php echo @$messages['error_login']; ?></p>
                            </div>
                            <div class="form-floating">
                                <input type="email" class="form-control" name="user_name" id="user_name" value="<?php echo @$user_name ?>" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>


                            <button class=" btn btn-md card-btn mb-2 mt-2" type="submit">Sign in</button>

                        </form>
                    </div>

                </div>   
            </div>
        </div>



    </body>
</html>
