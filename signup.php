<?php
session_start();
?>

<?php 
  include 'connection.php';
  include 'links.php';
  if(isset($_POST['submit']))
  {   
      $email=mysqli_real_escape_string($con,$_POST['email']);
      $username=mysqli_real_escape_string($con,$_POST['username']);
      $password=mysqli_real_escape_string($con,$_POST['password']);
      $cpassword=mysqli_real_escape_string($con,$_POST['cpassword']);
      $token=bin2hex(random_bytes(16));

      $pass=password_hash($password, PASSWORD_BCRYPT);
      $cpass=password_hash($cpassword,PASSWORD_BCRYPT);
    

      $emailquery="select * from users where email='$email'";
      $equery=mysqli_query($con,$emailquery);
      $rows=mysqli_num_rows($equery);
      if($rows>0)
      {
          ?>
        <script>
         alert('email already registered. Try login!');
         </script>
        <?php
      }else{
          if($password===$cpassword)
          {
              $insertquery="insert into users(email,username,password,cpassword,token,status) values('$email', '$username', '$pass', '$cpass',
              '$token', 'inactive')";
              $iquery=mysqli_query($con,$insertquery);
              if($iquery)
              {
              
                $_SESSION['msg']="You are Registerd. Please Login!";
                $time=date("Y-m-d H:i:s");
                $insertsession="insert into session(email, intime, outtime) value('$email', '$time', '$time')";
                $isession=mysqli_query($con,$insertsession);
                header("location: login.php");
    
              }
              else{
                  
                ?>
                <script>
                 alert('Registeration failed. Try Again!');
                 </script>
                <?php
              }

          }else{
            ?>
            <script>
             alert('Password and Confirm Password does not match!');
             </script>
            <?php

          }
      }
  }
?>

<html>
<head>
<title>Traveller's Diary SignUp!</title>
</head>
<body class="bg-info" >
   <div class="container-fluid">
    <h1 class="text-info text-center bg-dark m-1 p-2">SignUp!</h1>
   </div>
   <div class="container">
      <div class="form-row">
        <div class="col-md-5 col-sm-9 col-12 x-auto">      
          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST" class=" bg-warning text-center mx-auto rounded my-2 " style="border:2px solid grey">
            <div class="form-group mx-2 ">
             <label for="email" class="text-dark font-weight-bold">E-mail:</label><br>
             <input type="email" class="form-control" id="email" name="email" placeholder="Enter E-mail" required>
            </div>
            <div class="form-group mx-2">
             <label for="username" class="text-dark font-weight-bold">Username:</label><br>
             <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
            </div>
            <div class="form-group mx-2">
             <label for="password" class="text-dark font-weight-bold">Password:</label><br>
             <input type="password" class="form-control" id="password" name="password"placeholder="Enter Password"required>
            </div>
            <div class="form-group mx-2">
             <label for="cpassword" class="text-dark font-weight-bold">Confirm Password::</label><br>
             <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Renter Password" required><br>
            </div>
            <input type="submit" class="btn btn-primary my-2 " value="Signup" name="submit">
            <p class="text-white">If You Already Have Account! <a href="login.php" class="btn btn-success btn-sm">Login!</a></p>
          
          </form>
        </div>
        <div class="col-md-7 col-sm-9 col-12 mx-auto my-2 ">
          <img src="traveldiaries.jpg" class="img-fluid mx-auto d-block"alt="traveldiaries">
        </div>
      </div> 
   </div>


</body>
</html>
