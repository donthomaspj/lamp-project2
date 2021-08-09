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
  
  $post->email = $_COOKIE["member_login"];
  
  $result = $post->getInfo();
  $num = $result->rowCount();

  if ($num > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $post_item = array(
        'name' => $name,
        'address'=> $address,
        'city'=> $city,
        'province'=>$province,
        'postalCode'=> $postalCode 
      );
      if (!$post_item['name'] || !$post_item['address'] || !$post_item['city'] || !$post_item['province'] || !$post_item['postalCode']) {
        fillForm($post);
      } else {
        echo '<h3>You already had delivery Details. CONTINUE to see your Order Summary. EDIT DETAILS to edit your delivery Details</h3>
              <form method="POST" action="">
                <input type="submit" name="continue" value="Continue">
              </form>
        ';
        
        echo details($post_item);
        
        echo '<br><br><p><strong>Fill the form to change your delivery Details!</strong></p><br><br';
        
        fillForm($post);
        
        if(isset($_POST['continue'])) {
          header("location: orderSummary.php");
        }
      }
    }
  } else{
    echo 'there are now row';
  }
?>