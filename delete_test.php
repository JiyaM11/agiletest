<?php
  	include("include/config.php");
  	$id = $_GET['id'];
	//delete an orignal record from db
	$delete_stmt = $DB->prepare('delete from tbl_test where id=:id');
	$delete_stmt->bindParam(':id', $id);
	$delete_stmt->execute();
    if ($delete_stmt==true) { header('location:home.php'); }
?>