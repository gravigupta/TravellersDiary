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
    
     header("location: forum.php");

    
    
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




<html>
<head>
<title>Community Forum </title>
</head>

<body style="background-color:#ff6699;">
<div class="container-fluid">
 <h1 class="text-center text-warning bg-dark m-3 p-2"><a href="index.php" class="btn float-left btn-warning text-dark font-weight-bold
 ">BacktoHome </a>Community Forum ? </h1>
 <button type="button" data-toggle="modal" data-target="#modallogin" class="btn btn-primary text-center">Ask a Question </button>
</div>

<?php
$selectquest="select * from question order by datetime desc";
$squest=mysqli_query($con,$selectquest);

while($qarray=mysqli_fetch_assoc($squest))
{
    ?>
    <div class="container rounded bg-secondary my-3 p-2">
     
    <span class="bg-info font-weight-bold badge-lg mx-2 px-2 py-1 badge-pill"><?php echo $qarray['status'];?> </span>
     <span class="float-right text-dark"><?php echo $qarray['datetime'];?> </span>
       <p class="m-1 font-weight-bold text-white " style="word-wrap:break-word;"> <?php echo $qarray['question'];?><br>
       <span class=" text-white m-1 px-2 py-1 font-weight-bold float-right">
       <a class="text-white" href="userprofile.php?otheruser=<?php echo $qarray['username']; ?>&otheremail=<?php echo $qarray['email']; ?>">
        ~ <?php echo $qarray['username']; ?></a> </span></p><br>

      <a href="#ans<?php echo $qarray['id'];?>" data-toggle="collapse" class="btn btn-primary btn-sm m-2 "> See Answers </a>
      <button type="button" data-toggle="modal" data-target="#modallogin" class="btn btn-primary btn-sm m-1 ">Answer </button>

       <div id="ans<?php echo $qarray['id'];?>" class="collapse">
        <h4 class="ml-3 text-dark font-weight-bold">Available Answers:</h4>
       <?php
         
         $id =$qarray['id'];
         $selectanws="select * from answer where qid=$id order by datetime desc";
         $sanws=mysqli_query($con,$selectanws); 

         while($aarray=mysqli_fetch_assoc($sanws))
         {
            ?>
            <div class="container border rounded my-2" style="background-color:">
              <div class="container p-2">
              <span class="float-right text-dark my-2"><?php echo $aarray['datetime'];?> </span>
              </div>
              <p class="mx-4 p-3 font-weight-bold text-white " style="word-wrap:break-word;"> <?php echo $aarray['answer']; ?><br>
              <span class=" text-white m-1 px-2 py-1 float-right">
              <a class="text-white" href="userprofile.php?otheruser=<?php echo $aarray['username']; ?>&otheremail=<?php echo $aarray['email']; ?>">
               ~ <?php echo $aarray['username']; ?></a> 
              </span></p>
            </div>

            <?php

         }
        ?>
       </div>

     
    </div>
     
<?php
}


?>


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
