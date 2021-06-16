<?php
session_start();
include 'connection.php';
include 'links.php';

$username=$_SESSION['username'];
$email=$_SESSION['emailid'];

if(!isset($username))
{
  header('location:login.php');
}
?>
<html>
<head>
<style>
@media only screen and (max-width: 700px) {
  .pimg{
      max-width:180%;
      height:auto;
  }
}
@media only screen and (max-width: 900px) {
  .pimg{
      max-width:130%;
      height:auto;
  }
}
@media only screen and (min-width: 900px) {
  .pimg{
      max-width:65%;
      height:auto;
  }
}
</style>
</head>
<body>
<?php
if(isset($_GET['clear']))
{
  $selectusers="select * from users where email!='$email'";
  $susers=mysqli_query($con,$selectusers);
  while($uarray=mysqli_fetch_assoc($susers))
  {
      echo "
      <div class='row col-10 mx-auto mt-1 py-1' style='border:2px solid #17a2b8; border-radius:10px 10px 10px 10px;' >
       <div class='col-4 my-auto px-1'>
         <img src='".$uarray['profile']."' alt='profileimg' class='pimg mx-auto d-block'>
       </div>
       <div class='col-6 mx-auto my-auto pr-1'>
         <p class='py-1 my-1' style='word-wrap:break-word;'>
          <span class='font-weight-bold text-dark'>".$uarray['username']."</span><br>
          <span>".$uarray['email'] ."</span><br>
          <span class='text-info'>".$uarray['bio']."<span><br>
         </p><br>
         <a href='message.php?otheruser=".$uarray['username']."&otheremail=".$uarray['email']."'". 
           "class='btn btn-primary btn-sm ' style='margin-bottom:4px;'>Chat</a>
         <a href='userprofile.php?otheruser=".$uarray['username']."&otheremail=".$uarray['email']."'".
           "class='btn btn-primary btn-sm' style='margin-bottom:4px;'>Profile</a>
       </div>
     </div>";
  }
}
else{
$search=$_GET['user'];
$pattern="%".$search."%";
$selectusers="select * from users where username like '$pattern' AND email!='$email'";
$susers=mysqli_query($con,$selectusers);
$rows=mysqli_num_rows($susers);
if($rows==0)
{
    echo "<div class='alert-info font-weight-bold py-2 text-center my-2'> No Match Found!</div>";
}
else{

    while($uarray=mysqli_fetch_assoc($susers))
    {
        echo "
        <div class='row col-10 mx-auto mt-1 py-1' style='border:2px solid #17a2b8; border-radius:10px 10px 10px 10px;' >
         <div class='col-4 my-auto px-1'>
           <img src='".$uarray['profile']."' alt='profileimg' class='pimg mx-auto d-block'>
         </div>
         <div class='col-6 mx-auto my-auto pr-1'>
           <p class='py-1 my-1' style='word-wrap:break-word;'>
            <span class='font-weight-bold text-dark'>".$uarray['username']."</span><br>
            <span>".$uarray['email'] ."</span><br>
            <span class='text-info'>".$uarray['bio']."<span><br>
           </p><br>
           <a href='message.php?otheruser=".$uarray['username']."&otheremail=".$uarray['email']."'". 
             "class='btn btn-primary btn-sm ' style='margin-bottom:4px;'>Chat</a>
           <a href='userprofile.php?otheruser=".$uarray['username']."&otheremail=".$uarray['email']."'".
             "class='btn btn-primary btn-sm' style='margin-bottom:4px;'>Profile</a>
         </div>
       </div>";
    }
}
}
?>
</body>
</html>