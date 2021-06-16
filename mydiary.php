<?php
session_start();
$user=$_SESSION['username'];
$email=$_SESSION['emailid'];

if(!isset($user))
{
    header("location: login.php");
}


include 'connection.php';
include 'links.php';
?>

<html>
<head>
<title> Mydiary!</title>
</head>
<body style="background-color:;">
<div class="container-fluid">
    <a href="home.php" class="btn-lg btn-info mx-auto float-left">BacktoHome</a>
    <a href="post.php" class="btn-lg btn-info mx-auto float-right">ADD POST</a>
</div>
<div class="container-fluid">
    <h1 class="text-dark font-weight-bold text-center bg-muted rounded m-1 p-2">
    Welcome to Your Diary! <?php echo"$user"?></h1>
</div>



<div class="row mx-1 my-1">
<?php 
 $selectquery="select * from post where email='$email' order by datetime desc";
 $squery=mysqli_query($con,$selectquery);


 while($sarray=mysqli_fetch_array($squery))
 {
    ?>
    <div class="col-lg-4 col-md-6 my-1">
     <div class="card bg-dark">
      <div class="card-header">
      <h6 class="bg-success  m-1 px-2 py-1 font-weight-bold badge-pill text-center"><?php echo $sarray['location']; ?></h6> 
      </div>
      <img src="<?php echo $sarray['image']; ?>" class="card-img img-fluid ">
      <div class="card-body">
        <p class="card-text text-info">
         <?php echo $sarray['description']; ?><br>
         <span class=" text-info m-1 px-2 py-1 font-weight-bold badge-pill float-right">
         ~ <a href="userprofile.php?otheruser=<?php echo $sarray['username']; ?>&otheremail=<?php echo $sarray['email']; ?>">
         <?php echo $sarray['username']; ?></a>
         </span>
        </p><br>

        <a href="#c<?php echo $sarray['id']; ?>" class="btn-sm btn-primary text-white mr-2" data-toggle="collapse">View Comments </a>
        <a href="#co<?php echo $sarray['id']; ?>" class="btn-sm btn-primary text-white" data-toggle="collapse">Comment </a>
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
              ~ <a href="userprofile.php?otheruser=<?php echo $sarray['username']; ?>&otheremail=<?php echo $carray['email']; ?>">
              <?php echo $carray['username']; ?></a></span>
              </p>
              </div>
            </div>
            <?php

           }
          ?>

        </div>
     
        <div class="collapse" id="co<?php echo $sarray['id'];?>">
          <form action="intermediate.php?idp=<?php echo $sarray['id'];?>" method="POST" class="text-center mx-auto rounded my-2 ">
            <div class="form-group mx-2 col-md-10 mx-auto">
             <label for="comment" class="text-info bg-dark p-2 rounded font-weight-bold">Comment:</label><br>
             <textarea class="form-control" rows="4" id="comment" name="comment" placeholder="Write Your Comment!"></textarea>
             
            </div>
           <input type="submit" class="btn btn-success my-2 " value="Post Comment!" name="addcomment">
          </form>
        </div>

      </div>
      </div>
    </div>
<?php
 }
 ?>
</div>



</body>
</html>
