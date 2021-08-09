<?php
  session_start();
  if(!$_COOKIE["member_login"]) {
      header("location: login.php");
  }

  echo '<h3>You Previous Orders</h3><br>';

  include_once('Post.php');
  include_once('Database.php');

  $database = new Database();
  $db = $database->connect();
  
  $post = new Post($db);
  $post->orderID = $_SESSION['random'];
  $post->email = $_COOKIE["member_login"];
  
  $result = $post->previousOrder();

  $num = $result->rowCount();
  
  if($num > 0) {
    $arrPreOrder = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'orderID' => $orderID,
        'pizzaID'=> $pizzaID,
        'dough' => $dough,
        'cheese'=> $cheese,
        'sauce'=> $sauce,
        'toppings'=> $toppings,
        'date' => 'date'
      );
      // Push to "data"
      array_push($arrPreOrder, $post_item);
    }

    echo '
        <table border="1">
        <tr>
          <th>OrderID</th>
          <th>PizzaID</th>
          <th>Dough</th>
          <th>Cheese</th>
          <th>Sauce</th>
          <th>Toppings</th>

        </tr>';
    for ($i = 0; $i < count($arrPreOrder); $i++) {
			printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n", 
				$arrPreOrder[$i]['orderID'],
				$arrPreOrder[$i]['pizzaID'],
				$arrPreOrder[$i]['dough'],
				$arrPreOrder[$i]['cheese'],
				$arrPreOrder[$i]['sauce'],
				$arrPreOrder[$i]['toppings'],
			);
		}
    echo "</table>\n"; 
    
  } else{echo '<h3>You do not have Previous Orders. This is your first time Order Pizza!</h3>';}

  session_destroy();
  // logout email
  setcookie("member_login", $_POST['email'], time() -3600);