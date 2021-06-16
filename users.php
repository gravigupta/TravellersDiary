<?php
session_start();

include 'links.php';
include 'connection.php';

$username=$_SESSION['username'];
$email=$_SESSION['emailid'];

if(!isset($username))
{
    header('location:login.php');
}

?>
<html>
<head>
<title>Our Users!</title>
<script>
  function search(){
   var search=document.getElementById("search").value;
   if(search!="")
   {
       var xhttp=new XMLHttpRequest();
       xhttp.onreadystatechange = function(){     
        if (this.readyState == 4 && this.status == 200) 
        {
          document.getElementById("users").innerHTML=this.responseText;
          document.getElementById("remove").style.display="block";
        }      
       };
        
       xhttp.open("GET","search.php?user="+search,true);
       xhttp.send();
   }
  }
  function remove(){
    var xhttp=new XMLHttpRequest();
       xhttp.onreadystatechange = function(){     
        if (this.readyState == 4 && this.status == 200) 
        {
          document.getElementById("search").value="";
          document.getElementById("users").innerHTML=this.responseText;
          document.getElementById("remove").style.display="none";
        }      
       };
        
       xhttp.open("GET","search.php?clear=1",true);
       xhttp.send();
  }
</script>
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
<h1 class="bg-info text-warning py-2 pl-2 mx-1" style="border-radius:5px">Our <span class="text-white">Users!</span>
<span style="float:right;margin-right:4%;"><a href="home.php" class="btn btn-light my-auto">Home</a></span></h1>
<div class="ml-3 input-group">
 <input id="search" onkeyup="search()" onkeydown="search()" class="col-md-6 col-9 py-2 form-control my-2" 
 style="border:2px solid skyblue;" type="text" placeholder="Search User!"></input>
 <span><button id="remove" onclick="remove()" style="display:none;" class="btn btn-outline-info font-weight-bold my-2 "> &times; </button></span>
</div>
<div id="users">
<?php
$selectuser="select * from users where email!='$email'";
$suser=mysqli_query($con,$selectuser);
while($uarray=mysqli_fetch_assoc($suser))
{
  ?>
    
     <div class="col-10 mx-auto my-1 row py-1 " style="border:2px solid #17a2b8; border-radius:10px 10px 10px 10px;">
      <div class="col-4 my-auto px-1">
        <img src="<?php echo $uarray['profile'];?>" alt="profileimg" class="pimg mx-auto d-block">
      </div>
      <div class="col-6 mx-auto my-auto pr-1">
        <p class="py-1 my-1" style="word-wrap:break-word;">
         <span class="font-weight-bold text-dark"><?php echo $uarray['username']; ?></span><br>
         <span><?php echo $uarray['email']; ?></span><br>
         <span class="text-info"><?php echo $uarray['bio']; ?><span><br>
        </p><br>
        <a href="message.php?otheruser=<?php echo $uarray['username'];?>&otheremail=<?php echo $uarray['email'];?>" 
          class="btn btn-primary btn-sm" style="margin-bottom:4px;">Chat</a>
        <a href="userprofile.php?otheruser=<?php echo $uarray['username']; ?>&otheremail=<?php echo $uarray['email']; ?>"
        class="btn btn-primary btn-sm" style="margin-bottom:4px;">profile </a>
      </div>
    </div>
   </a>
  <?php
}

?>
</div>
<br><br>


</body>
</html>