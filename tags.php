<?php include "init.php";?>
<div class="container">
    <h1 class="text-center">Show Item By Tag Name</h1>
    
    <div class="row">
    <?php
    if(isset($_GET['name'])){
          $tag=$_GET['name'];
          echo '  <h1 class="text-center">'.$tag.'</h1>';

      $item=getAllfrom("items","ID","WHERE tags like  '%$tag%' AND aprove=1");
foreach($item as $ite){
   
    echo  '<div class="col-sm-6 col-md-3 ">' ;
    echo  '<div class="img-thumbnail itembox ">' ;
    echo'<span class="price">'.$ite['price'].'</span>' ;
    echo'<img src="mountain1.jpg" alt="" />';
    echo  '<div class="caption ">' ;
    echo'<h3><a href="items.php?itemid='.$ite['ID'].'"  >'.$ite['name'].'</a></h3>' ;
    echo'<p>'.$ite['description'].'</p>' ;
    echo'<div class="date">'.$ite['date'].'</div>' ;


    echo'</div>' ;
    echo'</div>' ;
    echo'</div>' ;

} 
    }else{
        echo '<div class="alert alert-danger"> You must enter you tag name</div>';
    }

?>
</div>
</div>



<?php include $tpl.'footer.php';?>

