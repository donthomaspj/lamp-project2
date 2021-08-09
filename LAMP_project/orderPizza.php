<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h3>Please fill out the form</h3>
  <form method="POST" action="">
    <p>
      Dough
      <select name="dough" id="dough">
        <option value="">Select...</option>
        <option value="no">No dough</option>
        <option value="d1">D1</option>
        <option value="d2">D2</option>
        <option value="d3">D3</option>
      </select>
    </p>
    <p>
      Cheese
      <select name="cheese" id="cheese">
        <option value="">Select...</option>
        <option value="no">No cheese</option>
        <option value="c1">C1</option>
        <option value="c2">C2</option>
        <option value="c3">C3</option>
      </select>
    </p>
    <p>
      Sauce
      <select name="sauce" id="sauce">
        <option value="">Select...</option>
        <option value="no">No sauce</option>
        <option value="s1">S1</option>
        <option value="s2">S2</option>
        <option value="s3">S3</option>
      </select>
    </p>
    <p>
      Toppings
      <select name="toppings" id="toppings">
        <option value="">Select...</option>
        <option value="no">No toppings</option>
        <option value="t1">T1</option>
        <option value="t2">T2</option>
        <option value="t3">T3</option>
      </select>
    </p>
    <input type="submit" name="confirm" value="Add Multiple Pizza">
    <input type="submit" name="confirm" value="Order">
  </form>
</body>

</html>

<?php
  if(!$_COOKIE["member_login"]) {
      header("location: login.php");
  }

  include_once('Post.php');
  include_once('Database.php');

  $database = new Database();
  $db = $database->connect();
    
  $post = new Post($db);
  
  $post->email = $_COOKIE['member_login'];
  $post->orderID = $_SESSION['random'];
  
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    submitPizza($post);
    if($_POST['confirm'] == 'Order') {
      header("location:userInformation.php");
    }
    else if($_POST['confirm'] == 'Add Multiple Pizza') {
      header("location: confirm.php");
  }
}
?>