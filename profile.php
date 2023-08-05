<?php 
session_start();
$pagetitle='profile';
include "init.php";
if(isset($_SESSION['user'])){

    $getuser=$db->prepare('SELECT * FROM users WHERE username=?');
    $getuser->execute(array($sessionuser));
    $info=$getuser->fetch();




?>

<div class="information block">
<div class="container">
    <h1 class="text-center"> My Profile</h1>
  
<div class="panel panel-primary">
                <div class="panel-heading"> My Information</div>
                <div class="panel-body">
                    <ul class="list-unstyled" >
                <li> <span>  Name:</span> <?php echo $info['username']; ?> </li>
                 <li> <span> Email:</span> <?php echo $info['email']; ?> </li>
                  <li> <span>Full Name: </span> <?php echo $info['fullname']; ?> </li>
                <li>  <span>Register Date:</span> <?php echo $info['data']; ?> </li>
                 <li><span> Favourite Category:</span>  </li> 
</ul>
<a href="#" class="btn btn-default">  Edit Information</a>

            </div>
</div>
</div>

<div id="myads" class="container myads">
<div class="panel panel-primary">
                <div class="panel-heading">My Items</div>
                <div class="panel-body"> 

                
    <?php
    if(getitem('memberID',$info['userID'],1)){
        echo'<div class="row">';
      $item=getitem('memberID',$info['userID'],1);
foreach($item as $ite){
   
    echo  '<div class="col-sm-6 col-md-3 ">' ;
    echo  '<div class="img-thumbnail itembox ">' ;
    if($ite['aprove']==0){
        echo "<span class='aprovespan'>Waiting Approved</span>";
    }
    echo'<span class="price">$'.$ite['price'].'</span>' ;
    echo'<img src="mountain1.jpg" alt="" />';
    echo  '<div class="caption ">' ;
    echo'<h3> <a href="items.php?itemid='.$ite['ID'].'"  >'.$ite['name'].'</a></h3>' ;
    echo'<p>'.$ite['description'].'</p>' ;
    echo'<div class="date">'.$ite['date'].'</div>' ;


    echo'</div>' ;
    echo'</div>' ;
    echo'</div>' ;

} 
echo'</div>';
}
else{
    echo 'Sorry Theres No Ads To Show <a href="newads.php"> create new ads </a> ';
}

?>

</div>
                </div>
</div>

</div>

</div>
<div class="container">
<div class="panel panel-primary">
                <div class="panel-heading"> Lastes Comment </div>
                <div class="panel-body">

<?php

$stmt=$db->prepare("SELECT comment FROM comments  WHERE userID=? ");
$stmt->execute(array($info['userID']));
$rows=$stmt->fetchAll();
if(!empty($rows)){

    foreach($rows as $comm){
        echo '<p>'. $comm['comment'] .'</p>';
        
    }


}else{
    echo'theres no comment show';
}


?>



      
</div>
</div>

</div>

<?php
}
else{
    header('location:login.php');
    exit();
}
include $tpl.'footer.php';
 ?>

