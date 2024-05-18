<?php
   session_start();
   include('../dbconnection.php');
   if(isset($_POST['submit'])){
      $email = $_POST['email'];
      $password = $_POST['password'];
      $query = "SELECT * FROM `user` WHERE `email` = '$email'";
      $result= mysqli_query($conn , $query);

        if($result){
            if(mysqli_num_rows($result)==1){
                $fetch = mysqli_fetch_assoc($result);
                if(password_verify($password , $fetch['password'])){
                    $_SESSION['userName'] = $fetch['userName'];
                    $_SESSION['email'] = $fetch['email'];
                    header("location: dashboard.php");
                }
                else{
                    echo("
                    <script>
                        alert('password incorrect');
                    </script>    
                    ");
                }


            }
            else{
                echo(" <script> alert('email incorrect');  </script>").mysqli_error($conn);
            }
        }
    }

     

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Login</title>
</head>
<body>
   <section class="auth-section">
          <h2 > Task Management System</h2>
            <div class="auth-content">
                <div class="auth-image">
                    <img class="signin"src="../images/signin-image.jpg" >
                </div>
                <div class="auth-text">
                    <h2>Login</h2>
                    <form method="POST">
                        <input type="text" name="email" placeholder="Enter Email" required>
                        <input type="password" name="password" placeholder="Enter Password" required>
                        <button type="submit" name="submit">Login</button>
                    </form>
                    <h5>
                    <a href="signup.php"> Create account? </a>
                  </h5>
                </div>
            </div>
      
   </section>
</body>

</html>