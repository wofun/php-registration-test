<?php defined('ROOT_DIR') OR exit('No direct script access allowed');?>
<?php
   $page['html_title'] = $page['html_title'] ?? 'Homepage';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title><?php echo $page['html_title'] ?> - Test - SkySilk</title>

   <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
   
</head>
<body>
   <header><p class="h2">Test - SkySilk</p></header>
   
   <?php if(!empty($_SESSION['loggedIn'])): ?>
   <nav>
      <div class=" text-right">
         Hi, <?php echo $_SESSION['user']['first_name'] .' '.$_SESSION['user']['last_name'];?> 
         <a href="/sign/out" class="btn btn-sm btn-primary">Logout</a>&nbsp;&nbsp;&nbsp;
      </div>
   </nav>
   <?php endif;?>