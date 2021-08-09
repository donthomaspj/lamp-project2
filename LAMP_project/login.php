<?php include('serverLogin.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Login</title>
  
</head> 
<body>
  <div class="title">
    <h1>Welcome to Pizza</h1>
    <p>Our website is place to order pizza, pasta, wings and so much more for fast and delicious delivery or pick-up. Order now and enjoy today!</p>
  </div>
  <div class="login-box">
    <?php 
      include('errors.php');
    ?>
    <h2>Login</h2>
    <form method="POST">
      <div class="form-input">
        <i class="fa fa-user" aria-hidden="true"></i>
        <input type="text" name="email" placeholder="Email"/>	
      </div>
      <div class="form-input">
        <i class="fa fa-lock" aria-hidden="true"></i>
        <input type="password" name="password" placeholder="Password"/>
      </div>
      <input type="submit" name="login" value="Sign in" class="btn"/>
      <div> 
        <a href="register.php">Do not have an account?</a>
      </div>
    </form>
  </div>
</body>
</html>