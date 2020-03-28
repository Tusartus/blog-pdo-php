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
           <a href="Blog.php" class="nav-link"><i class="fa fa-user ml-2 text-success" aria-hidden="true"></i>
              Home    </a>
         </li>
         <li class="nav-item">
           <a href="Dashboard.php" class="nav-link">About us</a>
         </li>
         <li class="nav-item">
           <a href="Blog.php" class="nav-link">Blog</a>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">Contact us</a>
         </li>
         <li class="nav-item">
           <a href="#" class="nav-link">Features</a>
         </li>
         <li class="nav-item">
           <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
         </li>

     </ul>
     <ul class="navbar-nav ml-auto">
     <form class="form-inline d-none d-sm-block" action="Blog.php">
            <div class="form-group">
   <input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
    <button type="button" class="btn btn-primary" name="SearchButton">Go</button>
  <?php
  global $ConnectingDB;
  if(isset($_GET["SearchButton"])) {
      $Search = $_GET["Search"];
      $sql = "SELECT * FROM posts
      WHERE datetime Like :search
       OR category LIKE :search
     OR post LIKE :search";
     $stmt = $ConnectingDB->prepare($sql);
     $stmt->bindValue(':search','%'.$Search. '%');
     $stmt->execute();
  }
// THE DEFAULT SQL QUERY
else {
  $PostIdFromURL = $_GET["id"];
  if(!isset($PostIdFromURL)){
    $_SESSION["ErrorMessage"] =" bad request";
    Redirect_to("Blog.php");
  }
  $sql= "SELECT * FROM posts WHERE id= '$PostIdFromURL'";
  $stmt = $ConnectingDB->query($sql);
}

  while ($DateRows = $stmt->fetch()){
    $PostId = $DataRows["id"];
    $DateTime =$DataRows["datetime"];
    $PostTitle =$DataRows["title"];
    $Category =$DataRows["category"];
    $Admin =$DataRows["author"];
    $Image =$DataRows["image"];
    $PostDescription =$DataRows["post"];

   ?>


           </div>
           </form>

      </ul>
        </div>
    </div>

</nav>
<div style="height:10px; background:#81CC5C;"></div>
<!-- nav end -->
<div class="container">
<div class="row mt-4">
     <div class="col-sm-8">
   <h1>RESPOSNIVE CMS BLOG  </h1>
    <h1 class="lead">BLOG by using PHP by me</h1>

  <?php
  global $ConnectingDB;
  $sql= "SELECT * FROM posts ORDER BY id desc";
  $stmt = $ConnectingDB->query($sql);
  while ($DateRows = $stmt->fetch()){
    $PostId = $DataRows["id"];
    $DateTime =$DataRows["datetime"];
    $PostTitle =$DataRows["title"];
    $Category =$DataRows["category"];
    $Admin =$DataRows["author"];
    $Image =$DataRows["image"];
    $PostDescription =$DataRows["post"];

   ?>
 <div class="card">
   <img src="Uploads/<?php echo htmlentities ($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
   <div class="card-body">
       <h4 class="card-title"><?php echo htmlentities($PostTitle);  ?></h4>
       <small class="card-title">Written by <?php echo htmlentities ($Admin); ?> On <?php echo htmlentities ( $DateTime); ?> </small>
    <span class="badge badge-dark text-light float-right" style="float:">Comments 20</span>

      <hr>
       <p class="card-text"><?php echo htmlentities ($PostDescription); ?>
       </p>

    </div>
</div>
<?php } ?>

     </div>
     <div class="col-sm-4">


     </div>

</div>
</div>
<!-- end header-->
<!-- Main area-->


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
