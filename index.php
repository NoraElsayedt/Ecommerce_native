<?php 
ob_start();
session_start();
$pagetitle='home';
include "init.php";
?>

<div class="container">
    
    
    <div class="row">
    <?php
      $item=getAllfrom('items','ID','WHERE aprove=1');
foreach($item as $ite){
   
    echo  '<div class="col-sm-6 col-md-3 ">' ;
    echo  '<div class="img-thumbnail itembox ">' ;
    echo'<span class="price">$'.$ite['price'].'</span>' ;
    echo'<img src="mountain1.jpg" alt="" />';
    echo  '<div class="caption ">' ;
    echo'<h3><a href="items.php?itemid='.$ite['ID'].'"  >'.$ite['name'].'</a></h3>' ;
    echo'<p>'.$ite['description'].'</p>' ;
    echo'<div class="date">'.$ite['date'].'</div>' ;


    echo'</div>' ;
    echo'</div>' ;
    echo'</div>' ;

} 

?>
</div>
</div>
<?php
include $tpl.'footer.php';
ob_end_flush();
 ?>

