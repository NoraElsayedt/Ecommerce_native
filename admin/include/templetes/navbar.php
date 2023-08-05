
<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashbord.php"><?php echo lang("HOME ADMIN")?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" 
    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="categories.php"><?php echo lang("CATEGORYES")?></a>
        </li> 
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="item.php"><?php echo lang("ITEMS")?></a>
        </li>   
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="member.php"><?php echo lang("MEMBERS")?></a>
        </li> 
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="comment.php"><?php echo lang("COMMENTS")?></a>
        </li>   
             
</ul>
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            MORE
          </a>
          <ul class="dropdown-menu ">
          <li><a class="dropdown-item" href="../index.php" target="_blank">Visit Shop </a></li>
            <li><a class="dropdown-item" href="member.php?do=edit&userid=<?php echo $_SESSION['ID']?>">Edit</a></li>
            <li><a class="dropdown-item" href="#">setting</a></li>
            <li><a class="dropdown-item" href="logout.php">logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
