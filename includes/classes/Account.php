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
    }

    private function validateUsername($un) {
      if(strlen($un)<3 || strlen($un)>25) {
        array_push($this->errorArray, "Your username must be between 3 and 25 characters");
        return;
      }

      // TODO: Check if username exists
    }
    
    private function validateFirstName($fn) {
      if(strlen($fn)<2 || strlen($fn)>25) {
        array_push($this->errorArray, "Your username must be between 2 and 25 characters");
        return;
      }
    }
    
    private function validateLastName($ln) {
      if(strlen($ln)<3 || strlen($ln)>25) {
        array_push($this->errorArray, "Your username must be between 2 and 25 characters");
        return;
      }
    }
    
    private function validateEmails($em, $em2) {
      if($em != $em2) {
        array_push($this->errorArray, "Your emails don't match");
        return;
      }

      if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        array_push($this->errorArray, "Email is invalid");
        return;
      }

      // TODO: Check that email hasn't been used already
    }
    
    private function validatePasswords($pwd, $pwd2) {
      if($pwd != $pwd2) {
        array_push($this->errorArray, "Your passwords don't match");
        return;
      }

      if(preg_match('/[^A-Za-z0-9]', $pwd)) {
        array_push($this->errorArray, "Your password can only contain numbers and letters");
        return;
      }

      if(strlen($pwd)<5 || strlen($un)>30) {
        array_push($this->errorArray, "Your password must be between 5 and 30 characters");
        return;
      }
    }
  }
?>