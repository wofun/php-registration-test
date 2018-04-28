<?php defined('BASEDIR') OR exit('No direct script access allowed');?>
<?php include_once 'shared_header.php';?>

<div class="container">
   <div class="row">
      <div class="col-md-4 offset-md-4">
         <form method="post">
            <div class="form-group">
               <label for="inputEmail">Email address</label>
               <input type="email" name="email" value="<?php echo $data['email'] ?? '';?>" id="inputEmail"  class="form-control" placeholder="Enter email" required>
               <?php if (isset($errors['email'])):?>
                  <small class="text-danger"><?php echo $errors['email'];?></small>
               <?php endif;?>
            </div>
            <div class="form-group">
               <label for="inputPassword">Password</label>
               <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
               <?php if (isset($errors['password'])):?>
                  <small class="text-danger"><?php echo $errors['password'];?></small>
               <?php endif;?>
            </div>
            <!-- <div class="form-check">
               <input type="checkbox" class="form-check-input" id="rememberMe">
               <label class="form-check-label" for="rememberMe">Remember me</label>
            </div> -->
            <p class="text-right"><a href="/sign/up">Sign Up</a></p>
            <br />
            <div class="text-center">
               <button type="submit" class="btn btn-primary">Sing In</button>
            </div>
         </form>

         <?php if(!empty($data['registration_success'])):?>
            <br>
            <p>Your registration successfully completed, now you can sing in.</p>
         <?php endif;?>
      </div>
   </div>
</div>

<?php include_once 'shared_footer.php';?>