<?php 

session_start();

$pagetitle='login';
if(isset ($_SESSION['user'])){
    header('location:index.php');
}
include 'init.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['login'])){
    $usernames=$_POST['user'];
    $password=$_POST['password'];
    $hashpass=sha1($password);


    $stmt=$db->prepare("SELECT userID, username , password from users where username=? and password=?");
    $stmt->execute(array($usernames,$hashpass));
    $get=$stmt->fetch();
    $count=$stmt->rowCount();
    if($count>0){
        $_SESSION['user']=$usernames;
        $_SESSION['uid']=$get['userID'];
       
        header('location:index.php');
        exit();

    }
    }else{
       $errorform=array();



       if(isset($_POST['user'])){

        $username=filter_var($_POST['user'],FILTER_SANITIZE_STRING);
        if(strlen( $username)<4) {
            $errorform[]='username must be larger than 4';
        }


       }
       if(isset($_POST['password'])&&isset($_POST['password2'])){

        if(empty($_POST['password'])){
            $errorform[]="password cant empty ";
        }


        $pass1=sha1($_POST['password']);

        $pass2=sha1($_POST['password2']);
        if($pass1!==$pass2) {
            $errorform[]='password is not match';
        }


       }
       if(isset($_POST['email'])){

        $useremail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        if(filter_var($useremail,FILTER_VALIDATE_EMAIL)!=true) {
            $errorform[]='email is not valid';
        }


       }
       if(empty($errorform)){
        $check= checkitem("username" , "users", $_POST['user']);
        if($check==1){
          $errorform[]= "sorry this user exist ";
      
        }
        
        else{
      $stmt=$db->prepare("INSERT INTO users ( username , email , password,regstatus ,data)
       VALUES(:xname , :xemail,:xpass ,0,now()) ");
      $stmt->execute(array('xname'=>$_POST['user'], 'xemail'=>$_POST['email'],'xpass'=>sha1($_POST['password'])));
      $themsg= "<div class='alert alert-success'>" .  'congrate You Are Now Register User'. ' </div>';
      }
    
    }

    }
    
}

?>

<div class="container loginf">
<h5 class="text-center "><span class="selected" data-class="login"> login</span> |<span data-class="signup"> signup</span></h5>
<form class="login " action=" <?php echo $_SERVER['PHP_SELF']?>" method="POST"   >
<div class="dis">
    <input class="from-control"  type="text" name="user" placeholder="usernames" required="required" autocomplete="off"/>
    
</div>
<div class="dis"><input  class="from-control" type="password" name="password" placeholder="password" required="required" autocomplete="new-password"/>
</div> <input class="btn btn-primary" type="submit"  name="login" value="login" />
</form>
<form class="signup" action=" <?php echo $_SERVER['PHP_SELF']?>" method="POST"   >
<div class="dis">
    <input class="from-control"
    pattern=".{4,}" title="username must be larger than 4" type="text" name="user" required="required"  placeholder="usernames" autocomplete="off"/>
</div>
<div class="dis">   
<input  class="from-control"
minlength="4"
type="password" name="password"  required="required" placeholder="password" autocomplete="new-password"/>
</div>
<div class="dis">   
<input  class="from-control"
minlength="4"
type="password" name="password2" required="required" placeholder="confirm password" autocomplete="new-password"/>
</div>
<div class="dis">   
<input  class="from-control" type="email" name="email" required="required" placeholder="email" autocomplete="off"/>
</div>    
<input class="btn btn-success" type="submit" name="signup" value="signup" />
</form>
<div class="error text-center"> 
<?php
if(!empty($errorform)){

    foreach($errorform as $error){
        echo '<div class="alert alert-danger">'. $error .'</div>'.'<br>';
    }
}
if(isset($themsg)){
    echo $themsg;
}

?>
</div>
</div>



<?php include $tpl .'footer.php';?>