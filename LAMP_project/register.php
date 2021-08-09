
<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Register</title>
</head> 
<body>
  <div class="title">
    <h1>Welcome to Pizza</h1>
    <p>Our website is place to order pizza, pasta, wings and so much more for fast and delicious delivery or pick-up. Order now and enjoy today!</p>
  </div>
  <!-- <div class="error"> -->
    
  <!-- </div> -->
  <div class="login-box">
    <?php include('errors.php');?>
    <h2>Register</h2>
    <form method="POST" action="register.php">
      <div class="form-input">
        <i class="fa fa-user" aria-hidden="true"></i>
        <input type="text" name="email" value="<?php echo $email;?>" placeholder="Email"/>	
      </div>
      <div class="form-input">
        <i class="fa fa-lock" aria-hidden="true"></i>
        <input type="password" name="password_1" placeholder="Password"/>
      </div>
      <div class="form-input">
        <i class="fa fa-lock" aria-hidden="true"></i>
        <input type="password" name="password_2" placeholder="Confirm Password"/>
      </div>
      <input type="submit" name="register" value="Sign up" class="btn"/>
      <div> 
        <a href="login.php">Existing account?</a>
      </div>
    </form>
  </div>
</body>
</html>