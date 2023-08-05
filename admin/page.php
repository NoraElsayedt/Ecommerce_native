<?php

ob_start();
session_start();
if(isset ($_SESSION['username'])){
  $pagetitle='dashbord';
  include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';

// if($do=="manage"){
//     echo"welcame to manage";
//     echo'<a href="page.php?do=add">add+</a>';
// }
// elseif($do=="add"){
//     echo"welcame to add";
// }
// elseif($do=="insert"){
//     echo"welcame to insert";
// }
// else{
//     echo"error";
// }

include $tpl.'footer.php';
}
else{
    
    header('location:index.php');
    exit();
}
ob_end_flush();


?>