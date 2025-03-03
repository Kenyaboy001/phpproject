<?php

if(isset($_POST['login'])){
  $email = filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);
  $password = $_POST["password"];
  
  $errors = array();
  
  if(empty($email) OR empty($password)){
    array_push($errors, "All Fields Are Required");
  }else{
    include("../database/index.php");
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    
    if($result->num_rows>0){
      while($rows ->$result->fetch_assoc()){
        if(password_verify($password, $row["password"])){
          echo "GOOD";
        }
      }
    }
  }
}