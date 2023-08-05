<?php 
ob_start();
session_start();
$pagetitle='Show Items';
include "init.php";

$cateID=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
$stmt=$db->prepare("SELECT *
FROM items
 WHERE ID=? AND aprove=1 ");
 $stmt->execute(array($cateID));
 $count=$stmt->rowCount();
 if($count>0){

 $row=$stmt->fetch();

?>
    <h1 class="text-center"> <?php echo $row['name']  ?></h1>
    <div class="container">
        <div class="row">

        <div class="col-md-3">
        <img src="mountain1.jpg" alt=""  class="img-responsive img-thumbnail"/>
 </div>
 <div class="col-md-9 iteminfo">
    <h2> <?php echo $row['name'] ?></h2>
    <p> <?php echo $row['description'] ?></p>
    <ul class="list-unstyled">
    <li><span>Date:</span> <?php echo $row['date'] ?></li>
    <li><span>price:</span>$ <?php echo $row['price'] ?></li>
    <li><span>Made In:</span> <?php echo $row['country'] ?></li>
    <li><span>Category ID:</span><a href="categories.php?pageid=<?php echo $row['catID']?>"> <?php echo $row['catID'] ?></a></li>
    <li><span>Add To:</span> <a href="#"><?php echo $row['memberID'] ?></a></li>

    <li><span>Tags:</span>
   <?php
   $alltags=explode(',',$row['tags']);

   foreach($alltags as $tags){
      $tags=str_replace(' ','',$tags);
      $tags=strtolower($tags);
      if(!empty($tags)){
      echo "<a class='link' href='tags.php?name={$tags}'>".$tags ."</a> " ;
   }
}
   ?>
   </li>
 </ul>
 </div>
 </div>
 <hr class="customhr">
 <?php if(isset($_SESSION['user'])){ ?>
 <div class="row">
   <div class="col-md-offset-3">
      <div class="addcomment">
      <h3>Add Your Comment</h3>
      <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$row['ID']?>" method="POST">
         <input class="input" type="text" name="comment" required="required"/>
         
         
         <button type="submit" class="btn btn-primary ">Add Comment</button>
 </form>
 <?php

if($_SERVER['REQUEST_METHOD']=='POST'){
   $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
   $userid=$_SESSION['uid'];
   $itemid=$row['ID'];
  

   if(!empty($comment)){
      $stmt=$db->prepare("INSERT INTO comments (comment, status,date, itemID, userID)
      VALUES(:zcom,0,now(),:zitem,:zuser)");
      $stmt->execute(array( 'zcom'=>$comment, 'zitem'=>$itemid, 'zuser'=>$userid ));
      if($stmt){
         echo "<div class='alert alert-success'>comment add</div>";
      }

   }


}


?>


 </div>
 </div>
 </div>
<?php }else{

echo"<div class='alert alert-danger text-center'>  
<a href='login.php'>Login</a> Or Register</div>";
}
?>

 <hr class="customhr">
 <?php
    $stmt=$db->prepare("SELECT comments.*, users.username as membername
    FROM comments
    INNER JOIN users ON users.userID=comments.userID WHERE itemID=? AND status=1  ");
    $stmt->execute(array($row['ID']));
    $rows=$stmt->fetchAll();
   ?>

   
   <?php
    foreach($rows as $comment){
      echo'<div class="commbox">';
      echo'<div class="row">';
      echo'<div class="col-md-2 text-center"><img src="mountain1.jpg" alt=""  class="img-responsive center-block img-thumbnail img-circle"/>
      '.$comment['membername'].'</div>';
      echo'<div class="col-md-10"><p class="lead">'. $comment['comment'].'</p></div>';
      echo'</div>';
      echo'</div>';
      echo'<hr class="customhr">';
    }
   
   ?>
 
 </div>
  
<?php
 }else{
    echo'<div class="container">';
 
    echo"<div class='alert alert-danger text-center'>theres not find id or this is waiting approve</div> ";

    echo'</div>';
 }
include $tpl.'footer.php';
ob_end_flush();
 ?>

