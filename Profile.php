<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/Functions.php'); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!-- fetch existing data  -->
<?php
$SearchQueryParameter = $_GET["username"];
global $ConectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins Where username=:username";
$stmt=$ConnectingDB->prepare($sql);
$stmt->bindvalue(':username', $SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
if($Result==1){
  while ($DataRows = $stmt->fetch()){
      $ExistingName = $DataRows['aname'];
      $ExistingUsername = $DataRows['username'];
      $ExistingHeadline = $DataRows['aheadline'];
      $ExistingBio = $DataRows['abio'];
      $ExistingImage = $DataRows['aimage'];
  }
}
else{
  $_SESSION["ErrorMessage"] = "Bad request";
  Redirect_to("Blog.php?page=1");
}

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
    //query when Pagination is Active ie Blog.php?Page=1
    elseif (isset($_GET["Page"])){

    $Page = $_GET["Page"];
              if($Page==0 || $Page<1){
              $ShowPostFrom =0;
              }else{
              $ShowPostFrom($Page*5)-5; //show 4 post per page
               }


   $sql ="SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom ,5";
   $stmt = $ConnectingDB->query($sql);
    }
  // THE DEFAULT SQL QUERY
  else {

    $sql= "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
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

<header class="bg-dark text-white py-3">
   <div class="container">
     <div class="row">
       <div class="col-md-6">
           <h1><i class="fa fa-user mr-3 text-success" style="color:yellow"></i>
   <?php echo $ExistingName; ?>
           </h1>
   <h3> <?php echo $ExistingHeadline; ?> </h3>

        </div>

      </div>

    </div>
</header>
<!-- end header-->
<!-- Main area-->
<section class="container py-2 mb-4">
 <div class="row">
   <div class="col-md-3">
    <img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluid rounded-circle mb-3" alt="">
  </div>
  <div class="col-md-9">
   <div class="card">
       <div class="card-body">
   <p class="lead">
<?php echo $ExistingBio; ?>
   </p>
       </div>
   </div>

  </div>


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
