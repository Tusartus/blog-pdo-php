<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/Functions.php'); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php

//folder/posts.php
$_SESSION["TrackingUrl"]=$_SERVER["PHP_SELF"];

//protect page first login
 Confirm_Login(); ?>



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
           <h1><i class="fa fa-blog mr-3" style="color:yellow"></i>Dashboard </h1>
        </div>
<div class="col-lg-3 mb-2">
  <a href="AdNewPost.php" class="btn btn-primary btn-block">
    <i class="fa fa-edit"></i>Add New Post
 </a>
</div>

<div class="col-lg-3  mb-2">
  <a href="Categories.php" class="btn btn-info btn-block">
    <i class="fa fa-folder-plus"></i>Add New  Category
 </a>
</div>
<div class="col-lg-3  mb-2">
  <a href="Admins.php" class="btn btn-warning btn-block">
    <i class="fa fa-user-plus"></i>Add New   Admin
 </a>
</div>
<div class="col-lg-3  mb-2">
  <a href="Comments.php" class="btn btn-success btn-block">
    <i class="fa fa-check"></i>Add New  Comments
 </a>
</div>



      </div>
    </div>
</header>
<!-- end header-->
<!-- Main area-->
<section class="container py-2 mb-4">
<div class="row">
  <div class="col-lg-12">
    <?php
    echo ErrorMessage();
    echo SuccessMessage();
     ?>
     <!-- left side area start  -->
<div class="col-lg-2 d-none d-md-block">
   <div class="card text-center bg-dark text-white mb-3">
     <div class="card-body">
     <h1 class="lead"> Posts</h1>
       <h4 class="display-5"> <i class="fa fa-readme"></i>
   <?php
 TotalPosts();

    ?>

       </h4>

     </div>
     </div>
     <div class="card text-center bg-dark text-white mb-3">
       <div class="card-body">
       <h1 class="lead"> Categories</h1>
         <h4 class="display-5"> <i class="fa fa-folder"></i>
           <?php
     TotalCategories();

            ?>
            </h4>

       </div>
       </div>
       <div class="card text-center bg-dark text-white mb-3">
         <div class="card-body">
         <h1 class="lead"> Admins</h1>
           <h4 class="display-5"> <i class="fa fa-user"></i>
             <?php

       TotalAdmins();
              ?>
             </h4>

         </div>
         </div>
         <div class="card text-center bg-dark text-white mb-3">
           <div class="card-body">
           <h1 class="lead">Comments</h1>
             <h4 class="display-5"> <i class="fa fa-comments"></i>
               <?php
         TotalComments();
                ?>

                </h4>

           </div>
           </div>



</div>
 <!-- end  left side area   -->
 <!--  right side area   -->
<div class="col-lg-10">
  <h1> Top Posts </h1>
  <table class="table table-striped table-hover">
     <thead class="thead-dark">
       <tr>
     <th> No. </th>
     <th>Title </th>
     <th> Date&Time </th>
     <th> Author</th>
     <th>Comments </th>
     <th> Details</th>

       </tr>
     </thead>
   <?php
global $ConnectingDB;
$sql= "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
$stmt = $ConnectingDB->query($sql);
while($DataRows=$stmt->fetch()){
  $PostId= $DataRows["id"];
  $DateTime = $DataRows["datetime"];
  $author = $DataRows["author"];
  $Title = $DataRows["title"];
  $SrNo++;



    ?>
    <tbdoy>
  <tr>
<td>  <?php echo $SrNo; ?> </td>
<td>   <?php echo $Title; ?>   </td>
<td>   <?php echo $DateTime; ?>   </td>
<td>   <?php echo $Author; ?>   </td>
<td>


<?php
 $Total=ApproveCommentsAccordingtoPost($PostId);
if($Total){
  ?>
    <span class="badge badge-success">
      <?php
  echo $Total; ?>
  </span>

<?php } ?>

    </span>

</td>
<td>


<?php
$Total = DisApproveCommentsAccordingtoPost($PostId);
if($Total){
  ?>
    <span class="badge badge-danger">
      <?php
  echo $Total; ?>
  </span>
<?php } ?>
    </span>

</td>

<td><a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>" <span class="btn btn-info"> Preview </span> </a></td>

  </tr>

</tbody>

  <?php } ?>
  </table>

</div>

 <!-- end  right side area   -->
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
