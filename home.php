<?php
session_start()

?>
<?php
include 'connection.php';
include 'links.php';
$user=$_SESSION['username'];

if(!isset($user))
{
    header("location: login.php");
}


?>




<head>
<title>Traveller's Diary Home!</title>
</head>

<div class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Traveller's Diary</a>
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
      <a href="forum.php" class="nav-link">CommunityForum</a>
      </li>
      <li class="nav-item ">
      <a href="users.php" class="nav-link">Users</a>
      </li>
      <li class="nav-item ">
      <a href="myprofile.php" class="nav-link">MyProfile</a>
      </li>
      <li class="nav-item ">
      <a href="logout.php" class="nav-link">LogOut</a>
      </li>
    </ul>
    </div>
  </div>
</div>
<div class="container">
<h1>Welcome! <?php echo "$user"?><a href="post.php">Add Post</a></h1>
</div>


<div class="row mx-1 my-1">
 <div class="grid-sizer"></div>
<?php 
 $selectquery="select * from post order by datetime desc";
 $squery=mysqli_query($con,$selectquery);


 while($sarray=mysqli_fetch_array($squery))
 { 
    ?>
    <div class=" col-lg-4 col-md-6 my-1 ">
     <div class="card bg-dark ">
      <div class="card-header">
      <h6 class="bg-success  m-1 px-2 py-1 font-weight-bold badge-pill text-center"><?php echo $sarray['location']; ?></h6>
      
      </div>
      <img src="<?php echo $sarray['image']; ?>" class="card-img img-fluid ">
      <div class="card-body">
        <p class="card-text text-info">
         <?php echo $sarray['description']; ?><br>
         <span class=" text-info m-1 px-2 py-1 font-weight-bold badge-pill float-right">
         <a href="userprofile.php?otheruser=<?php echo $sarray['username']; ?>&otheremail=<?php echo $sarray['email']; ?>">
         ~ <?php echo $sarray['username']; ?></a> </span>
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
              <a class="text-info" href="userprofile.php?otheruser=<?php echo $carray['username']; ?>&otheremail=<?php echo $carray['email']; ?>">
               ~ <?php echo $carray['username']; ?></a> </span>
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

