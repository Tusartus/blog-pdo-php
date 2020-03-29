<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/Functions.php'); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_GET["id"])){
   $SearchQueryParameter = $_GET["id"];
   global $ConnectingDB;
   $Admin = $_SESSION["AdminName"];
   $sql = "UPDATE comments Set status='ON',approvedby='$Admin' WHERE id = '$SearchQueryParameter'";

   $Execute = $ConnectingDB->query($sql);
   if($Execute) {
     $_SESSION["SuccessMessage"]="Comment Approved successfully";
     Redirect_to["Comments.php"];

   }else{
     $_SESSION["ErrorMessage"]="Something went wrong try again";
     Redirect_to["Comments.php"];
   }



}


 ?>
