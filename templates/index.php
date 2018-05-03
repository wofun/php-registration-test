<?php defined('ROOT_DIR') OR exit('No direct script access allowed');?>
<?php include_once 'shared_header.php';?>

<div class="container">
   <div class="row">
      <div class="col-md-4 offset-md-4">
         <form method="post" action="/sing/in/">
            <div class="form-group">
               <label for="inputEmail">Email address</label>
               <input type="email" class="form-control" id="inputEmail" placeholder="Enter email" required>
            </div>
            <div class="form-group">
               <label for="inputPassword">Password</label>
               <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
            </div>
            <div class="form-check">
               <input type="checkbox" class="form-check-input" id="rememberMe">
               <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <p class="text-right"><a href="/sign/up">Sign Up</a></p>
            <br />
            <div class="text-center">
               <button type="submit" class="btn btn-primary">Sing In</button>
            </div>
         </form>

         <?php if(!empty($_SESSION['registration_success'])):?>
            <p>Your registration successfully completed, now you can sing in.</p>
         <?php endif;?>
      </div>
   </div>
</div>

<?php include_once 'shared_footer.php';?>