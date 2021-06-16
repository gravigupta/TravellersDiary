<?php

session_start();
$user=$_SESSION['username'];
$email=$_SESSION['emailid'];


include 'connection.php';
include 'links.php';

         // for answer
         if(isset($_GET['id'])){
          $id=$_GET['id'];
         }

         if(isset($_POST['addanswer']))
         {
           $answ=$_POST['answer'];
           $insertansw="insert into answer(qid, email, username, answer) values($id, '$email', '$user', '$answ')";
           $iaquery=mysqli_query($con,$insertansw);
           if($iaquery)
           { ?>
             <div class="alert-success">Answer added Successfully!</div>
             
             <?php
             header('location:forum.php');
            
           }
              
           else{
            ?>
            <div class="alert-danger">Answer insert failed! </div>
            <?php
            }
         }

         ?>
<?php

// for comment
if(isset($_GET['idp'])){
  $idp=$_GET['idp'];
 }
  
 if(isset($_POST['addcomment']))
 {
   $comment=$_POST['comment'];
   $insertcom="insert into comments(idp, email, username, comment) values($idp, '$email', '$user', '$comment')";
   $icquery=mysqli_query($con,$insertcom);
   if($icquery)
   { ?>
     <div class="alert-success">Comment added Successfully!</div>
     
     <?php
     header('location:home.php');
    
   }
      
   else{
    ?>
    <div class="alert-danger">Comment insert failed! </div>
    <?php
    }
 }


?>