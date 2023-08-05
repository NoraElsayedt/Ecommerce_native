<?php
$dsn='mysql:host=localhost;dbname=shop';
$user='root';
$pass='';
$option=array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
);
try{
$db=new PDO($dsn,$user,$pass,$option);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//echo "connect DB";
}
catch(PDOException $e){
    echo 'fail'.$e->getMessage();
}
?>
