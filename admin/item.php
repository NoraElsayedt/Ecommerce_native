<?php

ob_start();
session_start();
if(isset ($_SESSION['username'])){
  $pagetitle='Items';
  include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';
if($do=="manage"){
    
    $stmt=$db->prepare("SELECT items.*, categories.name as catname,users.username as membername
    FROM items
    INNER JOIN categories ON categories.ID=items.catID 
    INNER JOIN users ON users.userID=items.memberID ");
    $stmt->execute();
    $rows=$stmt->fetchAll();
    if(!empty($rows)){
 echo' <h1 class="text-center">Manage Items</h1>';
     echo'<div class="container">';
     echo' <div class="container">';
      echo'  <div class="table-responsive">';
        echo'  <table class="main-table text-center table table-bordered"  >';
            echo'<tr >';
             echo' <td>#ID</td>';
             echo' <td>Name</td>';
             echo' <td>Description</td>';
              echo'<td>Price</td>';
              echo'<td>Register Date</td>';
              echo'<td>Country</td>';
              echo'<td>Category Name</td>';
              echo'<td>User Name</td>';
              echo'<td>Control</td>';
 echo' </tr>';

foreach($rows as $row){
  echo'<tr>';
  echo' <td>' . $row['ID'] . ' </td>';
  echo' <td>' . $row['name'] . ' </td>';
  echo' <td>' . $row['description'] . ' </td>';
  echo' <td>' . $row['price'] . ' </td>';
  echo' <td>' . $row['date'] . ' </td>';
  echo' <td>' . $row['country'] . ' </td>';
  echo' <td>' . $row['catname'] . ' </td>';
  echo' <td>' . $row['membername'] . ' </td>';
  echo"<td><a href='item.php?do=edit&itemid=". $row['ID'] .  "'class='btn btn-success'>Edit</a>
  <a href='item.php?do=delete&itemid=". $row['ID'] .  "'class='btn btn-danger confirm'>delete</a>";
  if($row['aprove']==0){
    echo"<a href='item.php?do=activate&itemid=". $row['ID'] .  "'class='btn btn-info'>Aprove</a>";
  }
  
  "</td>";


  echo' </tr>';

}
  echo'</table>';
 echo' </div>';
     echo' </div>';
    echo'<a href="item.php?do=add"  class="btn btn-primary">+Add</a> ';
 echo' </div>'; 
}
 else{

  echo'<div class="container">';
  echo"<div class='alert alert-info'>Theres No record to show</div>";
  echo'</div >';
}
  
}
elseif($do=="add"){
    
    ?>

<h1 class="text-center">Add New Item</h1>
    <div class="container">
        <form class="form-horizantal" action="?do=insert" method="POST">
  <div class="form-group row  ">
    <label  class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="name" class="form-control" required="required"  id="inputEmail3" placeholder="name item">
    </div>
  </div>
  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="description" class="form-control"  required="required" id="inputEmail3" placeholder="description  Item">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Price </label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="price" class="form-control"  required="required" id="inputEmail3" placeholder="price Item">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Country made </label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="made" class="form-control"   required="required" id="inputEmail3" placeholder="country made  Item">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Status </label>
    <div class="col-sm-10 col-md-4 ">
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
    <label  class="col-sm-2 control-label"> Rating </label>
    <div class="col-sm-10 col-md-4 ">
        <select class="form-control" name="ratings">
            <option value="0">....</option>
            <option value="1">*</option>
            <option value="2">**</option>
            <option value="3">***</option>
            <option value="4">****</option>
            <option value="5">*****</option>
</select>
        </div>
    
  </div>

  <br>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Members </label>
    <div class="col-sm-10 col-md-4 ">
        <select class="form-control" name="member">
            <option value="0">....</option>
            <?php

$alluser=getAllfrom("users","userID","");

foreach($alluser as $user){
    echo" <option value='".$user['userID']."'>".$user['username']."</option>";
}


?>


</select>
        </div>
  </div>
  <br>
  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Categoriess </label>
    <div class="col-sm-10 col-md-4 ">
        <select class="form-control" name="cate">
            <option value="0">....</option>
            <?php

            $allcate=getAllfrom("categories","ID","WHERE parent=0");
foreach($allcate as $cate){
    echo" <option value='".$cate['ID']."'>".$cate['name']."</option>";
    $allchild=getAllfrom("categories","ID","WHERE parent={$cate['ID']}");
    foreach($allchild as $c){
      echo" <option value='".$c['ID']."'>----".$c['name']."</option>";
    }

}


?>


</select>
        </div>
  </div>


  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Tags </label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="tag" class="form-control" id="inputEmail3" placeholder=" Tags description your and Separate with comma(,)">
    </div>
  </div>


  <div class="form-group ">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary btn-lg">Add Item</button>
    </div>
  </div>
</form>
</div>

<?php
}
elseif($do=="insert"){

    if($_SERVER['REQUEST_METHOD']=="POST"){
        echo"<h1 class='text-center'>Insert Items</h1>";
      echo"<div class='container' >";
          $name=$_POST['name'];
          $description=$_POST['description'];
          $price=$_POST['price'];
          $made=$_POST['made'];
          $status=$_POST['status'];
          $ratings=$_POST['ratings'];
          $member=$_POST['member'];
          $cate=$_POST['cate'];
          $tag=$_POST['tag'];
          $formerrors=array();
          if(empty($name)){
            $formerrors[]="<div class='alert alert-danger'>cant item <strong>name empty</strong></div>";
          }
          if( strlen($name)<4){
            $formerrors[]="<div class='alert alert-danger'>cant item name<strong> less than 4 char</strong></div>";
          }
          if( strlen($name)>15){
            $formerrors[]="<div class='alert alert-danger'>cant item name <strong>less than 15 char</strong></div>";
          }
          if(empty($description)){
            $formerrors[]="<div class='alert alert-danger'>cant item <strong>description empty</strong></div>";
          }
          if( strlen($description)<5){
            $formerrors[]="<div class='alert alert-danger'>cant item description<strong> less than 4 char</strong></div>";
          }
          if( strlen($description)>20){
            $formerrors[]="<div class='alert alert-danger'>cant item description <strong>less than 15 char</strong></div>";
          }
          if(empty($price)){
            $formerrors[]="<div class='alert alert-danger'>cant item <strong>price empty</strong></div>";
          }
          if(empty($made)){
            $formerrors[]="<div class='alert alert-danger'>cant item <strong>made empty</strong></div>";
          }
          if( strlen($made)<2){
            $formerrors[]="<div class='alert alert-danger'>cant item made<strong> less than 4 char</strong></div>";
          }
          if( strlen($made)>15){
            $formerrors[]="<div class='alert alert-danger'>cant item made <strong>less than 15 char</strong></div>";
          }
          if($status==0){
            $formerrors[]="<div class='alert alert-danger'>you can choose <strong>statues </strong></div>";
          }
          if($ratings==0){
            $formerrors[]="<div class='alert alert-danger'>you can choose <strong>rating </strong></div>";
          }
          if($member==0){
            $formerrors[]="<div class='alert alert-danger'>you can choose <strong>member </strong></div>";
          }
          if($cate==0){
            $formerrors[]="<div class='alert alert-danger'>you can choose <strong>category </strong></div>";
          }
          foreach($formerrors as $error){
            echo $error  ;
          }
          if(empty($formerrors)){
           
          $stmt=$db->prepare("INSERT INTO items ( name , description , price, country,states ,rating,date,catID,memberID,tags)
           VALUES(:xname , :xdes, :xprice,:xcounty ,:xstat,:xrating,now(),:xcate,:xmember,:xtag) ");
          $stmt->execute(array('xname'=>$name, 'xdes'=>$description,'xprice' =>$price
          ,'xcounty'=>$made,'xstat'=>$status,'xrating'=>$ratings,'xcate'=>$cate,'xmember'=>$member,'xtag'=>$tag));
          $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'record insert </div>';
          redirecthome($themsg,'back');
          
        }
      }
      else{
        echo'<div class="container">';
    
          $themsg="<div class='alert alert-danger'>sorr you cant browse this page directe</div> ";
          redirecthome($themsg);
          echo'</div>';
      }
    echo"</div>";



}

elseif($do=="activate"){
  echo'<h1 class="text-center">Activate Item</h1>';
 echo'<div class="container">';
 $userID=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
 $check= checkitem("ID" , "items", $userID);
  if($check>0){
   $stmt=$db->prepare("UPDATE items SET aprove=1  where ID=?");
 
   $stmt->execute(array($userID));
   $themsg="<div class='alert alert-success'>" . $stmt->rowCount() . 'record active </div>';
     redirecthome($themsg,'back');
     
   
  }
  else{
   echo'<div class="container">';

   $themsg="<div class='alert alert-danger'>sorr you cant browse this page directe</div> ";
   redirecthome($themsg,'back');
   echo'</div>';
   
  }
  
  echo"</div>";
}
elseif($do=="edit"){
    $cateID=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
    $stmt=$db->prepare("SELECT *from items where ID=? LIMIT 1");
     $stmt->execute(array($cateID));
     $row=$stmt->fetch();
     $count=$stmt->rowCount();
     if($count>0){
    ?>
     <h1 class="text-center">Edit Item</h1>
     <div class="container">
         <form class="form-horizantal" action="?do=update" method="POST">
             <input type="hidden" name="itemid" value="<?php echo $cateID ?>"/>
   <div class="form-group row  ">
     <label  class="col-sm-2 control-label">name</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="name" class="form-control"
        required="required" value=<?php echo $row['name']?> id="inputEmail3" placeholder="Item name">
     </div>
   </div>
   <div class="form-group row ">
     <label  class="col-sm-2 control-label">Description</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="description" class="form-control"   required="required" value=<?php echo $row['description']?>  placeholder="description Item">
     </div>
   </div>

   <div class="form-group row ">
     <label  class="col-sm-2 control-label">price</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="price" class="form-control"  required="required" value=<?php echo $row['price']?> id="inputEmail3" placeholder="price">
     </div>
   </div>
 
   <div class="form-group row ">
     <label for="inputPassword3" class="col-sm-2 col-form-label">country</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="country" class="form-control"  required="required" value=<?php echo $row['country']?> id="inputPassword3" placeholder="country">
     </div>
   </div>
   
  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Status </label>
    <div class="col-sm-10 col-md-4 ">
        <select class="form-control"   name="status">
            <option value="0">....</option>
            <option value="1" <?php if($row['states']==1) {echo 'selected' ;} ?>>New</option>
            <option value="2" <?php if($row['states']==2 ){echo 'selected' ;} ?>>Like new</option>
            <option value="3" <?php if($row['states']==3) {echo 'selected' ;} ?>>Used</option>
            <option value="4" <?php if($row['states']==4 ){echo 'selected' ;} ?>>very Old</option>
</select>
        </div>
  </div>
  <br>
  <div class="form-group row ">
    <label  class="col-sm-2 control-label"> Rating </label>
    <div class="col-sm-10 col-md-4 ">
        <select class="form-control" name="ratings">
            <option value="0">....</option>
            <option value="1" <?php if($row['rating']==1) {echo 'selected' ;} ?>>*</option>
            <option value="2" <?php if($row['rating']==2) {echo 'selected' ;} ?>>**</option>
            <option value="3" <?php if($row['rating']==3) {echo 'selected' ;} ?>>***</option>
            <option value="4" <?php if($row['rating']==4) {echo 'selected' ;} ?>>****</option>
            <option value="5" <?php if($row['rating']==5) {echo 'selected' ;} ?>>*****</option>
</select>
        </div>
    
  </div>

  <br>
  <br>

<div class="form-group row ">
  <label  class="col-sm-2 control-label"> Members </label>
  <div class="col-sm-10 col-md-4 ">
      <select class="form-control" name="member">
    
          <?php

$stmt=$db->prepare("SELECT * from users ");
$stmt->execute();
$rows=$stmt->fetchAll();
foreach($rows as $user){
  echo" <option value='".$user['userID']."'";
  if($row['memberID']==$user['userID']) {echo 'selected' ;}

  echo"'>" .$user['username']."</option>";
  
}


?>


</select>
      </div>
</div>
<br>
<div class="form-group row ">
  <label  class="col-sm-2 control-label"> Categoriess </label>
  <div class="col-sm-10 col-md-4 ">
      <select class="form-control" name="cate">
        
          <?php

$stmt=$db->prepare("SELECT * from categories ");
$stmt->execute();
$rows=$stmt->fetchAll();
foreach($rows as $user){
  echo" <option value='".$user['ID']."'";
  if($row['catID']==$user['ID']) {echo 'selected' ;}
  
  echo"'>" .$user['name']."</option>";
  
}
 ?> 


</select>
      </div>
</div>
  

<div class="form-group row ">
    <label  class="col-sm-2 control-label"> Tags </label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="tag" class="form-control" id="inputEmail3"  value=<?php echo $row['tags']?> placeholder=" Tags description your and Separate with comma(,)">
    </div>
  </div>

   <div class="form-group ">
     <div class="col-sm-10">
       <button type="submit" class="btn btn-primary btn-lg">save</button>
     </div>
   </div>
 </form>
 </div>
     <?php
     }
     else{
       echo'<div class="container">';
 
       $themsg="<div class='alert alert-danger'>theres not find id</div> ";
       redirecthome($themsg);
       echo'</div>';
     }
}
elseif($do=="update"){
  if($_SERVER['REQUEST_METHOD']=="POST"){
    echo"<h1 class='text-center'>update Items</h1>";
  echo"<div class='container' >";
  $id=$_POST['itemid'];
      $name=$_POST['name'];
      $description=$_POST['description'];
      $price=$_POST['price'];
      $made=$_POST['country'];
      $status=$_POST['status'];
      $ratings=$_POST['ratings'];
      $member=$_POST['member'];
      $cate=$_POST['cate'];
      $tags=$_POST['tag'];
      $formerrors=array();
      if(empty($name)){
        $formerrors[]="<div class='alert alert-danger'>cant item <strong>name empty</strong></div>";
      }
      if( strlen($name)<4){
        $formerrors[]="<div class='alert alert-danger'>cant item name<strong> less than 4 char</strong></div>";
      }
      if( strlen($name)>15){
        $formerrors[]="<div class='alert alert-danger'>cant item name <strong>less than 15 char</strong></div>";
      }
      if(empty($description)){
        $formerrors[]="<div class='alert alert-danger'>cant item <strong>description empty</strong></div>";
      }
      if( strlen($description)<5){
        $formerrors[]="<div class='alert alert-danger'>cant item description<strong> less than 4 char</strong></div>";
      }
      if( strlen($description)>20){
        $formerrors[]="<div class='alert alert-danger'>cant item description <strong>less than 15 char</strong></div>";
      }
      if(empty($price)){
        $formerrors[]="<div class='alert alert-danger'>cant item <strong>price empty</strong></div>";
      }
      if(empty($made)){
        $formerrors[]="<div class='alert alert-danger'>cant item <strong>made empty</strong></div>";
      }
      if( strlen($made)<2){
        $formerrors[]="<div class='alert alert-danger'>cant item made<strong> less than 4 char</strong></div>";
      }
      if( strlen($made)>15){
        $formerrors[]="<div class='alert alert-danger'>cant item made <strong>less than 15 char</strong></div>";
      }
      if($status==0){
        $formerrors[]="<div class='alert alert-danger'>you can choose <strong>statues </strong></div>";
      }
      if($ratings==0){
        $formerrors[]="<div class='alert alert-danger'>you can choose <strong>rating </strong></div>";
      }
      if($member==0){
        $formerrors[]="<div class='alert alert-danger'>you can choose <strong>member </strong></div>";
      }
      if($cate==0){
        $formerrors[]="<div class='alert alert-danger'>you can choose <strong>category </strong></div>";
      }
      foreach($formerrors as $error){
        echo $error  ;
      }
      if(empty($formerrors)){
       
      $stmt=$db->prepare("UPDATE items SET name=? , description=? , price=?, country=?,states=? ,rating=?,catID=?,memberID=? ,tags=? where ID=?");
      
      $stmt->execute(array($name,$description,$price,$made,$status,$ratings,$cate,$member,$tags,$id));
      $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'record update </div>';
      redirecthome($themsg,'back');
      
    }
  }

  else{
    echo'<div class="container">';

      $themsg="<div class='alert alert-danger'>sorr you cant browse this page directe</div> ";
      redirecthome($themsg);
      echo'</div>';
  }
echo"</div>";
  
  }
  elseif($do=="delete"){
    echo'<h1 class="text-center">Delete Item</h1>';
    echo'<div class="container">';
    $cateID=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
    $check= checkitem("ID" , "items", $cateID);
     if($check>0){
      $stmt=$db->prepare("DELETE FROM items  where ID=:zcate ");
      $stmt->bindparam(":zcate",$cateID);
      $stmt->execute();
      $themsg="<div class='alert alert-success'>" . $stmt->rowCount() . 'record delete </div>';
        redirecthome($themsg,"back");
        
      
     }
     else{
      echo'<div class="container">';
  
      $themsg="<div class='alert alert-danger'>sorr you cant browse this page directe</div> ";
      redirecthome($themsg);
      echo'</div>';
      
     }
     
     echo"</div>";
  }
  


else{
    echo"error";
}

include $tpl.'footer.php';
}
else{
    
    header('location:index.php');
    exit();
}
ob_end_flush();


?>