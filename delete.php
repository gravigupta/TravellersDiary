<?php
session_start();
$user=$_SESSION['username'];
$email=$_SESSION['emailid'];

include 'connection.php';
include 'links.php';

if(!isset($user))
{
    header("location: login.php");
}

if(isset($_POST['submit']))
{
  $selectquery="select * from users where email='$email'";
  $squery=mysqli_query($con,$selectquery);
  $rows=mysqli_num_rows($squery);
  $password=$_POST['password'];

  if($rows)
  {
    $email_array=mysqli_fetch_assoc($squery);
    $db_pass=$email_array['password'];

    $passcheck= password_verify($password,$db_pass);
    if($passcheck)
    {
      $deleteuser="delete from users where email='$email'";
      $duser=mysqli_query($con,$deleteuser);
      $deletepost="delete from post where email='$email'";
      $dpost=mysqli_query($con,$deletepost);


      if(!$duser)
      {
         echo"profile delete failed!";
      }
      else{
        ?><script>alert('profile deleted'); </script>
        <?php
        header("location: index.php");
      }

    }
    else{
      ?>
      <script>
      alert('Password did not match! Try again');
      </script>
      <?php
    }
  }
}


?>
<body>
<div class="col-md-6 mx-auto">
 <div class="alert alert-danger text-center text-danger">
 <strong>Danger!</strong> You are about to delete your profile
 </div>
 <div class="alert alert-info text-center text-dark ">
  Your all data will be erased from this website and you will not be able to recover it. 
 </div>
 
 <div class="col-md-6 mx-auto">
   <form action="" method="POST" class=" bg-info text-center mx-auto rounded my-2 " style="border:2px solid grey">
        
            <div class="form-group mx-2">
             <label for="password" class="text-dark font-weight-bold">Password:</label><br>
             <input type="password" class="form-control" id="email" name="password" placeholder="Enter Password"required>
            </div>
            
            <input type="submit" class="btn btn-danger my-2 " value="Delete Profile" name="submit">
        
   </form>


 </div>

 </body>