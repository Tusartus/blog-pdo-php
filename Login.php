<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/Functions.php'); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_POST["Submit"])){
  $Username = $_POST["Username"];
  $Password = $_POST["Password"];

  if(empty($UserName) || empty($Password)){
    $_SESSION["ErrorMessage"]=" All fields must be filled out";
    Redirect_to("Login.php");
  }else{
    //check username and password in db
 $Found_Account =Login_Attempt($UserName, $Password);
 if($Found_Account){
   $_SESSION["UserId"]= $Found_Account["id"];
   $_SESSION["UserName"]= $Found_Account["username"];
   $_SESSION["AdminName"]= $Found_Account["aname"];

   $_SESSION["SuccesMessage"]="Welcome " .$_SESSION["AdminName"];
   Redirect_to("Dashboard.php");
 }else{
   $_SESSION["ErrorMessage"]="Incorrevct username /password  Admin";
   Redirect_to("Login.php");
 }



  }
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

        </div>
    </div>

</nav>
<div style="height:10px; background:#81CC5C;"></div>
<!-- nav end -->

<header class="bg-dark text-white py-3">
   <div class="container">
     <div class="row">
       <div class="col-md-12">


        </div>

      </div>

    </div>
</header>
<!-- end header-->
<!-- Main area-->
<section class="container py-2 mb-4">
  <div class="row">
           <div class="offset-sm-3 col-md-6 style="background:red;min-height:500px;">
             <br><br>
             <?php
             echo ErrorMessage();
             echo SuccessMessage();
              ?>
             <div class="card bg-secondary text-light">
                 <div class="card-header">
                     <h4>Welcome Back </h4>
                       </div>
                      <div class="card-body bg-dark">
                         <form class="" action="Login.php" method="post">
                           <div class="form-group">
                          <label for="username"></span class="FieldInfo">Username :</span></label>
                          <div class="input-group mb-3">
                           <div class="input-group-prepend">
                          <span class="input-group-text text-white bg-info"><i class="fa fa-user"></i></span>
                           </div>
                              <input type="text" class="form-control" name="Username" id="username" value="">
                           </div>
                         </div>

                         <div class="form-group">
                        <label for="pasword"></span class="FieldInfo">Password :</span></label>
                        <div class="input-group mb-3">
                         <div class="input-group-prepend">
                        <span class="input-group-text text-white bg-info"><i class="fa fa-user"></i></span>
                         </div>
                            <input type="password" class="form-control" name="Password" id="username" value="">
                         </div>
                       </div>
                       <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">

                         </form>
                     </div>
                 </div>

            </div>


    </div>
 </div>



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
