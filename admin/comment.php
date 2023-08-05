<?php
ob_start();
session_start();
if(isset ($_SESSION['username'])){
  $pagetitle='Comments';
  include 'init.php';
// ********************************************
$do=isset($_GET['do'])?$_GET['do']:'manage';
if($do=="manage"){
    $stmt=$db->prepare("SELECT comments.*, items.name as itemname,users.username as membername
    FROM comments
    INNER JOIN items ON items.ID=comments.itemID 
    INNER JOIN users ON users.userID=comments.userID ");
    $stmt->execute();
    $rows=$stmt->fetchAll();
 if(!empty($rows)){
    echo' <h1 class="text-center">Manage comments</h1>';
    echo'<div class="container">';
    echo' <div class="container">';
     echo'  <div class="table-responsive">';
       echo'  <table class="main-table text-center table table-bordered"  >';
           echo'<tr >';
            echo' <td>#ID</td>';
            echo' <td>comment</td>';
            echo' <td>Item name</td>';
             echo'<td>User name</td>';
             echo'<td>Added Date</td>';
             echo'<td>control</td>';
echo' </tr>';

foreach($rows as $row){
    echo'<tr>';
    echo' <td>' . $row['ID'] . ' </td>';
    echo' <td>' . $row['comment'] . ' </td>';
    echo' <td>' . $row['itemname'] . ' </td>';
    echo' <td>' . $row['membername'] . ' </td>';
    echo' <td>' . $row['date'] . ' </td>';
    echo"<td><a href='comment.php?do=edit&comid=". $row['ID'] .  "'class='btn btn-success'>Edit</a>
    <a href='comment.php?do=delete&comid=". $row['ID'] .  "'class='btn btn-danger confirm'>delete</a>";
    if($row['status']==0){
      echo"<a href='comment.php?do=activate&comid=". $row['ID'] .  "'class='btn btn-info'>Aprove</a>";
    }
    "</td>";
  
  
    echo' </tr>';
  
  }
    echo'</table>';
   echo' </div>';
       echo' </div>';
   echo' </div>'; 
}
   else{

    echo'<div class="container">';
    echo"<div class='alert alert-info'>Theres No record to show</div>";

    echo'</div >';
  }
}

elseif($do=="activate"){
    echo'<h1 class="text-center">Activate comments</h1>';
   echo'<div class="container">';
   $userID=isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval($_GET['comid']):0;
   $check= checkitem("ID" , "comments", $userID);
    if($check>0){
     $stmt=$db->prepare("UPDATE comments SET status=1  where ID=?");
   
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
    $cateID=isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval($_GET['comid']):0;
    $stmt=$db->prepare("SELECT *from comments where ID=? LIMIT 1");
     $stmt->execute(array($cateID));
     $row=$stmt->fetch();
     $count=$stmt->rowCount();
     if($count>0){
    ?>
     <h1 class="text-center">Edit Comment</h1>
     <div class="container">
         <form class="form-horizantal" action="?do=update" method="POST">
             <input type="hidden" name="comid" value="<?php echo $cateID ?>"/>
   <div class="form-group row  ">
     <label  class="col-sm-2 control-label">Comment</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="comment" class="form-control"
        required="required" value=<?php echo $row['comment']?> id="inputEmail3" placeholder="comments name">
     </div>
   </div>
   <div class="form-group row ">
     <label  class="col-sm-2 control-label">Date</label>
     <div class="col-sm-10 col-md-4">
       <input type="text" name="date" class="form-control"   required="required" value=<?php echo $row['date']?>  placeholder="date comment">
     </div>
   </div>



<div class="form-group row ">
  <label  class="col-sm-2 control-label"> Member </label>
  <div class="col-sm-10 col-md-4 ">
      <select class="form-control" name="member">
    
          <?php

$stmt=$db->prepare("SELECT * from users ");
$stmt->execute();
$rows=$stmt->fetchAll();
foreach($rows as $user){
  echo" <option value='".$user['userID']."'";
  if($row['userID']==$user['userID']) {echo 'selected' ;}

  echo"'>" .$user['username']."</option>";
  
}


?>


</select>
      </div>
</div>
<br>
<div class="form-group row ">
  <label  class="col-sm-2 control-label"> items </label>
  <div class="col-sm-10 col-md-4 ">
      <select class="form-control" name="item">
        
          <?php

$stmt=$db->prepare("SELECT * from items ");
$stmt->execute();
$rows=$stmt->fetchAll();
foreach($rows as $user){
  echo" <option value='".$user['ID']."'";
  if($row['itemID']==$user['ID']) {echo 'selected' ;}
  
  echo"'>" .$user['name']."</option>";
  
}
 ?> 


</select>
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
    $id=$_POST['comid'];
        $name=$_POST['comment'];
        $date=$_POST['date'];
        $member=$_POST['member'];
        $cate=$_POST['item'];
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
        if(empty($date)){
            $formerrors[]="<div class='alert alert-danger'>cant item <strong>name empty</strong></div>";
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
         
        $stmt=$db->prepare("UPDATE comments SET comment=? ,itemID=?,userID=?,date=? where ID=?");
        
        $stmt->execute(array($name,$cate,$member,$date,$id));
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
      echo'<h1 class="text-center">Delete Comment</h1>';
      echo'<div class="container">';
      $cateID=isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval($_GET['comid']):0;
      $check= checkitem("ID" , "comments", $cateID);
       if($check>0){
        $stmt=$db->prepare("DELETE FROM comments  where ID=:zcate ");
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
    
  





// *************************************
  include $tpl.'footer.php';
}
else{
    
    header('location:index.php');
    exit();
}
ob_end_flush();


?>