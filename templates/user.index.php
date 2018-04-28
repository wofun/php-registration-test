<?php defined('BASEDIR') OR exit('No direct script access allowed');?>
<?php include_once 'shared_header.php';?>

<div class="container">

   <div class="row">
      <div class="col-md-8 offset-md-2">

         <h1>User Page</h1>
         
         <br>
         <table class="table table-sm">
           <tbody>
             <tr>
               <th scope="row">Name</th>
               <td><?php echo $_SESSION['user']['first_name'] .' '.$_SESSION['user']['last_name'];?></td>
             </tr>
             <tr>
               <th scope="row">Email</th>
               <td><?php echo $_SESSION['user']['email'];?></td>
             </tr>
             <tr>
               <th scope="row">Registration Date</th>
               <td><?php echo $_SESSION['user']['date'];?></td>
             </tr>
           </tbody>
         </table>

         <p class="text-center"><a href="/user/edit" class="btn btn-big btn-primary">Edit</a></p>
      </div>
   </div>
</div>

<?php include_once 'shared_footer.php';?>