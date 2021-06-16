<?php
session_start();
include 'connection.php';
include 'links.php';

if(!isset($_GET['otheruser']))
 echo"other username is not set!";

$otheruser=$_GET['otheruser'];
$otheremail=$_GET['otheremail'];

if(isset($_SESSION['emailid']))
{
  if($_SESSION['emailid']==$otheremail)
   header('location:myprofile.php');
}

?>

<?php
$selectquery="select * from users where email='$otheremail' ";
$squery=mysqli_query($con,$selectquery);
$darray=mysqli_fetch_assoc($squery);

?>
<html>
<head>
<title>User Profile</title>
</head>
<body>
<div class="container-fluid">
<a class="btn btn-success text-center float-left m-1" href="<?php
if(!isset($_SESSION['username']))
echo 'index.php'; else echo 'home.php';?>">BacktoHome </a>
<h1 class="bg-info text-center p-2 text-white rounded"><?php echo $otheruser; ?>  </h1>
</div>
<div class="row">
  <div class="col-md-5 col-sm-10 col-10 mt-0 mb-1 ml-4 p-0 ">
      <div class="card">
       <div class="card-header bg-secondary">
       <h4 class="text-center text-white font-weight-bold "> User Details: </h4>
       </div>
       <div class=" col-md-9 col-sm-10 col-12 mx-auto d-block p-0 text-center">
        <img src="<?php echo $darray['profile']; ?>" style="height:auto;max-width:50%;" class="card-img-top ">
       </div>
       <div class="card-body bg-secondary">
         <div class="container-fluid m-1 p-1 text-white ">
         <span class=" m-1 p-1 font-weight-bold ">Username:</span><?php echo $darray['username']; ?><br><br>
         <span class=" m-1 p-1 font-weight-bold ">Email:</span><?php echo $darray['email']; ?><br><br>
         <span class=" m-1 p-1 font-weight-bold ">Bio: </span><br>
         </div>
         
        
        <p class="card-text text-white font-weight-bold m-2">
         
         <?php echo $darray['bio']; ?>
        </p>
      
       </div>
     </div>
  </div> 

  <div class="col-md-5 col-sm-10 col-10 mx-auto">   
    <a class="text-center btn btn-success btn-block my-1" href="#posts">See Posts </a>    
     <a href="message.php?otheruser=<?php echo $otheruser;?>&otheremail=<?php echo $otheremail;?>" class=" btn btn-primary btn-block my-1" >Chat </a>
   </div>
</div>

<div class="row" id="posts">

<?php 
 $selectquery="select * from post where email='$otheremail' order by datetime desc";
 $squery=mysqli_query($con,$selectquery);


 while($sarray=mysqli_fetch_array($squery))
 {
    ?>
    <div class="col-lg-4 col-md-6 my-1 ml-1">
     <div class="card bg-white" style="border:3px solid skyblue;">
      <div class="card-header bg-secondary">
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
            <div class="container rounded my-2" style="border:2px solid grey;">
              <div class="container p-3">
              <span class="text-info my-1 mx-auto">Posted at: <?php echo $carray['datetime']; ?></span>
              </div>
              <div class="container p-3">
              <p class="ml-3 text-info font-weight-bold "> <?php echo $carray['comment']; ?>
              <span class=" text-info m-1 px-2 py-1 font-weight-bold badge-pill float-right">
              ~ <a class="text-info" 
              href="userprofile.php?otheruser=<?php echo $sarray['username']; ?>&otheremail=<?php echo $sarray['email']; ?>">
              <?php echo $sarray['username']; ?></a>
             </span>
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