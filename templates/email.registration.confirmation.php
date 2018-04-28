<?php defined('BASEDIR') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Registration confirmation</title>
</head>
<body>

   <h1>Registration</h1>
   <?php 
      $url = get_base_url().'/sign/confirmation/code/'.$code;
   ?>
   <p>
      Hello<?php if (!empty($first_name)): ?>, <?php echo $first_name ?><?php endif;?>! <br/>
      You have registered on our site. To confirm the registration, please click on the following link: <a href="<?php echo $url;?>"><?php echo $url;?></a>
   </p>

</body>
</html>