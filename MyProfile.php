<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/Functions.php'); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingUrl"]=$_SERVER["PHP_SELF"];
//protect page first login
 Confirm_Login(); ?>

<?php
//fecthing existing admin data
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins Where id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()){
    $ExistingName = $DataRows['aname'];
    $ExistingUsername = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
}
//end fecthing existing admin data

if(isset($_POST["Submit"])){
  $AName = $_POST["Name"];
  $AHeadline = $_POST["Headline"];
  $ABio = $_POST["Bio"];
  $Image  =$_FILES["Image"]["name"];
  $Target = "Images/".basename($_FILES["Image"]["name"]);

  if(empty($AHeadline >12)){
    $_SESSION["ErrorMessage"] = "Headline should be less than 12 characters";
    Redirect_to("MyProfile.php");
  }elseif (strlen(ABio)<499){
    $_SESSION["ErrorMessage"] = "Bio SHOULD BE LESS THAN  500 characters";
    Redirect_to("MyProfile.php");

}else{

  // query to update profile
   global $ConnectingDB;
   if(!empty($_FILES["Image"]["name"])){
     $sql = "UPDATE admins SET
     aname='$AName', aheadline='$AHeadline', aimage='$Image', abio='$ABio'
      WHERE id='$AdminId' ";   //aname aimage aheadline abio from database table admins
   }else{
     $sql = "UPDATE admins SET
     aname='$AName', aheadline='$AHeadline',  abio='$ABio'
      WHERE id='$AdminId' ";
   }


$Execute =$ConnectingDB-> query($sql);
  move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);


   if($Execute){
     $_SESSION["SuccessMessage"]="Details Updated  successfully";
     Redirect_to("MyProfile.php");
   }else {
     $_SESSION["ErrorMessage"]="Something went wrong";
     Redirect_to("MyProfile.php");
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
           <h1><i class="fa fa-user mr-3" style="color:yellow"></i> My Profile</h1>

        </div>

      </div>

    </div>
</header>
<!-- end header-->
<!-- Main area-->

<section class="container py-2 mb-4">
  <div class="row">
<!-- left area -->
<div class="col-md-3">
 <div class="card">
 <div class="card-header bg-dark text-light">
  <h3><i class="fa fa-user  text-success mr-2"> <?php echo $ExistingUsername; ?> </i></h3>
 <small> <?php  echo $ExistingHeadline; ?></small>
</div>
<div class="card-body">
 <img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid" alt="">
 <div class="card-text">
  <?php  echo $ExistingBio; ?>
 </div>
 



</div>


 </div>
 </div>




</div>
<!-- right area -->
    <div class="col-md-9" style="min-height:400px;">
      <?php
      echo ErrorMessage();
      echo SuccessMessage();
       ?>
      <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
           <div class="card bg-secondary text-light mb-3">
                      <div class="card- bg-secondary text-light">
           <h1>Edit profile</h1>
                      </div>
         <div class="card-body bg-dark">
              <div class="form-group">
                   <label for="title"><span class="FieldInfo">Name: </span> </label>
                     <input  class="form-control" type="text" name="Name" id="title" placeholder="type title here">
              </div>
              <div class="form-group">
                   <label for="title"><span class="FieldInfo">Headline: </span> </label>
                     <input  class="form-control" type="text" name="Headline" id="title" placeholder="type title here">
                     <span class="text-danger">Not more than 12 characters </span>
              </div>
              <div class="form-group">

        <textarea class="form-control" id="Post" placeholder="bio here .." name="Bio" rows="8" cols="80"></textarea>
              </div>

               <div class="form-group mb-1">
                    <div class="custom-file">

                  <input class="custom-file-input" type="File" id="imageSelect" name="Image" value="">
                    <label for="ImageSelect" class="custom-file-label"> Select Image  </label>
                    </div>
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
