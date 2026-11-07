<?php
 include("includes/config.php");
 include("includes/classes/Account.php");
 include("includes/classes/Constants.php");

  $account = new Account($con);
  
  include("includes/handlers/register-handler.php");
  include("includes/handlers/login-handler.php");

  function getInputValue($name) {
    if(isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/register.css">
  <title>Welcome to Zinx!</title>
</head>
<body>
  <div id="background">
    <div id="inputContainer">
      <form action="register.php" id="loginForm" method="POST">
        <h2>Login to your account</h2>
        <p>
          <?php echo $account->getError(Constants::$loginFailed);?>
          <label for="loginUsername">Username</label>
          <input type="text" id="loginUsername" name="loginUsername" placeholder="John Adams" required>
        </p>  

        <p>
          <label for="loginPassword">Password</label>
          <input type="password" id="loginPassword" name="loginPassword" placeholder="Enter password" required>
        </p>  
        <button name="loginButton" type="submit">LOG IN</button>    
      </form>

      <form action="register.php" id="registerForm" method="POST">
        <h2>Create your free account</h2>
        <p>
          <?php echo $account->getError(Constants::$usernameCharacters);?>
          <?php echo $account->getError(Constants::$usernameTaken);?>
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="John Adams" value="<?php getInputValue('username')?>" required>
        </p>   
        
        <p>
          <?php echo $account->getError(Constants::$firstNameCharacters);?>
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="firstName" placeholder="John" value="<?php getInputValue('firstName')?>"required>
        </p> 

        <p>
          <?php echo $account->getError(Constants::$lastNameCharacters);?>
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" placeholder="Adams" value="<?php getInputValue('lastName')?>"required>
        </p> 

        <p>
          <?php echo $account->getError(Constants::$emailsDoNotMatch);?>
          <?php echo $account->getError(Constants::$emailInvalid);?>
          <?php echo $account->getError(Constants::$emailTaken);?>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="john.adams@gmail.com" value="<?php getInputValue('email')?>"required>
        </p> 

        <p>
          <label for="email2">Confirm Email</label>
          <input type="email" id="email2" name="email2" placeholder="john.adams@gmail.com" value="<?php getInputValue('email2')?>"required>
        </p> 

        <p>
          <?php echo $account->getError(Constants::$passwordsDoNotMatch);?>
          <?php echo $account->getError(Constants::$passwordNotAlphanumeric);?>
          <?php echo $account->getError(Constants::$passwordCharacters);?>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter password" required>
        </p> 

        <p>
          <label for="password2">Confirm Password</label>
          <input type="password" id="password2" name="password2" placeholder="Confirm password" required>
        </p>  
        <button name="registerButton" type="submit">SIGN UP</button>    
      </form>
    </div>
  </div>
</body>
</html>