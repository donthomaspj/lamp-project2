<?php

  session_start();
  if(!$_COOKIE["member_login"]) {
      header("location: login.php");
  }
    
  include_once('Post.php');
  include_once('Database.php');

  $database = new Database();
  $db = $database->connect();
  
  $post = new Post($db);

  $email = $_COOKIE['member_login'];
  $post->orderID = $_SESSION['random'];

  $result = $post->displayOrder();

  $num = $result->rowCount();
      
  if($num > 0) {
    $arrOrderID = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'orderID' => $orderID,
        'pizzaID'=> $pizzaID,
        'dough' => $dough,
        'cheese'=> $cheese,
        'sauce'=> $sauce,
        'toppings'=> $toppings,
        'name'=> $name,
        'address'=> $address,
        'city'=> $city,
        'province'=> $province,
        'postalCode'=> $postalCode
      );
      // Push to "data"
      array_push($arrOrderID, $post_item);
    }
  } else{echo 'No data';}
  ?>

<html>

<body>
  <p><strong><?php echo $email ?></strong> ordered</p>
  <p>Your <strong>OrderID: <?php echo $arrOrderID[0]['orderID'] ?></strong></p>
  <table border="1">
    <tr>
      <th>PizzaID</th>
      <th>Dough</th>
      <th>Cheese</th>
      <th>Sauce</th>
      <th>Toppings</th>

    </tr>
    <?php
		for ($i = 0; $i < count($arrOrderID); $i++) {
			printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n", 
				$arrOrderID[$i]['pizzaID'],
				$arrOrderID[$i]['dough'],
				$arrOrderID[$i]['cheese'],
				$arrOrderID[$i]['sauce'],
				$arrOrderID[$i]['toppings'],
			);
		}
    echo "</table>\n"; 
    
    $detail = $arrOrderID[0];
    
    echo details($detail);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      header("location: previousOrders.php");
    }
    
    ?>
    <form method="POST">
      <input type="submit" name="preOrders" value="Previous Orders">
    </form>
</body>

</html>