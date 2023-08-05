<?php
//title
function gettitle(){
    global $pagetitle;
    if(isset($pagetitle)){
        echo $pagetitle;
    }
    else{
        echo "defult";
    }
}


// redirect

function redirecthome($themsg,$url=null,$second=3)
{
    if($url===null){
        $url='index.php';
    }
    else{
        $url=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''?$_SERVER['HTTP_REFERER']:'index.php';

        }
    
    echo$themsg;
    echo"<div class='alert alert-info'>YOU redirect to $url after $second second</div>";
    header("refresh:$second; url=$url");
    exit();
}


// check data

function checkitem($select , $from, $value){
    global $db;
    $stmt=$db->prepare("SELECT $select from $from where $select=? ");
    $stmt->execute(array($value));
    $count=$stmt->rowCount();
    return $count;

}


// count items
function countitem($item , $table){
global $db;
$stmt=$db->prepare("SELECT COUNT($item)from $table ");
$stmt->execute();
return $stmt->fetchColumn();
}

// latest items

function getlatest($select ,$from,$order ,$value=5){
    global $db;
    $stmt=$db->prepare("SELECT $select from $from ORDER BY $order DESC  LIMIT $value ");
    $stmt->execute();
    $count=$stmt->fetchAll();
    return $count;

}
//  categories


function getcat(){
    global $db;
    $stmt=$db->prepare("SELECT * from categories ORDER BY ID ASC   ");
    $stmt->execute();
    $count=$stmt->fetchAll();
    return $count;

}


//  items


function getitem($where,$value, $approve=null){
    global $db;
    if($approve==null){
        $sql='AND aprove=1';
    }
    else{
        $sql=null;
    }
    $stmt=$db->prepare("SELECT * from items WHERE $where=? $sql ORDER BY ID DESC   ");
    $stmt->execute(array($value));
    $count=$stmt->fetchAll();
    return $count;

}


//  check users

function checkuser($user){
    global $db;
    $stmt=$db->prepare("SELECT username , regstatus from users where username=? and regstatus=0");
    $stmt->execute(array($user));
    $count=$stmt->rowCount();
    return $count;
}


function getAllfrom($tablename, $orderby, $where=null){
    global $db;
    $sql=$where== NULL ? '':$where;
    $stmt=$db->prepare("SELECT * from $tablename  $sql ORDER BY $orderby DESC  ");
    $stmt->execute();
    $all=$stmt->fetchAll();
    return $all;

}