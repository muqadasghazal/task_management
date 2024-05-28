<?php
session_start();
include('../dbconnection.php');

$emailerror = false;
$passwordError = false;
$nameError = false;
$confirmPasswordError = false;
$userExistsError = false;

if (isset($_POST['submit'])) {
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!$userName) {
        $nameError = true;
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerror = true;
    }
    if (!$password) {
        $passwordError = true;
    }
    if (!$confirmPassword || $password !== $confirmPassword) {
        $confirmPasswordError = true;
    }

    // Check if user already exists
    if (!$emailerror) {
        $matchUser = "SELECT * FROM `user` WHERE `email` = '$email'";
        $userMatches = mysqli_query($conn, $matchUser);
        if (mysqli_num_rows($userMatches) > 0) {
            $userExistsError = true;
        }
    }

    if (!$emailerror && !$passwordError && !$confirmPasswordError && !$nameError && !$userExistsError) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (userName, email, password) VALUES ('$userName', '$email', '$hashedPassword')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $_SESSION['userName'] = $userName;
            $_SESSION['email'] = $email;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Error: Could not execute query.');</script>";
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
    <style>
        .error {
            border: 1px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
        }
        @media screen and (max-width: 600px) {
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
    <title>Signup</title>
</head>
<body>
   <section class="auth-section">
      <h2>Welcome to Task Management System</h2>
      <div class="auth-content">
          <div class="auth-text">
              <h2>Sign Up</h2>
              <form method="POST">
                  <input type="text" name="userName" placeholder="Enter name" class="<?php echo $nameError ? 'error' : ''; ?>" value="<?php echo isset($userName) ? htmlspecialchars($userName) : ''; ?>">
                  <?php if ($nameError): ?>
                      <div class="error-message">Please enter your name.</div>
                  <?php endif; ?>

                  <input type="text" name="email" placeholder="Enter Email" class="<?php echo $emailerror || $userExistsError ? 'error' : ''; ?>" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                  <?php if ($emailerror): ?>
                      <div class="error-message">Please enter a valid email address.</div>
                  <?php endif; ?>
                  <?php if ($userExistsError): ?>
                      <div class="error-message">User with the same email already exists.</div>
                  <?php endif; ?>

                  <input type="password" name="password" placeholder="Enter Password" class="<?php echo $passwordError ? 'error' : ''; ?>">
                  <?php if ($passwordError): ?>
                      <div class="error-message">Please enter your password.</div>
                  <?php endif; ?>
                  
                  <input type="password" name="confirmPassword" placeholder="Confirm Password" class="<?php echo $confirmPasswordError ? 'error' : ''; ?>">
                  <?php if ($confirmPasswordError): ?>
                      <div class="error-message">Passwords do not match.</div>
                  <?php endif; ?>

                  <button type="submit" name="submit">Register</button>
              </form>
              <h5>
                  <a href="login.php">Already have an account?</a>
              </h5>
          </div>
          <div class="auth-image">
              <img class="signup" src="../images/signupImage.png">
          </div>
      </div>
   </section>
</body>
</html>
