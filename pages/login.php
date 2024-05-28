<?php
   session_start();
   include('../dbconnection.php');

   $emailerror = false;
   $passwordError = false;
   $notRegistered = false;

   if(isset($_POST['submit'])){
      $email = $_POST['email'];
      $password = $_POST['password'];

      if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailerror = true;
      }
      if(!$password){
        $passwordError = true;
      }

      if(!$emailerror && !$passwordError) {
          $query = "SELECT * FROM `user` WHERE `email` = '$email'";
          $result = mysqli_query($conn , $query);
    
          if($result){
              if(mysqli_num_rows($result)==1){
                  $fetch = mysqli_fetch_assoc($result);
                  if(password_verify($password , $fetch['password'])){
                      $_SESSION['userName'] = $fetch['userName'];
                      $_SESSION['email'] = $fetch['email'];
                      header("location: dashboard.php");
                      exit();
                  } else {
                    $passwordError = true;
                  }
              } else {
                  $notRegistered = true;
              }
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

    <style>
      
        @media screen and (min-width: 300px , max-width: 600px) {
            .auth-content{
            display: flex;
            flex-direction: row;
            justify-content: center;
            border-radius:20px;
            padding: 0px 38px;
            gap: 4rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            width: 100%;
            }
            img{
                display : none;
            }
         }
         @media screen and (max-width: 300px) {
            .auth-content{
            display: flex;
            flex-direction: row;
            justify-content: center;
            border-radius:20px;
            padding: 0px 38px;
            gap: 4rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            width: 100%;
            }
            img{
                display : none;
            }
         }
    </style>
</head>
<body>
   <section class="auth-section">
          <h2>Task Management System</h2>
          <div class="auth-content">
              <div class="auth-image">
                  <img class="signin" src="../images/signin-image.jpg" >
              </div>
              <div class="auth-text">
                  <h2>Login</h2>
                  <form method="POST">

                  <?php if ($notRegistered): ?>
                          <div class="error-message">Please register first.</div>
                  <?php endif; ?>

                      <input type="text" name="email" placeholder="Enter Email" 
                             class="<?php echo $emailerror ? 'error' : ''; ?>" required>
                      <?php if ($emailerror): ?>
                          <div class="error-message">Please enter a valid email address.</div>
                      <?php endif; ?>
                      <input type="password" name="password" placeholder="Enter Password" 
                             class="<?php echo $passwordError ? 'error' : ''; ?>" required>
                      <?php if ($passwordError): ?>
                          <div class="error-message">Please enter your correct password.</div>
                      <?php endif; ?>
                      <button type="submit" name="submit">Login</button>
                  </form>
                  <h5><a href="signup.php">Create account?</a></h5>
              </div>
          </div>
   </section>
</body>
</html>
