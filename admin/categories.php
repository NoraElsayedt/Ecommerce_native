<?php
ob_start();
session_start();
if(isset ($_SESSION['username'])){
  $pagetitle='dashbord';
  include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';

if($do=="manage"){

    $sort="ASC";
    $sortarr=array('ASC','DESC');
    if(isset($_GET['sort'])&& in_array($_GET['sort'],$sortarr)){
        $sort=$_GET['sort'];
    }

    $stmt=$db->prepare("SELECT * from categories WHERE parent=0 ORDER BY ordering $sort ");
    $stmt->execute();
    $rows=$stmt->fetchAll();
    if(!empty($rows)){

    
 echo' <h1 class="text-center ">Manage Categories</h1>';
 echo'<div class="container category">';
 echo'<div class="panel panel-default">';
echo'<div class="panel-heading "> Manage Categoreies';
echo'<div class="ordering pull-right">oredering: ';
echo'<a href="?sort=ASC" >Asc</a> || ';
echo' <a href="?sort=DESC">Desc</a>';
echo'</div>';
echo'</div>';
echo'<div class="panel-body ">';
foreach($rows as $cat){
  echo'<div class="cat">';
  echo'<div class="hideenbutton">';
  echo'<a href="categories.php?do=edit&cateid='.$cat['ID'].'" class="btn btn-xs btn-primary"> Edit</a>';
  echo'<a href="categories.php?do=delete&cateid='.$cat['ID'].'" class="btn btn-xs btn-danger">Delete</a>';
  echo'</div>';
  echo '<h3>'.$cat['name'].'</h3>';
  echo'<p>';
  if($cat['description']==''){
   echo" description is empty";
  }
   else{
   echo $cat['description'];
   }
  echo'</p>';
 if($cat['visible']==1){
  echo'<span class="visible">Hidden</span>';};

  if($cat['comment']==1){
    echo'<span class="comm">commenting Disable</span>';};
  
    if($cat['arts']==1){
      echo '<span class="ads">Ads Disable</span>';};
 

  echo'</div>';
  
  $category=getAllfrom("categories"," ID","WHERE parent={$cat['ID']}");
  if(!empty($category)){
  echo' <h4 class="childca">Child Categories</h4>';
  echo'<ul class="list-unstyled childcat">';
  foreach($category as $c){
      echo '<li class="childlink"><a href="categories.php?do=edit&cateid='.$c['ID'].'">'. $c['name'] .'</a>';
      echo'   <a href="categories.php?do=delete&cateid='.$c['ID'].'" class="btn btn-xs btn-danger showdelete">Delete</a>';
     echo' </li>';
  }
  echo'</ul>';
  }
  echo'<hr >';
}

echo'</div>';
 echo'</div>';
 echo'<a class="btn btn-primary" href="categories.php?do=add">+add</a>';
 echo'</div>';
    
}
}
elseif($do=="add"){?>


<h1 class="text-center">Add New Category</h1>
    <div class="container">
        <form class="form-horizantal" action="?do=insert" method="POST">
  <div class="form-group row  ">
    <label  class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="name" class="form-control" required="required"  id="inputEmail3" placeholder="name categories">
    </div>
  </div>
  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="description" class="form-control"  required="required"  id="inputEmail3" placeholder="description  Category">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Ordering</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="ordering" class="form-control"  id="inputEmail3" placeholder="ordering  Category">
    </div>
  </div>


  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Parent</label>
    <div class="col-sm-10 col-md-4">
     
<select name="parent">
  <option value="0">none</option>
  <?php

  $allcate=getAllfrom("categories","ID","WHERE parent=0");
  foreach($allcate as $cate){
    echo'<option value="'.$cate['ID'].'">'.$cate['name'].'</option>';
  }
  ?>

</select>

    </div>
  </div>
<br>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label">visible</label>
    <div class="col-sm-10 col-md-6">
        <div>
            <table>
                <tr>
                    <td>
            <input type="radio" name="visible" value="0" id="vis" checked/>
</td>
            <td>
            <label for="vis"> Yes </label>
</td>
</tr>
<tr>
<td>
            <input type="radio" name="visible" value="1" id="visi" /></td>
            <td>
            <label for="visi">No </label>
</td>
        
</tr>
</table>
</div>
      </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Comments</label>
    <div class="col-sm-10 col-md-6">
        <div>
            <table>
                <tr>
                    <td>
            <input type="radio" name="comment" value="0" id="com" checked/>
</td>
            <td>
            <label for="com"> Yes </label>
</td>
</tr>
<tr>
<td>
            <input type="radio" name="comment" value="1" id="comm" /></td>
            <td>
            <label for="comm">No </label>
</td>
        
</tr>
</table>
</div>
      </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Arts</label>
    <div class="col-sm-10 col-md-6">
        <div>
            <table>
                <tr>
                    <td>
            <input type="radio" name="arts" value="0" id="art" checked/>
</td>
            <td>
            <label for="art"> Yes </label>
</td>
</tr>
<tr>
<td>
            <input type="radio" name="arts" value="1" id="arts" /></td>
            <td>
            <label for="arts">No </label>
</td>
        
</tr>
</table>
</div>
      </div>
  </div>
  <div class="form-group ">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary btn-lg">Add Category</button>
    </div>
  </div>
</form>
</div>

<?php
}
elseif($do=="insert"){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        echo"<h1 class='text-center'>Insert categories</h1>";
      echo"<div class='container' >";
          $name=$_POST['name'];
          $description=$_POST['description'];
          $parent=$_POST['parent'];
          $ordering=$_POST['ordering'];
          $visible=$_POST['visible'];
          $comment=$_POST['comment'];
          $arts=$_POST['arts'];
          $formerrors=array();
          if(empty($name)){
            $formerrors[]="<div class='alert alert-danger'>cant category <strong>name empty</strong></div>";
          }
          if( strlen($name)<4){
            $formerrors[]="<div class='alert alert-danger'>cant category name<strong> less than 4 char</strong></div>";
          }
          if( strlen($name)>15){
            $formerrors[]="<div class='alert alert-danger'>cant category name <strong>less than 15 char</strong></div>";
          }
          foreach($formerrors as $error){
            echo $error  ;
          }
          if(empty($formerrors)){
            $check= checkitem("name" , "categories", $name);
            if($check==1){
              $themsg= "<div class='alert alert-success'>sorry this category exist </div>";
          redirecthome($themsg,'back');
            }
            else{
          $stmt=$db->prepare("INSERT INTO categories ( name , description ,parent, ordering, visible,comment ,arts)
           VALUES(:xname , :xdes,:xpar, :xorder,:xvis ,:xcomm,:xart) ");
          $stmt->execute(array('xname'=>$name, 'xdes'=>$description,'xpar'=>$parent,
          'xorder' =>$ordering,'xvis'=>$visible,'xcomm'=>$comment,'xart'=>$arts));
          $themsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'record insert </div>';
          redirecthome($themsg,'back');
          }
        }
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
    $cateID=isset($_GET['cateid'])&& is_numeric($_GET['cateid'])?intval($_GET['cateid']):0;
    $stmt=$db->prepare("SELECT *from categories where ID=? LIMIT 1");
     $stmt->execute(array($cateID));
     $row=$stmt->fetch();
     $count=$stmt->rowCount();
     if($count>0){
    ?>
     <h1 class="text-center">Edit category</h1>
     <div class="container">
         <form class="form-horizantal" action="?do=update" method="POST">
             <input type="hidden" name="cateid" value="<?php echo $cateID ?>"/>
   <div class="form-group row  ">
     <label  class="col-sm-2 control-label">categoryname</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="username" class="form-control"
        required="required" value=<?php echo $row['name']?> id="inputEmail3" placeholder="Categoryname">
     </div>
   </div>
   <div class="form-group row ">
     <label  class="col-sm-2 control-label">Description</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="description" class="form-control"   value=<?php echo $row['description']?>  placeholder="description Category">
     </div>
   </div>

   <div class="form-group row ">
     <label  class="col-sm-2 control-label">Ordering</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="order" class="form-control"  value=<?php echo $row['ordering']?> id="inputEmail3" placeholder="Ordering">
     </div>
   </div>

   <div class="form-group row ">
    <label  class="col-sm-2 control-label">Parent</label>
    <div class="col-sm-10 col-md-4">
     
<select name="parent">
  <option value="0">none</option>
  <?php

  $allcate=getAllfrom("categories","ID","WHERE parent=0");
  foreach($allcate as $cate){
    echo'<option value="'.$cate['ID'].'">'.$cate['name'].'</option>';
  }
 ?>

</select>

    </div>
  </div>
<br>

   <div class="form-group row ">
     <label for="inputPassword3" class="col-sm-2 col-form-label">visible</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="visible" class="form-control"  value=<?php echo $row['visible']?> id="inputPassword3" placeholder="visible">
     </div>
   </div>
   <div class="form-group row ">
     <label for="inputPassword3" class="col-sm-2 col-form-label">comments</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="comment" class="form-control"  value=<?php echo $row['comment']?> id="inputPassword3" placeholder="comments">
     </div>
   </div>
   <div class="form-group row ">
     <label for="inputPassword3" class="col-sm-2 col-form-label">arts</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="art" class="form-control"  value=<?php echo $row['arts']?> id="inputPassword3" placeholder="arts">
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
  echo"<h1 class='text-center'>update Category</h1>";
  echo"<div class='container' >";
  if($_SERVER['REQUEST_METHOD']=="POST"){
      $id=$_POST['cateid'];
      $name=$_POST['username'];
      $description=$_POST['description'];
      $parent=$_POST['parent'];
      $ordering=$_POST['order'];
      $visible=$_POST['visible'];
      $comment=$_POST['comment'];
      $arts=$_POST['art'];


      $formerrors=array();
      if(empty($name)){
        $formerrors[]="<div class='alert alert-danger'>cant user <strong>name empty</strong></div>";
      }
      if( strlen($name)<4){
        $formerrors[]="<div class='alert alert-danger'>cant user name<strong> less than 4 char</strong></div>";
      }
      if( strlen($name)>15){
        $formerrors[]="<div class='alert alert-danger'>cant user name <strong>less than 15 char</strong></div>";
      }
      foreach($formerrors as $error){
        echo $error  ;
      }
      if(empty($formerrors)){
      $stmt=$db->prepare("UPDATE categories SET name=? , description=?, parent=? , ordering=?, visible=? , comment=?, arts=? where ID=? ");
      $stmt->execute(array($name,$description,$parent,$ordering ,$visible,$comment,$arts,$id));

      $themsg="<div class='alert alert-success'>" . $stmt->rowCount() . 'record update </div>';
      redirecthome($themsg,'back');
      }
     
  
  }
  else{
    echo'<div class="container">';

    $themsg="<div class='alert alert-danger'>sorr you cant browse this page directe</div> ";
    redirecthome($themsg);
    echo'</div>';
  }
  
}
elseif($do=="delete"){
  echo'<h1 class="text-center">Delete Member</h1>';
  echo'<div class="container">';
  $cateID=isset($_GET['cateid'])&& is_numeric($_GET['cateid'])?intval($_GET['cateid']):0;
  $check= checkitem("ID" , "categories", $cateID);
   if($check>0){
    $stmt=$db->prepare("DELETE FROM categories  where ID=:zcate ");
    $stmt->bindparam(":zcate",$cateID);
    $stmt->execute();
    $themsg="<div class='alert alert-success'>" . $stmt->rowCount() . 'record delete </div>';
      redirecthome($themsg);
      
    
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