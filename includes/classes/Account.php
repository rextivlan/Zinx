<?php
  class Account {

    private $errorArray;

    public function __construct() {
      $this->errorArray = array();
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
        return true;
      } else {
        return false;
      }
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

      // TODO: Check if username exists
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

      // TODO: Check that email hasn't been used already
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