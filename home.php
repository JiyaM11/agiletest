<?php
include("include/config.php");
if (!isset($_SESSION["username"]) || $_SESSION["username"] == "" ){
header("location:index.php");
}
$uname=$_SESSION["username"];
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
<a class="au-btn au-btn-icon au-btn--blue text-white" href="add_test.php">
<i class="zmdi zmdi-plus"></i>ADD ITEM</a>
</div>
</div>
</div>

<div class="row m-t-25">
<div class="col-lg-12">
<?php	
define("ROW_PER_PAGE",20);
$search_keyword = '';
if(!empty($_POST['search']['keyword'])) {
$search_keyword = $_POST['search']['keyword'];
}
//$sql = 'SELECT * FROM tbl_test WHERE title LIKE :keyword ORDER BY id DESC';
$sql = 'SELECT * FROM tbl_test WHERE CONCAT(title, description) LIKE :keyword ORDER BY id DESC';

/* Pagination Code starts */
$per_page_html = '';
$page = 1;
$start=0;
if(!empty($_POST["page"])) {
$page = $_POST["page"];
$start=($page-1) * ROW_PER_PAGE;
}
$limit=" limit " . $start . "," . ROW_PER_PAGE;
$pagination_statement = $DB->prepare($sql);
$pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
$pagination_statement->execute();

$row_count = $pagination_statement->rowCount();
if(!empty($row_count)){
$per_page_html .= "<div class='form-group'><div class='col-sm-12'>";
$page_count=ceil($row_count/ROW_PER_PAGE);
if($page_count>1) {
for($i=1;$i<=$page_count;$i++){
if($i==$page){
$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
} else {
$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
}
}
}
$per_page_html .= "</div></div>";
}

$query = $sql.$limit;
$pdo_statement = $DB->prepare($query);
$pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
?>
<form name='frmSearch' action='' method='post'>

<div class="form-group">
<div class="col-sm-12"><input type='text' name='search[keyword]' value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25' class="form-control">
</div>
</div>
<table  class='table-bordered table table-hover'>
<thead>
<tr class='bg-theme text-light'>
<th class='text-center'>TITLE</th>
<th class='text-center'>DESCRIPTION</th>
<th class='text-center'>DATE</th>
<th class='text-center'>SELECT</th>
</tr>
</thead>
<tbody id='table-body'>
<?php
if(!empty($result)) { 
foreach($result as $row) {
?>
<tr class='bg-theme-gray text-center'>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['description']; ?></td>
<td><?php echo $row['test_date']; ?></td>
<td><a href ='edit_test.php?id=<?php echo $row["id"] ?>' class="btn btn-primary"> Edit </a><a href ='delete_test.php?id=<?php echo $row["id"]?>' class="btn btn-danger"> Delete </a></td>
</tr>
<?php } } ?>
</tbody>
</table>
<?php echo $per_page_html; ?>
</form>
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
</body>

</html>
<!-- end document-->