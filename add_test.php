<?php
include("include/config.php");
if (!isset($_SESSION["username"]) || $_SESSION["username"] == "" ){
	header("location:index.php");
}

if (isset($_POST['submit']))
{
    $title=trim($_POST["title"]);
    $description=trim($_POST["description"]);
    $upload_date=date('Y-m-d H:i:s');

    $sqlimg = "INSERT INTO tbl_test(title, description) VALUES ('$title', '$description')";
    $DB->exec($sqlimg);
    $last_id = $DB->lastInsertId();
    header('Location:home.php');
	 
 }
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

<?php include('include/styles.php'); ?>

</head>

<body class="">
<div class="page-wrapper">
<!-- MENU SIDEBAR-->
<?php include('include/header.php'); ?>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
            <!-- HEADER DESKTOP-->
        <?php include('include/header-user.php'); ?>
            <!-- HEADER DESKTOP-->

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Test Overview</h2>
                            <a class="au-btn au-btn-icon au-btn--blue text-white" href="home.php"><i class="zmdi zmdi-plus"></i>VIEW LIST</a>
                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-lg-12">
                        <div class="card">
                        <form class="form" method="post" id="form" action="add_test.php" enctype="multipart/form-data">
                            <div class="card-header"><strong>Manage Test</strong></div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Title</label>
                                    <div class="col-sm-9">
                                    <input type="text" placeholder="Enter Title" name="title" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-3">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="5" name="description" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="submit" id="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                <a href="home.php" class="btn btn-danger"><i class="fa fa-ban"></i> Cancle </a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include('include/footer.php'); ?>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
</div>
</div>

<!-- Jquery JS-->
<?php include('include/scripts.php'); ?>
<script>
 if (document.addEventListener) {
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        }, false);
    } else {
        document.attachEvent('oncontextmenu', function() {
            window.event.returnValue = false;
        });
    }
/*----------------------------------------------------------------------------------------------*/
function isNumberKey(evt){ 
	var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
	}		   
    function ValidateAlpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if (keyCode > 47 && keyCode < 58)
        return false;
        return true;
    }
/*----------------------------------------------------------------------------------------------*/

</script>
</body>

</html>
<!-- end document-->
