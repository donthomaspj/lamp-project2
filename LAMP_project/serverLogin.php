<?php
  session_start();
  $host = 'localhost';
  $username = 'sontran';
  $password = '123';
  $database = 'pizza_store';
  $errors  = '';
  try {
    $connect = new PDO("mysql:host=$host; dbname=$database",$username,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_POST["login"])) {
      if(empty($_POST["email"])  || empty($_POST["password"])) {
        $errors = "All fields is required";
      }
      else {
        $query = "SELECT * FROM tblcustomers WHERE email = :email AND password = :password";
        $statement = $connect->prepare($query);
        $statement->execute(
          array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
          )
          );
          $count = $statement->rowCount();
          if ($count > 0) {
            $_SESSION['email'] = $_POST['email'];
            // variable to access another page
            setcookie("member_login", $_POST['email']);
            
            header("location:loginSuccess.php");
          }
          else {
            $errors = "Email or Password is wrong";
          }
      }
    }
  }
  catch (PDOException $error) {
    $errors = $error->getMessage();
  }
  $email = '';
?>