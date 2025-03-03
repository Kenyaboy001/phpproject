            <?php 
            session_start();
            if(isset($_POST['submit'])){
              $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
              $number = filter_input(INPUT_POST, "number", FILTER_SANITIZE_NUMBER_INT);
              $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
              $ref = $_GET['ref'];
              $password = $_POST["password"];
              $cpassword = $_POST["cpassword"];
              $pass = password_hash($password, PASSWORD_DEFAULT);
               $errors = array();
             
              if(empty($username) OR empty($number) OR empty($email) OR empty($ref) OR empty($password)){
                 array_push("All Fields Are Required", $errors);
              }else if($password != $cpassword){
                array_push($errors, "Password Must Match");
              
              }else{
                  require("../database/index.php");
                $sql = "SELECT * FROM users WHERE username ='$username'";
                
                $result = $conn->query($sql);
                if($result->num_rows>0){
                  
                  array_push($errors, "Username Already Exists");
                }else{
                  $sql = "SELECT * FROM users WHERE number='$number'";
                  $result = $conn->query($sql);
                  if($result->num_rows>0){
                    array_push($errors, "Phone Number Already Exists");
                  }else{
                  $sql = "SELECT * FROM users WHERE email='$email'";
                  $result = $conn->query($sql);
                  if($result->num_rows>0){
                    array_push($errors, "Email Already Exists");
                  }else if(empty($errors)){
                  include("../database/index.php");
                  $sql = "INSERT INTO `users` (`username`, `number`, `email`, `ref`, `password`) VALUES ('$username', '$number', '$email', '$ref', '$pass')";

                /*  $sql = "INSERT INTO 'users'('username','number','email','ref','password') VALUES('$username','$number','$email','$ref','$pass')"; */
                  $query = $conn->query($sql);
                  
                   if($query == TRUE){
                     
                    $sql1 = "SELECT id FROM users WHERE username='$username'";
                    $result = $conn->query($sql1);
                    if($result->num_rows>0){
                      while($rows = $result->fetch_assoc()){
                        $id = $rows["id"];
                        $_SESSION["id"] = $id;
                  $_SESSION["username"] = $rows["username"];
                        
                        header("Location: ../dashboard/");
                      }
                    }
                    }
                  }
                }
                }
                }
              
            }else{
              echo("ERROR");
            }
            
            if($errors > 0){
            ?>
            <html>
              <head>
                
              </head>
              <body>
                <h1><?php foreach($errors as $error){
                  echo $error;
                }
                
                ?></h1>
              </body>
            </html>
            <?php
            
            }
            ?>