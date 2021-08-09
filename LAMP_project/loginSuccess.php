<?php
  include_once('Post.php');
  session_start();
  if(isset($_SESSION['email'])) {
    echo '
      <h3 style="text-align: center; color: #3ea830">Login successful</h3>
    ';
  }
  if(!isset($_SESSION['random'])) {
    $_SESSION['random'] = getRandom();
  }
?>

<html>

<style>
.btn {
  background: rgb(144, 168, 142);
  border: 2px solid rgb(92, 138, 88);
  color: #fff;
  padding: 5px;
  font-size: 18px;
  cursor: pointer;
  margin: 12px 0;
  padding: 5px 15px;
  border-radius: 20px;
  position: absolute;
}
</style>

<body>
  <div>
    <a href="orderPizza.php" class="btn">Begin</a>
  </div>
</body>

</html>