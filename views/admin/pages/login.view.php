<?php if(!empty($errors)) : ?>
    <p><?php echo e($errors[0]) ?></p>
<?php endif; ?>

<form action="index.php?route=admin/login" method="post">
    <label for="">Username</label>
    <input type="text" name="username" value="<?php if(!empty($username)) echo  $username?>">

    <label for="">Password</label>
    <input type="password" name="password">
    <br>
   <button type="submit">Submit</button>
    
</form>