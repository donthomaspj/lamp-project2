<?php
  session_start();
  $email = "";
  $password_1 = "";
  $password_2 = "";
  $errors = '';

  // connect to database
  $db = new mysqli('localhost', 'sontran', '123', 'pizza_store');

  // of the register button is clicked
  if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    if (empty($email)) {
      $errors = "Email is required";
    }
    else if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors = "Email is invalid! email must be your email";
    }
    else if (empty($password_1)) {
      $errors = "Password is required";
    }
    else if ($password_1 !== $password_2) {
      $errors = "Do not match password";
    }

    else {
      $duplicate = mysqli_query($db, "SELECT * FROM  tblcustomers WHERE email = '$email'");
      if (mysqli_num_rows($duplicate)>0) {
        $errors = "The email is already exists";
      }
      else {
        $sql = "INSERT INTO `tblcustomers` ( `email`, `password`) VALUES ('$email', '$password_1')";
        mysqli_query($db,$sql);
        header('location: login.php');
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
      }
      
    }
  }

?>