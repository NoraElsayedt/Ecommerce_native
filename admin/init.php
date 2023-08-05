<?php
include 'connect.php';

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

if(!isset($nonavbr)){include $tpl.'navbar.php';}

//include $lang.'arabic.php';




?>