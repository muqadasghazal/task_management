<?php
   session_start();
   include('../dbconnection.php');
   if(isset($_POST['submit'])){
      $userName = $_POST['userName'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirmPassword = $_POST['confirmPassword'];

      if($password === $confirmPassword){
      
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO user (userName,email,password)
      VALUES ('$userName', '$email', '$hashedPassword')";

      $query = mysqli_query($conn , $sql);
      if($query){
         // storing in session variables to check in welcome that if user logges in then proceed further
         $_SESSION['userName'] = $userName;
         $_SESSION['email'] = $email;
         header("location: dashboard.php");

      }

      }
      else{
         echo("<script>  alert('Password and confirm password doesn't match')  </script>");
      }

   }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Signup</title>
</head>
<body>
   <section class="auth-section">
      <h2 >Welcome to Task Management System</h2>
            <div class="auth-content">
                 <div class="auth-text">
                    <h2>Sign Up</h2>
                    <form method="POST">
                       <input type="text" name="userName" placeholder="Enter Name" required>
                       <input type="text" name="email" placeholder="Enter Email" required>
                       <input type="password" name="password" placeholder="Enter Password" required>
                       <input type="password" name="confirmPassword" placeholder="Confirm Password" required>           
                       <button type="submit" name="submit" >Register</button>
                    </form>
                    <h5>
                    <a href="login.php"> Already have an account? </a>
                  </h5>

                 </div>
                 <div class="auth-image">
                    <img class="signup" src="../images/signupImage.png" >
                 </div>
            </div>
      
   </section>
</body>

</html>