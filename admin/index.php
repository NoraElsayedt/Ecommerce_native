<?php 
session_start();
$nonavbr='';
$pagetitle='login';
if(isset ($_SESSION['username'])){
    header('location:dashbord.php');
}
include "init.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $usernames=$_POST['user'];
    $password=$_POST['password'];
    $hashpass=sha1($password);


    $stmt=$db->prepare("SELECT userID,username , password from users where username=? and password=? and groupID=1 LIMIT 1");
    $stmt->execute(array($usernames,$hashpass));
    $row=$stmt->fetch();
    $count=$stmt->rowCount();
    if($count>0){
        $_SESSION['username']=$usernames;
        $_SESSION['ID']=$row['userID'];
        header('location:dashbord.php');
        exit();

    }
    
}
 ?>

<form class="login" action=" <?php echo $_SERVER['PHP_SELF']?>" method="POST"   >
            <h5>Admin login</h5>
    <input class="from-control"  type="text" name="user" placeholder="usernames" autocomplete="off"/>
    <input  class="from-control" type="password" name="password" placeholder="password" autocomplete="new-password"/>
    <input class="btn btn-primary" type="submit" value="login" />
</form>

<?php
//echo lang ( 'MESSAGE') ." ".lang ( 'ADMIN');
//<i class="fa fa-home fa-3x" style="color=rea"></i>
?> 


<?php include $tpl.'footer.php' ?>

