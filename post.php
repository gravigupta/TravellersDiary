<?php
session_start();
$user=$_SESSION['username'];
$email=$_SESSION['emailid'];
if(!isset($user))
{   $_SESSION['msg']="Login! To make a Post";
    header("location: login.php");
}

?>

<?php
include 'connection.php';
include 'links.php';

if(isset($_POST['submit']))
{  
  if(!empty($_POST['city']))
  {$city=", ".$_POST['city'];}
  else{
    $city="";
  }
  if(!empty($_POST['state']))
  {$city=", ".$_POST['state'];}
  else{
    $state="";
  }
  if(!empty($_POST['country']))
  {$city=", ".$_POST['country'];}
  else{
    $country="";
  }
  $location=$_POST['location'].$city.$state.$country;
  $description=$_POST['description'];
  $photo=$_FILES['pic'];
  
  $filename=$photo['name'];
  $srcpath=$photo['tmp_name'];
  $fileerror=$photo['error'];
  if($fileerror==0)
  {
      $destpath="upload/".$filename;

      move_uploaded_file($srcpath,$destpath);
      $insertquery="insert into post(username, email, location, description, image) value('$user','$email', '$location', '$description', '$destpath')";
      $iquery=mysqli_query($con,$insertquery);

      if($iquery)
      {
        ?>
        <script>
         alert("Post uploaded!");
         </script>
        <?php
        header("location:mydiary.php");
      }else{
          ?>
        <script>
         alert("Post upload Failed!Try Again");
         </script>
        <?php

      }

      
  }
  else{
      echo"image upload failed";
  }


}

?>




<html>
<head>
<title>Add Post</title>
</head>
<body class="bg-info" >
   
    <div class="container-fluid mb-2">
    <a href="home.php" class="btn-lg btn-primary mx-auto float-left my-1">BacktoHome</a>
    <a href="mydiary.php" class="btn-lg btn-primary mx-auto float-right my-1">MyDiary</a>
    </div><br><br>
    
   <div class="container-fluid">
    <h1 class="bg-dark text-white text-center bg-warning m-1 p-2 rounded">
    Add To Your Diary! <span class="text-info font-weight-bold"><?php echo"$user"?></span></h1>
    </div>
    
   <div class="container my-3">
        <div class=" mx-auto">      
          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data" 
          class="text-center bg-warning mx-auto rounded my-2 " style="border:2px solid grey;">
           <div class="row">
            <div class="form-group col-md-6 col-11 mx-auto">
             <label for="location" class="text-primary font-weight-bold">Location:</label><br>
             <div class="input-group  form-row">
             <input type="text" class="form-control" id="location" name="location" placeholder="Location:" required>
             <input type="text" class="form-control" id="city" name="city" placeholder="city:" >
             <input type="text" class="form-control" id="state" name="state" placeholder="state:">
             <input type="text" class="form-control" id="country" name="country" placeholder="country:">
             </div>
            </div>
            <div class="form-group col-md-5 col-11 mx-auto">
             <label for="img" class="text-primary font-weight-bold">Image:</label><br>
             <input type="file" class="form-control" id="img" name="pic" required>
            </div>
           </div>

            <div class="form-group mx-2 col-md-10 mx-auto">
             <label for="description" class="text-primary  font-weight-bold">Description:</label><br>
             <textarea class="form-control" rows="7" id="description" name="description" placeholder="Enter details about location mentioned!"></textarea>
            </div>
    
            
            
            <input type="submit" class="btn btn-success my-2 px-5" value="Add" name="submit">
          </form>
      </div> 
   </div>

   

</body>
</html>