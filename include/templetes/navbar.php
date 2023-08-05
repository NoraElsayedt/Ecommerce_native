<div class="upper">
<div class="container text-right">
<?php
if(isset ($_SESSION['user'])){?>
<img src="mountain1.jpg" alt="" class='img-responsive img-circle pull-left' />
<div class="btn-group myinfo pull-left">

  <span class="btn dropdown-toggle" data-toggle="dropdown">
    <?php echo $sessionuser ;?>
    </span>
    <ul class="dropdown-menu">
      <li><a href="profile.php"> my profile </a></li>
      <li> <a href="newads.php"> create new item</a></li>
      <li><a href="profile.php#myads"> My Items</a></li>
      <li><a href="logout.php"> logout </a></li>
</ul>
  
</div>

<?php
 
   $user=checkuser($sessionuser);
   if($user==1){
    // echo "  your membership need to actived admin";
   }
}else{
  ?>
  <a href="login.php"><span class="pull-right"> login/signup </span></a> 
<?php }?>
</div>
</div>
<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
  <div class="container">
    <div class="navbar-brand">
  
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" 
    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      <span class="navbar-toggler-icon"></span>
      <span class="navbar-toggler-icon"></span>
    </button>
    <a style="color:white;" href="index.php"><?php echo lang("HOME ADMIN")?></a>
</div>
    <div class="collapse navbar-collapse " id="app-nav">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <?php
      $category=getAllfrom("categories"," ID","WHERE parent=0");
foreach($category as $cat){
    echo '<li class="nav-item" >
    <a class="nav-link active" aria-current="page" href="categories.php?pageid='.$cat['ID'].'&pagename='.str_replace(' ','-',$cat['name']).'">'. $cat['name'] .'</a></li>';
} 

?>
</ul>
        
    </div>
  </div>
</nav>
