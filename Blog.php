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
<div class="container">
<div class="row mt-4">
     <div class="col-sm-8">
   <h1>RESPOSNIVE CMS BLOG  </h1>
    <h1 class="lead">BLOG by using PHP by me</h1>
    <?php
    echo ErrorMessage();
    echo SuccessMessage();
     ?>
  <?php
  global $ConnectingDB;
  $sql= "SELECT * FROM posts ORDER BY id desc ";
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
       <small class="card-title"> Category:
         <a href="Blog.php?category=<?php echo $Category; ?>">
         <span class="heading"><?php echo htmlentities($Category); ?></span>
         </a>
           & Written by
         <a href="Profile.php?username="<?php echo htmlentities ($Admin); ?> ">
         <?php echo htmlentities ($Admin); ?>
       </a>
         On <?php echo htmlentities ( $DateTime); ?> </small>
    <span class="badge badge-dark text-light float-right" style="float:">Comments
       <?php ApproveCommentsAccordingtoPost($PostId) ; ?></span>

      <hr>
       <p class="card-text"><?php
  if(strlen($PostDescription )>150){
    $PostDescription= substr($PostDescription, 0 ,150)."...";
  }  echo htmlentities ($PostDescription); ?>
       </p>
       <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
         <span class="btn btn-info">Read More >> </span>
       </a>
    </div>
</div>
<?php } ?>
<!-- Pagination  -->
 <nav>
 <ul class="pagination pagination-lg">
   <!-- backward button  -->
      <?php if(isset($Page)){
         if($Page>1){ ?>
      <li class="page-item">
       <a href="Blog.php?page=<?php echo $Page-1;  ?>" class="page-link">&laquo;</a>
      </li>
   <?php   } } ?>
<?php
global $ConnectingDB;
$sql = "SELECT COUNT(*) FROM posts";
$stmt =$ConnectingDB->query($sql);
$RowPagination =$stmt->fetch();
$TotalPosts=array_shift($RowPagination);

$PostPagination=$TotalPosts/5;
$PostPagination=ceil($PostPagination); //arondir 4.25 on 5;

for ($i=1; $i <=$PostPagination; $i++){
  if(isset($Page)){
              if($i==$Page){ ?>
       <li class="page-item active">
        <a href="Blog.php?page=<?php echo $i;  ?>" class="page-link"><?php echo $i; ?></a>
       </li>
           <?php
              } else{
            ?>
        <li class="page-item">
         <a href="Blog.php?page=<?php echo $i;  ?>" class="page-link"><?php echo $i; ?></a>
        </li>

    <?php }

  } }  ?>

 <!-- forward button  -->
    <?php if(isset($Page)&&!empty($Page)){
       if($Page+1<=$PostPagination){ ?>
    <li class="page-item">
     <a href="Blog.php?page=<?php echo $Page+1;  ?>" class="page-link">&raquo;</a>
    </li>
 <?php   }} } ?>
 </ul>

</nav>



     </div>

     <!-- side  Area -->
     <div class="col-sm-4" style="min-height:40px; background: white;">
            <div class="card mt-4">
            <div class="card-body">
               <img src="images/stratblog.png" class="d-block img-fluid mb-3" alt="">
                 <div class="text-center">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
        mollit anim id est laborum.
                 </div>
            </div>
            </div>
<br>
<div class="card">
     <div class="card-header bg-dark text-light">
     <h2 class="lead"> Sign up! </h2>

     </div>
         <div class="card-body">
           <button type="button" class="btn btn-success btn-block text-center text-white" name="buton">join the forum</button>
            <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="buton">join the forum</button>
            <div class="input-group mb-3">
            <input type="text" class="form-control" name="" placeholder="Enter email" value="">
             </div>
           <div class="input-group-append">
           <button type="button" class="btn btn-primary btn-block text-center text-white" name="buton">Subscribe now</button>
           </div>
          </div>
</div>
     </div>
     <br>
       <div class="card">
             <div class="card-header bg-primary text-light">
          <h2 class="lead"> Categories </h2>
           </div>
                   <div class='card-body'>
                  <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM category ORDER BY id desc";
                  $stmt =  $ConnectingDB->query($sql);
                  while($DataRows = $stmt->fetch()){
                    $CategoryId = $DataRows["id"];
                    $CategoryName = $DataRows["title"];

                   ?>
                   <a href="Blog.php?category=<?php echo $CategoryName; ?>">
                   <span class="heading"><?php echo $CategoryName; ?></span>
                   </a>
                   <br>
                 <?php } ?>
               </div><br>
    <!-- show recent post -->

    <div class="card">
       <div class="card-header bg-info text-white">
         <h2 class="lead">Recents Posts </h2>
       </div>
    <div class="card-body">
      <?php
      global $ConnectingDB;
      $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
      $stmt =  $ConnectingDB->query($sql);
      while($DataRows = $stmt->fetch()){
        $Id = $DataRows["id"];
        $Title = $DataRows["title"];
        $DateTime = $DataRows['datetime'];
        $Image = $DataRows['image'];

       ?>
    <div class="media">
      <img src="Uploads/<?php echo htmlentities($Image) ; ?>" class="d-block img-fluid align-self-start" width="90" height="90" alt="">
       <div class="media-body ml-2">
         <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
       <h6 class="lead"><?php echo htmlentities($Title); ?></h6>
         </a>
       <p class="small"><?php echo htmlentities($DateTime);?> </p>
       </div>

    </div>
      <hr>
  <?php } ?>
    </div>


       </div>
     <!-- end side area -->
</div>
</div>
<!-- end header-->
<!-- Main area-->


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
