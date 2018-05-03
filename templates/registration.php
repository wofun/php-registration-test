<?php defined('ROOT_DIR') OR exit('No direct script access allowed');?>
<?php include_once 'shared_header.php';?>

<div class="container">
   <h1 class="text-center">Registration</h1>
   
   <div class="row">
      <div class="col-md-4 offset-md-4">
         <form method="post">
            <div class="form-group">
               <label for="firstName">First Name</label>
               <input type="text" name="first_name" value="<?php echo $data['first_name'] ?? '';?>" id="firstName" class="form-control" placeholder="First Name">
            </div>
            <div class="form-group">
               <label for="lastName">Last Name</label>
               <input type="text" name="last_name" value="<?php echo $data['last_name'] ?? '';?>" class="form-control" id="lastName" placeholder="Last Name">
            </div>
            <div class="form-group">
               <label for="inputEmail">Email address*</label>
               <input type="email" name="email" value="<?php echo $data['email'] ?? '';?>" id="inputEmail"  class="form-control" placeholder="Enter email" required>
               <?php if (isset($errors['email'])):?>
                  <small class="text-danger"><?php echo $errors['email'];?></small>
               <?php endif;?>
            </div>

            <div class="form-group">
               <label for="inputPassword">Password*</label>
               <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
               <?php if (isset($errors['password'])):?>
                  <small class="text-danger"><?php echo $errors['password'];?></small>
               <?php endif;?>
            </div>
            <div class="form-group">
               <label for="inputPasswordConfirm">Repeat Password*</label>
               <input type="password" name="password_confirm" class="form-control" id="inputPasswordConfirm" placeholder="Repeat Password" required>
               <?php if (isset($errors['password_confirm'])):?>
                  <small class="text-danger"><?php echo $errors['password_confirm'];?></small>
               <?php endif;?>
            </div>

           <div class="text-center"><button type="submit" class="btn btn-primary">Submit</button></div>
         </form>
      </div>
   </div>

   <p><a href="/sign/in/">Back to Login page</a></p>
</div>

<?php include_once 'shared_footer.php';?>