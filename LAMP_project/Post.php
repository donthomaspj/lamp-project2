<?php 
  class Post {
    private $conn;
   
    public $email;
    public $password;
    
    public $name;
    public $address;
    public $city;
    public $province;
    public $postalCode;
    
    public $orderID;
    public $date;

    public $pizzaID;
    
    public $dough;
    public $cheese;
    public $sauce;
    public $toppings;
    public $poID;

    public function __construct($db) {
      $this->conn = $db;
    }

    // public function createCustomers() {
    //   $query = 'INSERT INTO `tblcustomers` SET `email` = :email, `delivery_details` = :delivery_details, `password` = :password';
  
    //   $stmt = $this->conn->prepare($query);

    //   $this->email = htmlspecialchars(strip_tags($this->email));
    //   $this->delivery_details = htmlspecialchars(strip_tags($this->delivery_details));
    //   $this->password = htmlspecialchars(strip_tags($this->password));

    //   $stmt->bindParam(':email', $this->email);
    //   $stmt->bindParam(':delivery_details', $this->delivery_details);
    //   $stmt->bindParam(':password', $this->password);
      
    //   $stmt->execute();
    // }

    public function createPizza() {
      $query = 'INSERT INTO `tblpizza` SET dough = :dough, cheese = :cheese, sauce = :sauce, toppings = :toppings';


      $stmt = $this->conn->prepare($query);
      
      // // Clean data
      $this->dough = htmlspecialchars(strip_tags($this->dough));
      $this->cheese = htmlspecialchars(strip_tags($this->cheese));
      $this->sauce = htmlspecialchars(strip_tags($this->sauce));
      $this->toppings = htmlspecialchars(strip_tags($this->toppings));

      // Bind data
      $stmt->bindParam(':dough', $this->dough);
      $stmt->bindParam(':cheese', $this->cheese);
      $stmt->bindParam(':sauce', $this->sauce);
      $stmt->bindParam(':toppings', $this->toppings);

      $stmt->execute();
      
    }

    public function createOrder() {
      
        $qu = 'SELECT orderID FROM tblorders WHERE orderID = :orderID';
        
        $stmt1 = $this->conn->prepare($qu);
        
        $this->orderID = htmlspecialchars(strip_tags($this->orderID));
        
        $stmt1->bindParam(':orderID', $this->orderID);
        $stmt1->execute();
        
        $num = $stmt1-> rowCount();
        
        if ($num == 0) {
          $query = 'INSERT INTO tblorders SET orderID = :orderID, email = :email';
      
          $stmt = $this->conn->prepare($query);
          
          // Clean data
          $this->orderID = htmlspecialchars(strip_tags($this->orderID));
          $this->email = htmlspecialchars(strip_tags($this->email));

          // Bind data
          $stmt->bindParam(':orderID', $this->orderID);
          $stmt->bindParam(':email', $this->email);

          $stmt->execute();
        } else {
          
        }
  
    }

    public function createPizzaOrder() {
      // get the last row added to insert into PizzaOrder 
      $queryPizza = 'SELECT pizzaID FROM tblpizza ORDER BY pizzaID DESC LIMIT 1';

      // Prepare statement
      $stmt1 = $this->conn->prepare($queryPizza);
      
      // Execute query
      $stmt1->execute();

      // Get row count
      $num1 = $stmt1->rowCount();

      if ($num1 > 0) {
        while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $post_item1 = array('pizzaID'=> $pizzaID);
        }
      }

      // insert orderID and pizzaID to pizzaOrders
      $query = 'INSERT INTO `tblpizzaorders` SET orderID = :orderID, pizzaID = :pizzaID';
      
      $stmt = $this->conn->prepare($query);
      
      // Clean data
      $this->orderID = htmlspecialchars(strip_tags($this->orderID));
      $this->pizzaID = htmlspecialchars(strip_tags($pizzaID));
      
      // Bind data
      $stmt->bindParam(':orderID', $this->orderID);
      $stmt->bindParam(':pizzaID', $this->pizzaID);

      $stmt->execute();
    }

    public function getInfo() {
      $query = "SELECT name, address, city, province, postalCode 
                FROM tblcustomers 
                WHERE email = :email";
                
      $stmt = $this->conn->prepare($query);
      
      // Clean data
      $this->email = htmlspecialchars(strip_tags($this->email));
      // Bind data
      $stmt->bindParam(':email', $this->email);
      
      $stmt->execute();
      return $stmt;
    }

    public function deliveryDetails() {
      $query = "UPDATE tblcustomers SET name = :name, address = :address, city = :city, province = :province, postalCode= :postalCode
                WHERE email = :email
      ";
      $stmt = $this->conn->prepare($query);

      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->address = htmlspecialchars(strip_tags($this->address));
      $this->city = htmlspecialchars(strip_tags($this->city));
      $this->province = htmlspecialchars(strip_tags($this->province));
      $this->postalCode = htmlspecialchars(strip_tags($this->postalCode));
      // $this->email = htmlspecialchars(strip_tags($this->email));

      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':address', $this->address);
      $stmt->bindParam(':city', $this->city);
      $stmt->bindParam(':province', $this->province);
      $stmt->bindParam(':postalCode', $this->postalCode);
      $stmt->bindParam(':email', $this->email);
      $stmt->execute();
    }

    public function reOrder() {
      $query = 'DELETE FROM tblorders WHERE orderID = :orderID;
                DELETE FROM tblpizza WHERE pizzaID = ANY(
                  SELECT pizzaID FROM tblpizzaorders WHERE orderID = :orderID
                );
                DELETE FROM tblpizzaorders WHERE orderID = :orderID';

      $stmt = $this->conn->prepare($query);
      $this->orderID = htmlspecialchars(strip_tags($this->orderID));
      $stmt->bindParam(':orderID', $this->orderID);
      $stmt->execute();
    }

    public function displayOrder() {
      $query = 'SELECT o.orderID, p.pizzaID, dough, cheese, sauce, toppings, name, address, city, province, postalCode 
                FROM tblorders o INNER JOIN tblcustomers c ON o.email = c.email
                INNER JOIN tblpizzaorders po ON o.orderID = po.orderID
                INNER JOIN tblpizza p ON po.pizzaID = p.pizzaID
                WHERE o.orderID = :orderID';
      
      $stmt = $this->conn->prepare($query);
      $this->orderID = htmlspecialchars(strip_tags($this->orderID));
      
      $stmt->bindParam(':orderID', $this->orderID);
      $stmt->execute();
      
      return $stmt;
    }

    public function previousOrder() {
      $query = 'SELECT o.orderID, p.pizzaID, dough, cheese, sauce, toppings, date
                FROM tblorders o INNER JOIN tblpizzaorders po ON o.orderID = po.orderID
                INNER JOIN tblpizza p ON p.pizzaID = po.pizzaID
                WHERE o.orderID <> :orderID and o.email = :email';
      
      $stmt = $this->conn->prepare($query);
      $this->orderID = htmlspecialchars(strip_tags($this->orderID));
      $this->email = htmlspecialchars(strip_tags($this->email));
      
      $stmt->bindParam(':orderID', $this->orderID);
      $stmt->bindParam(':email', $this->email);
      
      $stmt->execute();
      
      return $stmt;
      
    }
    
  }
  
  function submitPizza($post) {

    $dough = $_POST['dough'];
    $cheese = $_POST['cheese'];
    $sauce = $_POST['sauce'];
    $toppings = $_POST['toppings'];
    
    $post->dough = $dough;
    $post->cheese = $cheese;
    $post->sauce = $sauce;
    $post->toppings = $toppings;
   
    $post->createPizza();
    $post->createOrder();
    $post->createPizzaOrder();
  }

  function fillForm($post) {
    echo '
              <h3>Fill your details!</h3><br>
              <form method="POST" action="">
                Name: <input type="text" name="name"><br><br>
                Address: <input type="text" name="address"><br><br>
                City: <input type="text" name="city"><br><br>
                Province: <input type="text" name="province"><br><br>
                Postal Code: <input type="text" name="postalCode"><br><br>
                <input type="submit" name="confirmInfo" value="Create Details">
              </form>
                ';
    if (isset($_POST['confirmInfo'])) {
      if (empty($_POST['name']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['province']) ||empty($_POST['postalCode'])) {
        echo 'Please fill all information!';
      } else {
        $post->name = $_POST['name'];
        $post->address = $_POST['address'];
        $post->city = $_POST['city'];
        $post->province = $_POST['province'];
        $post->postalCode = $_POST['postalCode'];
        
        $post->deliveryDetails();
        header("location: orderSummary.php");
      }
    }
  }         
  
  function details($post) {
    return '<h3>Pizza will be ready in 40 minutes and will be delivered to Address</h3>
            <p><strong>Name: </strong>' .$post['name'] . '</p>' .
            '<p><strong>Address: </strong>' .$post['address'] . '</p>' .
            '<p><strong>City: </strong>' .$post['city'] . '</p>' .
            '<p><strong>Province: </strong>' .$post['province'] . '</p>' .
            '<p><strong>Postal Code: </strong>' .$post['postalCode'] . '</p>';
  }
  // random ID
  function getRandom() { 
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
      $randomString = ''; 
    
      for ($i = 0; $i < 10; $i++) { 
          $index = rand(0, strlen($characters) - 1); 
          $randomString .= $characters[$index]; 
      } 
    
      return $randomString; 
  }