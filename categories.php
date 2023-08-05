<?php include "init.php";?>
<div class="container">
    <h1 class="text-center">Show Categories</h1>
    
    <div class="row">
    <?php
    if(isset($_GET['pageid'])&& is_numeric($_GET['pageid'])){

        $catID=intval($_GET['pageid']);
      $item=getAllfrom("items","ID","WHERE catID={$catID}");
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
        echo '<div class="alert alert-danger"> You didnt specify page ID</div>';
    }

?>
</div>
</div>



<?php include $tpl.'footer.php';?>

