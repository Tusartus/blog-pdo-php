<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/Functions.php'); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
//protect page first login
 Confirm_Login(); ?>
<?php
$SearchQueryParameter = $_GET['id'];
if(isset($_POST["Submit"])){
  $PostTitle = $_POST["PostTitle"];
  $Category = $_POST["Category"];
  $Image  =$_FILES["Image"]["name"];
  $Target = "Uploads/".basename($_FILES["Image"]["name"]);
  $PostText =$_POST["PostDescription"];
  $Admin = "developer";
  date_default_timezone_set("Europe/Berlin");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"] = "Title can be empty";
    Redirect_to("Posts.php");
  }elseif (strlen($PostTitle)<5){
    $_SESSION["ErrorMessage"] = "Post title should be greater than 5 characters";
    Redirect_to("Posts.php");

  }elseif (strlen($PostText) > 99999){
      $_SESSION["ErrorMessage"] = "Post Description should be less than 10000 characters";
      Redirect_to("Posts.php");

}else{
  // query to update posts
   global $ConnectingDB;
   if(!empty($_FILES["Image"]["name"])){
     $sql = "UPDATE posts SET
     title='$PostTitle', category='$Category', image='$Image', post='$PostText'
      WHERE id='$SearchQueryParameter' ";
   }else{
     $sql = "UPDATE posts SET
     title='$PostTitle', category='$Category', post='$PostText'
      WHERE id='$SearchQueryParameter' ";
   }


$Execute =$ConnectingDB-> query($sql);
  move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

   if($Execute){
     $_SESSION["SuccessMessage"]=" Post Updated successfully";
     Redirect_to("Posts.php");
   }else {
     $_SESSION["ErrorMessage"]="something went wrong";
     Redirect_to("Posts.php");
   }

}


} //end if submit button

 ?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>blog cms</title>
  <link rel="stylesheet" href="Css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">blog.com</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNav">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item">
           <a href="Myprofile.php" class="nav-link"><i class="fa fa-user ml-2 text-success" aria-hidden="true"></i>
              My profile     </a>
         </li>
         <li class="nav-item">
           <a href="Dashboard.php" class="nav-link">Dashboard</a>
         </li>
         <li class="nav-item">
           <a href="Posts.php" class="nav-link">Posts</a>
         </li>
         <li class="nav-item">
           <a href="Categories.php" class="nav-link">Categories</a>
         </li>
         <li class="nav-item">
           <a href="Admins.php" class="nav-link">Manage Admin</a>
         </li>
         <li class="nav-item">
           <a href="Comments.php" class="nav-link">comments</a>
         </li>
         <li class="nav-item">
           <a href="Blog.php" class="nav-link">live blog</a>
         </li>
     </ul>
     <ul class="navbar-nav ml-auto">
       <li class="nav-item">
         <a href="Logout.php" class="nav-link"><i class="fa fa-user-times ml-2 text-danger"></i>Logout</a>
       </li>
      </ul>
        </div>
    </div>

</nav>
<div style="height:10px; background:#81CC5C;"></div>
<!-- nav end -->

<header class="bg-dark text-white py-3">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
           <h1><i class="fa fa-edit mr-3" style="color:yellow"></i>Manage Categories</h1>

        </div>

      </div>

    </div>
</header>
<!-- end header-->
<!-- Main area-->

<section class="container py-2 mb-4">
  <div class="row">
    <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
      <?php

     //fetching existing content
     global $ConnectingDB;
     $SearchQueryParameter = $_GET["id"];
     $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
     $stmt =$ConnectingDB ->query($sql);
     while ($DataRows=$stmt->fetch()){
       $TitleToBeUpdated =$DataRows['title'];
       $CategoryTobeUpadated = $DataRows['category'];
       $ImageTobeUpadated = $DataRows['image'];
       $PostTobeUpadated = $DataRows['post'];
       //code ...




     }





       ?>
      <form class="" action="EditPost.php?id=<?php echo $SearchQueryParameter;  ?>" method="post" enctype="multipart/form-data">
           <div class="card bg-secondary text-light mb-3">
                      <div class="card-header">
           <h1>         EDIT  Post</h1>
                      </div>
         <div class="card-body bg-dark">
              <div class="form-group">
                   <label for="title"><span class="FieldInfo">Post title: </span> </label>
                     <input  class="form-control" type="text" name="PostTitle" id="title" value="<?php  echo $TitleToBeUpdated; ?>">
              </div>
              <div class="form-group">
                 <span class="FieldInfo">Existing Category: </span>
                 <?php echo  $CategoryTobeUpadated; ?>  <br>
                   <label for="CategoryTitle"><span class="FieldInfo">choose category: </span> </label>
                     <select  class="form-control"  name="Category" id="CategoryTitle">
                     <?php
           //fecth all the categories from category table
              global $ConnectingDB;
              $sql = "SELECT id,title FROM category";
              $stmt = $ConectingDB->query($sql);
              while($DateRows = $stmt->fetch()){
                $Id= $DateRows["id"];
                $CategoryName = $DateRows["category"];
                  ?>
                <option value=""><?php $CategoryName; ?></option>

               <?php } ?>

                     </select>
              </div>

               <div class="form-group mb-1">
                  <span class="FieldInfo">ExistingImage: </span>
                  <img class="mb-2" src="Uploads/<?php echo $ImageTobeUpadated; ?>" width:"" 170px"; height: "70px"; >
                    <div class="custom-file">

                  <input class="custom-file-input" type="File" id="imageSelect" name="Image" value="">
                    <label for="ImageSelect" class="custom-file-label"> Select Image  </label>
                    </div>
               </div>
            <div class="form-group">
      <label for="CategoryTitle"><span class="FieldInfo">Post: </span> </label>
      <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
        <?php echo $PostTobeUpadated; ?>
      </textarea>
            </div>

              <div class="row" style="min-height:50px; background:#D5FFBF;">
                 <div class="col-lg-6">
         <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas f-arrow-left"></i>Back to Dashboard</a>
                 </div>
                 <div class="col-lg-6">
         <button type="submit" name="Submit" class="btn btn-success btn-block">
           <i class="fa fa-check">

           </i>Publish</button>
                 </div>
              </div>



            </div>
           </div>
     </form>
    </div>
  </div>


</section>
<!-- end main area -->



<br><br><br>
<!-- footer -->
<footer class="bg-dark text-white">
   <div class="container">
   <div class="row">
       <div class="col">
     <p class="lead text-center small">Theme By |  me | <span id="year"></span> &copy; ............All right Reserved.</p>
      <p><a style="color:white; text-decoration: none; cursor: pointer;" href="#">

        This site is for practicing coding with php mysql pdo
      </a></p>
       </div>
   </div>
  </div>


</footer>
<div style="height:10px; background:#81CC5C;"></div>


<!-- end  footer -->


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
   $('#year').text(new Date().getFullYear());
  </script>

</body>
</html>
