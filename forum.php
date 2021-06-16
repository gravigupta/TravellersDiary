<?php
session_start();
$user=$_SESSION['username'];
$email=$_SESSION['emailid'];

if(!isset($user))
{
  header('location:index.php');
}

include 'connection.php';
include 'links.php';
?>

<?php
  //for question
 if(isset($_POST['askquestion']))
 {
     $ques=$_POST['question'];
     $insertques="insert into question(username,question) values('$user', '$ques')";
     $iquery=mysqli_query($con,$insertques);
     if($iquery)
     { ?>
       <div class="alert-success">Question is inserted!</div>
       
       <?php
       header('location:forum.php');
     }
     else{
       ?>
       <div class="alert-danger">Question insert failed! </div>
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
 <h1 class="text-center text-warning bg-dark m-3 p-2"><a href="home.php" class="btn float-left btn-warning text-dark font-weight-bold
 ">BacktoHome </a> Community Forum ? </h1>

 <a href="#ask" data-toggle="collapse" class="btn btn-primary text-center">Ask a Question </a>
</div>
<div class="collapse" id="ask">
 <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST" class="text-center mx-auto rounded my-2 ">
  <div class="form-group mx-2 container mx-auto ">
      <textarea class="form-control bg-secondary text-white font-weight-bold" rows="4" id="question" placeholder="Write Question! "
      name="question" ></textarea>
      
  </div>
  <input type="submit" class="btn btn-success my-2 " value="Ask this Question" name="askquestion">
 </form>
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
       <p class="m-1 font-weight-bold text-white" style="word-wrap:break-word;"> <?php echo $qarray['question'];?><br>
       <span class=" text-white m-1 px-2 py-1 font-weight-bold float-right">
       <a class="text-white" href="userprofile.php?otheruser=<?php echo $qarray['username']; ?>&otheremail=<?php echo $qarray['email']; ?>">
         ~ <?php echo $qarray['username']; ?></a> </span></p><br>

      <a href="#ans<?php echo $qarray['id'];?>" data-toggle="collapse" class="btn btn-primary btn-sm m-2 "> See Answers </a>
      <a href="#ansq<?php echo $qarray['id'];?>" data-toggle="collapse" class="btn btn-primary btn-sm m-1 ">Answer </a>

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
              <p class="mx-4 p-3 font-weight-bold text-white" style="word-wrap:break-word;"> <?php echo $aarray['answer']; ?><br>
              <span class=" text-white m-1 px-2 py-1 float-right">
              <a class="text-white" href="userprofile.php?otheruser=<?php echo $aarray['username']; ?>&otheremail=<?php echo $aarray['email']; ?>">
               ~ <?php echo $aarray['username']; ?></a> 
              </span></p>
            </div>
            <?php

         }
        ?>
       </div>

    

     <div class="collapse" id="ansq<?php echo $qarray['id'];?>">
       <form action="intermediate.php?id=<?php echo $qarray['id'];?>" method="POST" class="text-center mx-auto rounded my-2 ">
        <div class="form-group mx-2 col-md-10 mx-auto">
         
         <textarea class="form-control" rows="4" id="answer" name="answer" placeholder="Write your answer!"></textarea>
         
        </div>
       <input type="submit" class="btn btn-success my-2 " value="Post Answer!" name="addanswer">
      </form>
     </div>

    </div>

<?php
}


?>

</body>
</html>
