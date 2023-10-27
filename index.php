<?php
include("include/config.php");
// if (isset($_SESSION["username"]) || $_SESSION["username"] != "") {
//     //if user already logged in
//     redirect("view_order.php");
// }

$errMSG = "";
//$_SESSION['up_name']=$_POST['up_name'];

if (isset($_POST["mode"]) && $_POST["mode"] == "login") {

    //validate userinput for security checks
    // add addslashes() function to prevent from sql injections
    $uname = trim($_POST["uname"]);
    $pass = trim($_POST["upass"]);
	
    $rem = trim($_POST["remember_me"]);

    if ($uname == "" || $pass == "") {
        $errMSG = errorMessage("Enter credentials properly!");
    } else {

        // check if username exist 
       $sql = "SELECT * FROM admin where username = :uname";
        try {
            $stmt = $DB->prepare($sql);
            $stmt->bindValue(":uname", $uname);
            $stmt->execute();
            $usernameRS = $stmt->fetchAll();
        } catch (Exception $ex) {
            echo errorMessage($ex->getMessage());
        }

        if (count($usernameRS) > 0) {
            // user exist
           $sql = "SELECT * FROM admin where username = :uname AND password = :pwd";
            try {
                $stmt = $DB->prepare($sql);
                $stmt->bindValue(":uname", $uname);
                $stmt->bindValue(":pwd", encryptPassword($pass));
                
                $stmt->execute();
                $userRS = $stmt->fetchAll();
            } catch (Exception $ex) {
                echo errorMessage($ex->getMessage());
            }

            if (count($userRS) > 0 ) {
                // user exist 
                // now check if the status of the user
                if ($userRS[0]["status"] == 'Y') {

                    $_SESSION["username"] = $userRS[0]["username"];

                    if ($rem == 1) {
                        // if user select to remember 
                        setcookie("userame", $uname, time() + 3600);
                    } else {
                        setcookie("userame", $uname, time() - 3600);
                    }

                    redirect("home.php");
                } else {
                    // user exist but the status is inactive
                    $errMSG = errorMessage("Sorry!!! But the account is temporary suspended.");
                }
            } else {
                $errMSG = errorMessage("Sorry!!! Either the username of the password mismatch.");
            }
        } else {
            // no user exist with same name
            $errMSG = errorMessage("Sorry!!! No user with such name exist");
        }
    }
}
$userame = (isset($_COOKIE["userame"]) && $_COOKIE["userame"] != "") ? $_COOKIE["userame"] : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
<script type="text/javascript">
    if (document.addEventListener) {
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        }, false);
    } else {
        document.attachEvent('oncontextmenu', function() {
            window.event.returnValue = false;
        });
    }
</script>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <h1>PHP Assignment</h1>
                            </a>
                            <?php echo $errMSG; ?>
                        </div>
                        <div class="login-form">
                             <form method="post" action="" name="myform" class="form">
                            <input type="hidden" value="login" name="mode" />
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="au-input au-input--full" type="text" name="uname" value="<?php echo $userame; ?>" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="upass" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label></label>
                                    <input type="checkbox" value="1" name="remember_me" <?php echo ($userame != "") ? 'checked' : ''; ?>> Remember me
                                </div>
                              
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="login">sign in</button>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->