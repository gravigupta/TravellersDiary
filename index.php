
<?php
session_start();
include 'connection.php';
include 'links.php';

if(isset($_POST['submit']))
{
$email=$_POST['email'];
$password=$_POST['password'];


$emailquery="select * from users where email='$email'";
$equery=mysqli_query($con,$emailquery);
$rows=mysqli_num_rows($equery);

if($rows)
{ 
  $email_array=mysqli_fetch_assoc($equery);
  $db_pass=$email_array['password'];

  $passcheck= password_verify($password,$db_pass);
  if($passcheck)
  {  $user=$email_array['username'];
     $_SESSION['username']=$user;
     $_SESSION['emailid']=$email;
    
     header("location: home.php");

    
    
  }
  else{
      ?>
      <script>
      alert('Password did Not Match!');
      </script>
      
      <?php
  }

}else{
    ?>
    <script>
    alert("E-mail is not registerd!");
    </script>
    <?php
}

}

?>



<head>
<title>Traveller's Diary index page!</title>
</head>
 <body>
<div class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Traveller's Dairy</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsemenu">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse " id="collapsemenu">
   <div class="container justify-content-end">
    <ul class="navbar-nav ">
      <li class="nav-item ">
      <a href="home.php" class="nav-link active">Home</a>
      </li>
      
      <li class="nav-item ">
      <a href="forum2.php" class="nav-link">CommunityForum</a>
      </li>
      <li class="nav-item ">
      <a href="post.php" class="nav-link">Add Post</a>
      </li>
      <li class="nav-item ">
      <a href="login.php" class="nav-link">Login</a>
      </li>
    </ul>
    </div>
  </div>
</div>

<div class="container">
<h1>Welcome! User<a href="post.php">Add Post</a></h1>
</div>


<div class="row mx-1 my-1">
<?php 
 $selectquery="select * from post order by datetime desc";
 $squery=mysqli_query($con,$selectquery);
 
 while($sarray=mysqli_fetch_array($squery))
 {
    ?>
    <div class="col-lg-4 col-md-6 my-1 ">
     <div class="card bg-dark ">
      <div class="card-header">
      <h6 class="bg-success  m-1 px-2 py-1 font-weight-bold badge-pill text-center"><?php echo $sarray['location']; ?></h6>      
      </div>
      <img src="<?php echo $sarray['image']; ?>" class="card-img img-fluid ">
      <div class="card-body">
        <p class="card-text text-info">
         <?php echo $sarray['description']; ?><br>
         <span class=" text-info m-1 px-2 py-1 font-weight-bold badge-pill float-right">
         ~ <a href="userprofile.php?otheruser=<?php echo $sarray['username']; ?>&otheremail=<?php echo $sarray['email']; ?>">
         <?php echo $sarray['username']; ?></a></span>
        </p><br>
        <a href="#c<?php echo $sarray['id']; ?>" class="btn-sm btn-primary text-white mr-2" data-toggle="collapse">View Comments </a>
        <a  data-toggle="modal" data-target="#modallogin" class="btn-sm btn-primary text-white">Comment </a>
        <div id="c<?php echo $sarray['id']; ?>" class="collapse">
          
          
          <?php
         
           $id =$sarray['id'];
           $selectcom="select * from comments where idp=$id order by datetime desc";
           $scom=mysqli_query($con,$selectcom); 

           while($carray=mysqli_fetch_assoc($scom))
           {
            ?>
            <div class="container border rounded my-2" style="background-color:">
              <div class="container p-3">
              <span class="text-info my-1 mx-auto">Posted at: <?php echo $carray['datetime']; ?></span>
              </div>
              <div class="container p-3">
              <p class="ml-3 text-white font-weight-bold "> <?php echo $carray['comment']; ?>
              <span class=" text-info m-1 px-2 py-1 font-weight-bold badge-pill float-right">
              <a class="text-info" href="userprofile.php?otheruser=<?php echo $carray['username']; ?>&otheremail=<?php echo $carray['email']; ?>">
              ~ <?php echo $carray['username']; ?></a></span>
              </p>
              </div>
            </div>

            <?php

           }
          ?>

        </div>
        
      </div>
     </div>
    </div>
<?php
 }
 ?>
 </div>

 <div class="modal fade" id="modallogin">
    <div class="modal-dialog ">
      <div class="modal-content bg-info">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title text-center">Login!</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST" class=" bg-warning text-center mx-auto rounded my-2 " style="border:2px solid grey">
            <div class="form-group mx-2 ">
             <label for="email" class="text-dark font-weight-bold">E-mail:</label><br>
             <input type="email" class="form-control" id="email" name="email" placeholder="Enter E-mail" required>
            </div>
        
            <div class="form-group mx-2">
             <label for="password" class="text-dark font-weight-bold">Password:</label><br>
             <input type="password" class="form-control" id="email" name="password"placeholder="Enter Password"required>
            </div>
            
            <input type="submit" class="btn btn-primary my-2 " value="Login" name="submit">
            <p class="text-white">If You Don't Have Account! <a href="signup.php" class="btn btn-success btn-sm">Signup!</a></p>
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

</body>
</html>
