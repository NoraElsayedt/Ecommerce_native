<?php 
ob_start();
session_start();
if(isset ($_SESSION['username'])){
  $pagetitle='dashbord';
  include 'init.php';
  $late=2; 

  
  $thelatest=getlatest("*","users","userID",$late);

  $thelatestitem=getlatest("*","items","ID",$late);
  
?>
<div class="container text-center  home-stats">
<h1 >Dashbord</h1>
<div class="row">
  <div class="col-md-3">
    <div class="stat members"> Total Members <span><a href="member.php"><?php echo countitem('userID' , 'users')?></a></span></div>
</div>
<div class="col-md-3">
    <div class="stat pending"> Pending Members <span><a href="member.php?do=manage&page=pending"><?php echo checkitem ('regstatus', 'users', 0)?></a></span></div>
</div>
<div class="col-md-3">
    <div class="stat items"> Total Items <span><a href="item.php"><?php echo countitem('ID' , 'items')?></a></span></div>
</div>
<div class="col-md-3">
    <div class="stat comments"> Total Comments <span><a href="comment.php"><?php echo countitem('ID' , 'comments')?></a></span></div>
</div>
</div>
</div>

<div class="container   latest">

<div class="row">
  <div class="col-sm-6">
    <div class="stat"> Latest <?php echo $late ?> Register Users <span> 
  <?php 
  if(!empty($late)){
  foreach($thelatest as $user){
    
    echo $user['username'] .'<a href="member.php?do=edit&userid='. $user['userID'] .'" ><span class="btn btn-success"> Edit</span></a> ' ;
    if($user['regstatus']==0){
      echo"<a href='member.php?do=activate&userid=". $user['userID'] .  "'class='btn btn-info'>Active</a>";
    }
  }
}else{

  echo'<div class="container">';

  echo"<div class='alert alert-info'>Theres No record to show</div>";

  echo'</div >';
}

  ?>
    </span></div>
</div>
<div class="col-sm-6">
    <div class="stat">  Latest <?php echo $late ?>  Items <span>

    <?php  
    if(!empty($late)){
  foreach($thelatestitem as $user){
    
    echo $user['name'] .'<a href="item.php?do=edit&itemid='. $user['ID'] .'" ><span class="btn btn-success"> Edit</span></a> ' ;
    if($user['aprove']==0){
      echo"<a href='item.php?do=activate&itemid=". $user['ID'] .  "'class='btn btn-info'>Active</a>";
    }
  }
}
else{

  echo'<div class="container">';
  echo"<div class='alert alert-info'>Theres No record to show</div>";

  echo'</div >';
}

  ?>

    </span></div>
</div>
</div>
</div>


<?php
  include $tpl.'footer.php';
}
else{
    
    header('location:index.php');
    exit();
}
ob_end_flush();