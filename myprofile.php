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


?>
<html>
<head>
<title> MYprofile!</title>
</head>
<?php
$selectquery="select * from users where email='$email' ";
$squery=mysqli_query($con,$selectquery);
$darray=mysqli_fetch_assoc($squery);

?>

<?php

if(isset($_POST['submit']))
{ 
  $uname=$_POST['username'];
  $bio=$_POST['bio'];
  $photo=$_FILES['pimg'];

  
    $filename=$photo['name'];
    $srcpath=$photo['tmp_name'];
    $fileerror=$photo['error'];
  
       if($fileerror==0)
      {
        $destpath="profile/".$filename;
      
        if(isset($photo)){
         move_uploaded_file($srcpath,$destpath);}
        
         $unamepost="update post set username='$uname' where email='$email' ";
         $uppost=mysqli_query($con,$unamepost);
         if(!$upquery)
          echo"post update failed";

         $unamecomments="update comments set username='$uname' where email='$email'";
         $upcomments=mysqli_query($con,$unamecomments);
         if(!$upquery)
          echo"comments update failed";

         $unamequestions="update question set username='$uname' where email='$email'";
         $upcomments=mysqli_query($con,$unamequestions);
         if(!$upquery)
          echo"questions update failed";

         $unameanswers="update answer set username='$uname' where email='$email'";
         $upanswers=mysqli_query($con,$unameanswers);
         if(!$upquery)
          echo"answers update failed";
          
        $updatequery="update users set username='$uname', bio='$bio', profile='$destpath' where email='$email' ";
        $uquery=mysqli_query($con,$updatequery);
        
        if($uquery)
        {
         ?>
         <script>
          alert("Profile updated!");
         </script>
         <?php
         header("location:myprofile.php");
        }else{
          ?>
         <script>
         alert("Profile Update Failed!Try Again");
         </script>
          <?php

        }

      
      }
      else{
     echo"image upload failed";
       }
  

}

?>
<div class="container-fluid">
<a class="btn btn-success text-center float-left m-1" href="home.php">BacktoHome </a>
<h1 class="bg-dark text-center p-2 text-white rounded"> Profile Page </h1>
</div>

<div class="row">
  <div class="col-md-5 col-sm-10 col-10 mx-auto my-2">
      <div class="card">
       <div class="card-header bg-dark">
       <h4 class="text-center text-white font-weight-bold"> Your Details: </h4>
       </div>
       <div class=" col-md-9 col-sm-10 col-12 mx-auto d-block">
        <img src="<?php echo $darray['profile']; ?>" class="card-img-top img-thumbnail ">
       </div>
       <div class="card-body bg-secondary">
         <div class="container-fluid m-1 p-1 text-dark ">
         <span class=" m-1 p-1 font-weight-bold ">Username:</span><?php echo $darray['username']; ?><br><br>
         <span class=" m-1 p-1 font-weight-bold ">Email:</span><?php echo $darray['email']; ?><br><br>
         <span class=" m-1 p-1 font-weight-bold ">Your Bio: </span><br>
         </div>
        
        <p class="card-text text-white font-weight-bold m-2">
         
         <?php echo $darray['bio']; ?>
        </p>
        <a href="mydiary.php" class="btn bg-info text-dark font-weight-bold d-block card-link mx-auto my-1" >My Diary </a>
      
       </div>
      </div>
  </div>
  

  <div class="col-md-5 col-sm-10 col-10 mx-auto">
      
     <button class="text-center btn btn-info btn-block my-1" data-toggle="collapse" data-target="#editform">Edit Profile </button>
     

      <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data" 
       class=" bg-success text-center mx-auto rounded my-2 collapse" id ="editform"style="border:2px solid grey">
            <div class="form-group mx-2 ">
             <label for="pimg" class="text-dark font-weight-bold">Profile Image:</label><br>
             <input type="file" class="form-control" id="pimg" name="pimg" required>
            </div>
            <div class="form-group mx-2">
             <label for="username" class="text-dark font-weight-bold">Username:</label><br>
             <input type="text" class="form-control" id="username" name="username" value="<?php echo $darray['username']; ?>" required>
            </div>
            <div class="form-group mx-2">
             <label for="bio" class="text-dark font-weight-bold">Bio:</label><br>
             <textarea class="form-control" rows="4" id="bio" name="bio" value="<?php echo $darray['bio']; ?>" placeholder="Add Your bio!"></textarea>
            </div>
            
            <input type="submit" class="btn btn-primary my-2 " value="Update Profile" name="submit">
            
      </form>
    
    <a href="delete.php" class=" btn btn-danger btn-block my-1" >Delete Profile </a>

  </div>

</div>

</html>