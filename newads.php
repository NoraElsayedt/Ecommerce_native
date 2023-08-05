<?php 
session_start();
$pagetitle='create new ads';
include "init.php";
if(isset($_SESSION['user'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $errorform=array();
        $title=filter_var( $_POST['name'],FILTER_SANITIZE_STRING);
        $des=filter_var(  $_POST['description'],FILTER_SANITIZE_STRING);
        $price= filter_var( $_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $made= filter_var( $_POST['made'],FILTER_SANITIZE_STRING);
        $status=filter_var( $_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $cate=filter_var( $_POST['cate'],FILTER_SANITIZE_NUMBER_INT);
        $tag=filter_var( $_POST['tag'],FILTER_SANITIZE_STRING);
        if(strlen( $title)<4) {
            $errorform[]='username must be larger than 4';
        }

        if(strlen( $des)<10) {
            $errorform[]='Description must be larger than 10';
        }
        if(strlen( $made)<2) {
            $errorform[]='country must be larger than 2';
        }
        if(empty($price)){
            $errorform[]="price cant empty ";
        }
        if(empty($status)){
            $errorform[]="status cant empty ";
        }
        if(empty($cate)){
            $errorform[]="category cant empty ";
        }
        if(empty($errorform)){
           
            $stmt=$db->prepare("INSERT INTO items ( name , description , price, country,states ,date,catID,memberID,tags)
             VALUES(:xname , :xdes, :xprice,:xcounty ,:xstat,now(),:xcate,:xmember,:xtag) ");
            $stmt->execute(array('xname'=>$title, 'xdes'=>$des,'xprice' =>$price
            ,'xcounty'=>$made,'xstat'=>$status,'xcate'=>$cate,'xmember'=>$_SESSION['uid'],'xtag'=>$tag));
            echo"<div class='alert alert-success text-center'>  
            item add</div>";
            
            
          }


    }

?>

<div class="createads block">
<div class="container">
    <h1 class="text-center"> Create New Ads</h1>
  
<div class="panel panel-primary">
                <div class="panel-heading"> Create New Ad</div>
                <div class="panel-body">
                    <div class="row">

                    <div class="col-md-8">
                    <form class="form-horizantal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <div class="form-group row  ">
    <label  class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10 col-md-8">
      <input type="text" name="name" class="form-control livename" required="required"  id="inputEmail3" placeholder="name item">
    </div>
  </div>
  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10 col-md-8">
      <input type="text" name="description" class="form-control livedes"  required="required" id="inputEmail3" placeholder="description  Item">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Price </label>
    <div class="col-sm-10 col-md-8">
      <input type="text" name="price" class="form-control liveprice"  required="required" id="inputEmail3" placeholder="price Item">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Country made </label>
    <div class="col-sm-10 col-md-8">
      <input type="text" name="made" class="form-control"   required="required" id="inputEmail3" placeholder="country made  Item">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Status </label>
    <div class="col-sm-10 col-md-8 ">
        <select class="form-control"   name="status">
            <option value="0">....</option>
            <option value="1">New</option>
            <option value="2">Like new</option>
            <option value="3">Used</option>
            <option value="4">very Old</option>
</select>
        </div>
  </div>
  <br>
  
  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Categoriess </label>
    <div class="col-sm-10 col-md-8 ">
        <select class="form-control" name="cate">
            <option value="0">....</option>
            <?php

$cat=getAllfrom('categories','ID');
foreach($cat as $cate){
    echo" <option value='".$cate['ID']."'>".$cate['name']."</option>";
}


?>


</select>
        </div>
  </div>

  <div class="form-group row ">
  <label  class="col-sm-2 control-label"> Tags </label>
    <div class="col-sm-10 col-md-8">
      <input type="text" name="tag" class="form-control" id="inputEmail3" placeholder=" Tags description your and Separate with comma(,)">
    </div>
  </div>


  <div class="form-group ">
    <div class="col-sm-offset-2">
      <button type="submit" class="btn btn-primary btn-lg">Add Item</button>
    </div>
  </div>
</form>
</div>


<div class="col-md-4">

    <div class="img-thumbnail itembox livepre ">

        <span class="price">$0</span>

         <img src="mountain1.jpg" alt="" />

            <div class="caption ">

                <h3>0</h3>

                <p>0</p>

</div>
</div>

    



</div>
</div>
<?php

if(!empty($errorform)){

    foreach($errorform as $error){
        echo '<div class="alert alert-danger">'. $error .'</div>'.'<br>';
    }
}

?>


                </div>
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

