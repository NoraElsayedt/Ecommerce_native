<?php

ini_set('display_errors','On');
error_reporting(E_ALL);

include 'admin/connect.php';
$sessionuser='';
if(isset($_SESSION['user'])){
     $sessionuser=$_SESSION['user'];
}
//route
$tpl='include/templetes/';
$lang='include/languages/' ;
$fun='include/function/' ;
$css='design/css/';
$js='design/js/';


// file
include $fun.'function.php';
include $lang.'eng.php';
include $tpl.'header.php';
include $tpl.'navbar.php';


//include $lang.'arabic.php';




?>