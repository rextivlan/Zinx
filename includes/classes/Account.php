<?php
  class Account {

    private $con;
    private $errorArray;

    public function __construct($con) {
      $this->con = $con;
      $this->errorArray = array();
    }

    public function login($un, $pwd) {
      $pwd = md5($pwd);
      $query = mysqli_query($this->con, "SELECT * FROM user WHERE username='$un' AND password='$pwd'");

      if(mysqli_num_rows($query) == 1) {
        return true;
      }
      else {
        array_push($this->errorArray, Constants::$loginFailed);
        return false;
      }
    }

    public function register($un, $fn, $ln, $em, $em2, $pwd, $pwd2) {
      // Calling validation functions
      $this->validateUsername($un);
      $this->validateFirstName($fn);
      $this->validateLastName($ln);
      $this->validateEmails($em, $em2);
      $this->validatePasswords($pwd, $pwd2);

      if(empty($this->errorArray)) {
        // Insert into DB
        return $this->insertUserDetails($un, $fn, $ln, $em, $pwd);
      } else {
        return false;
      }
    }

    private function insertUserDetails($un, $fn, $ln, $em, $pwd) {
      $encryptedpwd = md5($pwd);
      $profilePic = "assets/images/profile-pic/head_emerald.png";
      $date = date("Y-m-d");

      $result = mysqli_query($this->con, "INSERT INTO user VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedpwd', '$date', '$profilePic')");

      return $result;
    }

    public function getError($error) {
      if(!in_array($error, $this->errorArray)) {
        $error = "";
      }
      return "<span class='errorMessage'>$error</span>";
    }

    private function validateUsername($un) {
      if(strlen($un)<3 || strlen($un)>25) {
        array_push($this->errorArray, Constants::$usernameCharacters);
        return;
      }

      $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM user WHERE username='$un'");
      if(mysqli_num_rows($checkUsernameQuery)!=0) {
        array_push($this->errorArray, Constants::$usernameTaken);
        return;
      }
    }
    
    private function validateFirstName($fn) {
      if(strlen($fn)<2 || strlen($fn)>25) {
        array_push($this->errorArray, Constants::$firstNameCharacters);
        return;
      }
    }
    
    private function validateLastName($ln) {
      if(strlen($ln)<3 || strlen($ln)>25) {
        array_push($this->errorArray, Constants::$lastNameCharacters);
        return;
      }
    }
    
    private function validateEmails($em, $em2) {
      if($em != $em2) {
        array_push($this->errorArray, Constants::$emailsDoNotMatch);
        return;
      }

      if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        array_push($this->errorArray, Constants::$emailInvalid);
        return;
      }

      $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM user WHERE email='$em'");
      if(mysqli_num_rows($checkEmailQuery)!=0) {
        array_push($this->errorArray, Constants::$emailTaken);
        return;
      }
    }
    
    private function validatePasswords($pwd, $pwd2) {
      if($pwd != $pwd2) {
        array_push($this->errorArray, Constants::$passwordsDoNotMatch);
        return;
      }

      if(preg_match('/[^A-Za-z0-9]/', $pwd)) {
        array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
        return;
      }

      if(strlen($pwd)<5 || strlen($pwd)>30) {
        array_push($this->errorArray, Constants::$passwordCharacters);
        return;
      }
    }
  }
?>