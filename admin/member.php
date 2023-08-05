<?php
ob_start();
session_start();
$pagetitle="member";
if(isset ($_SESSION['username'])){
  include 'init.php';
  $do=isset($_GET['do'])?$_GET['do']:'manage';
  if($do=="manage"){
    $query='';
    if(isset( $_GET['page'])&& $_GET['page']=='pending'){

      $query='AND regstatus=0';
    }

    $stmt=$db->prepare("SELECT * from users where groupID !=1  $query ORDER by userID DESC");
    $stmt->execute();
    $rows=$stmt->fetchAll();
    if(! empty($rows)){
 echo' <h1 class="text-center">Manage Member</h1>';
     echo'<div class="container">';
     echo' <div class="container">';
      echo'  <div class="table-responsive">';
        echo'  <table class="main-table manageimage text-center table table-bordered"  >';
            echo'<tr >';
             echo' <td>#ID</td>';
             echo' <td>Image</td>';
             echo' <td>username</td>';
             echo' <td>email</td>';
              echo'<td>fullname</td>';
              echo'<td>register date</td>';
              echo'<td>control</td>';
 echo' </tr>';

foreach($rows as $row){
  echo'<tr>';
  echo' <td>' . $row['userID'] . ' </td>';
  echo' <td>';
  if(empty($row['image'])){
    echo'<img src="uplouds/5469_36703721.jpg" alt="" >';
  }else{
  echo'<img src="uplouds/' . $row['image'] . '" alt="" >';
  }
  echo'</td>';
  echo' <td>' . $row['username'] . ' </td>';
  echo' <td>' . $row['email'] . ' </td>';
  echo' <td>' . $row['fullname'] . ' </td>';
  echo' <td>' . $row['data'] . ' </td>';
  echo"<td><a href='member.php?do=edit&userid=". $row['userID'] .  "'class='btn btn-success'>Edit</a>
  <a href='member.php?do=delete&userid=". $row['userID'] .  "'class='btn btn-danger confirm'>delete</a>";
  if($row['regstatus']==0){
    echo"<a href='member.php?do=activate&userid=". $row['userID'] .  "'class='btn btn-info'>Active</a>";
  }
  "</td>";


  echo' </tr>';

}
  echo'</table>';
 echo' </div>';
     echo' </div>';
    echo'<a href="member.php?do=add"  class="btn btn-primary">+Add</a> ';
 echo' </div>'; 
}else{

  echo'<div class="container">';
  echo"<div class='alert alert-info'>Theres No record to show</div>";
  
    
    echo'<a href="member.php?do=add"  class="btn btn-primary">+Add</a> ';
 
  echo'</div >';
}

} elseif($do== "add"){?>
<h1 class="text-center">Add New Member</h1>
    <div class="container">
        <form class="form-horizantal" action="?do=insert"   method="POST" enctype="multipart/form-data">
  <div class="form-group row  ">
    <label  class="col-sm-2 control-label">username</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="username" class="form-control" required="required"  id="inputEmail3" placeholder="Username">
    </div>
  </div>
  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Fullname</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="fullname" class="form-control" required="required"  id="inputEmail3" placeholder="Fullname">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label">User Image</label>
    <div class="col-sm-10 col-md-4">
      <input type="File" name="image" class="form-control"  id="inputEmail3">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10 col-md-4">
      <input type="email" name="email" class="form-control" required="required" id="inputEmail3" placeholder="Email">
    </div>
  </div>

  <div class="form-group row ">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10 col-md-4">
    <input type="password" name="password" class="form-control"  required="required" id="inputPassword3" placeholder="Password">
  </div>
  </div>
  <div class="form-group ">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary btn-lg">Add Member</button>
    </div>
  </div>
</form>
</div>
<?php
}
elseif($do=="insert"){
  if($_SERVER['REQUEST_METHOD']=="POST"){
    echo"<h1 class='text-center'>Insert Member</h1>";
     echo"<div class='container' >";
   
      $pass=$_POST['password'];
      $name=$_POST['username'];
      $email=$_POST['email'];
      $full=$_POST['fullname'];
      $imgname=$_FILES["image"]["name"];
      $imgsize=$_FILES["image"]["size"];
      $imgtmp=$_FILES["image"]["tmp_name"];
      $imgtype=$_FILES["image"]["type"];
     
      $imgextensionAll=array("jpeg","jpg","png","gif");
      $imgexten=strtolower(end(explode("." , $imgname)));
      
      $haspass=sha1($_POST['password']);
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
      if(empty($full)){
        $formerrors[]="<div class='alert alert-danger'>cant user <strong>full empty</strong></div>";
      }
      if(empty($email)){
        $formerrors[]="<div class='alert alert-danger'>cant user <strong>email empty</strong></div>";
      }

       if(!empty($imgname) && ! in_array($imgexten, $imgextensionAll)){
         $formerrors[]="<div class='alert alert-danger'>this extension <strong>not  Allowed</strong></div>";
      }
      if(empty($imgname)){
        $formerrors[]="<div class='alert alert-danger'>image is <strong>Reqired</strong></div>";
     }
     if($imgsize > 4194304){
      $formerrors[]="<div class='alert alert-danger'>image cant be largrt than  <strong>4 MB</strong></div>";
   }


      if(empty($pass)){
        $formerrors[]="<div class='alert alert-danger'>cant user <strong>password empty</strong></div>";
      }
      foreach($formerrors as $error){
        echo $error  ;
      }
      
      
      if(empty($formerrors)){

        $img=rand(0,100000).'_'.$imgname;
        
        move_uploaded_file($imgtmp,"uplouds\\".$img);



        $check= checkitem("username" , "users", $name);
        if($check==1){
          $themsg= "<div class='alert alert-success'>sorry this user exist </div>";
      redirecthome($themsg,'back');
        }
        else{
      $stmt=$db->prepare("INSERT INTO users ( username , email , fullname, password,regstatus ,data,image)
       VALUES(:xname , :xemail, :xfull,:xpass ,1,now(),:ximg) ");
      $stmt->execute(array('xname'=>$name, 'xemail'=>$email,'xfull' =>$full,'xpass'=>$haspass,'ximg'=>$img));
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
elseif($do=="delete"){
   echo'<h1 class="text-center">Delete Member</h1>';
  echo'<div class="container">';
  $userID=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
  $check= checkitem("userid" , "users", $userID);
   if($check>0){
    $stmt=$db->prepare("DELETE FROM users  where userID=:zuser ");
    $stmt->bindparam(":zuser",$userID);
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
elseif($do=="activate"){
  echo'<h1 class="text-center">Activate Member</h1>';
 echo'<div class="container">';
 $userID=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
 $check= checkitem("userid" , "users", $userID);
  if($check>0){
   $stmt=$db->prepare("UPDATE users SET regstatus=1  where userID=?");
 
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
   $userID=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
   $stmt=$db->prepare("SELECT *from users where userID=? LIMIT 1");
    $stmt->execute(array($userID));
    $row=$stmt->fetch();
    $count=$stmt->rowCount();
    if($count>0){
   ?>
    <h1 class="text-center">Edit Member</h1>
    <div class="container">
        <form class="form-horizantal" action="?do=update" method="POST">
            <input type="hidden" name="userid" value="<?php echo $userID ?>"/>
  <div class="form-group row  ">
    <label  class="col-sm-2 control-label">username</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="username" class="form-control" required="required" value=<?php echo $row['username']?> id="inputEmail3" placeholder="Username">
    </div>
  </div>
  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Fullname</label>
    <div class="col-sm-10 col-md-4">
      <input type="text" name="fullname" class="form-control" required="required" value=<?php echo $row['fullname']?> id="inputEmail3" placeholder="Fullname">
    </div>
  </div>

  <div class="form-group row ">
    <label  class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10 col-md-4">
      <input type="email" name="email" class="form-control" required="required" value=<?php echo $row['email']?> id="inputEmail3" placeholder="Email">
    </div>
  </div>

  <div class="form-group row ">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10 col-md-4">
    <input type="hidden" name="oldpassword"  value=<?php echo $row['password']?> >
      <input type="password" name="newpassword" class="form-control" id="inputPassword3" placeholder="Password">
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
    echo"<h1 class='text-center'>update Member</h1>";
    echo"<div class='container' >";
    if($_SERVER['REQUEST_METHOD']=="POST"){

        $id=$_POST['userid'];
        $name=$_POST['username'];
        $email=$_POST['email'];
        $full=$_POST['fullname'];

        $pass=empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['newpassword']);

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
        if(empty($full)){
          $formerrors[]="<div class='alert alert-danger'>cant user <strong>full empty</strong></div>";
        }
        if(empty($email)){
          $formerrors[]="<div class='alert alert-danger'>cant user <strong>email empty</strong></div>";;
        }
        foreach($formerrors as $error){
          echo $error  ;
        }
        if(empty($formerrors)){

          $stmt=$db->prepare("SELECT * FROM users WHERE username=? AND userID!=?");

          $stmt->execute(array($name,$id));
          $row=$stmt->rowCount();
          if($row==1){
             
            $themsg= "<div class='alert alert-danger'>sory this user is exist</div>";
           
            redirecthome($themsg,'back');
          }

          else{

        $stmt=$db->prepare("UPDATE users SET username=? , email=? , fullname=?, password=? where userID=? ");
        $stmt->execute(array($name,$email,$full ,$pass,$id));

        $themsg="<div class='alert alert-success'>" . $stmt->rowCount() . 'record update </div>';
        redirecthome($themsg,'back');
          }
        }
       
    
    }
    else{
      echo'<div class="container">';

      $themsg="<div class='alert alert-danger'>sorr you cant browse this page directe</div> ";
      redirecthome($themsg);
      echo'</div>';
    }
    
}
echo"</div>";

include $tpl.'footer.php';

}

else{
    
    header('location:index.php');
    exit();
}

ob_end_flush();
?>
