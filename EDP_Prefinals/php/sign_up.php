<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<title>Sign up</title>

<style>
  body {
    height: auto;
    margin: 0;
    box-sizing: border-box;
    background: radial-gradient(circle, #1b2838, #171a21);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: sans-serif;    
    color: white;
    user-select: none;
  }

  #container {
    margin: 150px 0 70px;
    width: 1000px;
    background-color: #1b2838;
    border-radius: 7px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    box-sizing: border-box;
  }

  #header {
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 40px;
    font-weight: bold;
    padding-top: 20px;
  }

  #body {
    width: 100%;
    padding: 20px 50px 50px 50px;
    box-sizing: border-box;
    display: flex;
    justify-content: center;
  }

  form {
    width: 60%;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
  }

  form label:not(.checkbox-wrap) {
    margin-bottom: 8px;
    font-size: 18px;
  }

  form input[type="text"]{
    height: 2.6rem;
    border-radius: 6px;
    border: none;
    padding-left: 15px;
    font-size: 1rem;
    margin-bottom: 25px;
    outline: none;
    background: rgba(6,10,14,0.6);
    color: #fff;
    box-sizing: border-box;
  }

  form input[type="text"]:focus {
    outline: 2px solid #66c0f4;
    background-color: #0e141b;
    box-sizing: border-box;
  }
  
  .email-wrapper
  {
    position: relative;
    margin-bottom: 25px;
    box-sizing: border-box;
    height: 45px;
  }

  #gender
  {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    
    height: 2.6rem;
    border-radius: 6px;
    border: none;
    padding: 0 15px 0 15px;
    font-size: 1rem;
    margin-bottom: 25px;
    box-sizing: border-box;
    outline: none;
    background: rgba(6,10,14,0.6);
    color: #fff;
  }

  .email-wrapper input {
    border: none;
    width: 100%;
    height: 2.6rem;
    border-radius: 6px;
    padding-left: 15px;
    padding-right: 40px;
    font-size: 1rem;
    outline: none;
    background: rgba(6,10,14,0.6);
    color: #fff;
    box-sizing: border-box;
  }

  .email-wrapper input:focus {
    outline: 2px solid #66c0f4;
    background-color: #0e141b;
    box-sizing: border-box;
  }

  #email-notification
  {
    color: tomato;
    line-height: 0.1;
    font-size: 13px;
    display: none;
  }

  .password-wrapper {
    position: relative;
    margin-bottom: 25px;
    box-sizing: border-box;
    height: 45px;
  }

  .password-wrapper input {
    border: none;
    width: 100%;
    height: 2.6rem;
    border-radius: 6px;
    padding-left: 15px;
    padding-right: 40px;
    font-size: 1rem;
    outline: none;
    background: rgba(6,10,14,0.6);
    color: #fff;
    box-sizing: border-box;
  }

  .password-wrapper input:focus {
    outline: 2px solid #66c0f4;
    background-color: #0e141b;
    box-sizing: border-box;
  }

  .password-wrapper i {
    box-sizing: border-box;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #aaa;
  }

  .checkbox-wrap {
    display: inline-flex;         
    align-items: center;
    gap: 10px;                 
    font-size: 15px;
    cursor: pointer;              
    user-select: none;
    margin-bottom: 20px;
  }

  .checkbox-wrap input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin: 0;                    
    flex-shrink: 0;
    accent-color: #66c0f4;        
    vertical-align: middle;
  }

  form button {
    width: 180px;
    height: 3rem;
    align-self: flex-end;
    background-color: limegreen;
    border: none;
    border-radius: 7px;
    font-size: 16px;
    color: white;
    cursor: pointer;
    margin-top: 10px;
  }

  form button:hover {
    background-color: #3db83d;
  }

  .login-link {
    margin-top: 50px;
    font-size: 15px;
    text-align: right;
    align-self: center;
  }

  .login-link a {
    color: #66c0f4;
    text-decoration: none;
  }

  .login-link a:hover {
    color: white;
  }

  .fields.empty
  {
    outline: 1px solid tomato;
    border: 2px solid tomato;
  }

  .pw-notification
  {
    color: tomato;
    line-height: 0.1;
    font-size: 13px;
    display: none;
  }
</style>
</head>

<body>
<?php
  require_once "db_functions.php";

  $pdo = connect();

  $fullname = $_POST["fullname"] ?? "";
  $city     = $_POST["city"] ?? "";
  $gender   = $_POST["gender"] ?? "";
  $password = $_POST["password"] ?? "";
  $email    = $_POST["email"] ?? "";

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!check_email($pdo, $email)) {
      try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        insert_input($pdo, $fullname, $city, $gender, $hashed_password, $email);

        echo "<script>toastr.success('Account successfully created!', 'Success');</script>";
      } catch (PDOException $e) {
        echo "<script>toastr.error('Failed to create account: " . $e->getMessage() . "', 'Error');</script>";
      }
    } else {
      echo "<script>toastr.error('Email is already in use.', 'Error');</script>";
    }
  }
?>

<div id="container">
  <div id="header"><p>Sign up now</p></div>

  <div id="body">
    <form method="POST" action="#">

      <label for="fullname">Full Name</label>
      <input type="text" class="fields" id="fullname" name="fullname" placeholder="Enter your full name" required>

      <!-- CITY FIELD (New) -->
      <label for="city">City</label>
      <input type="text" class="fields" id="city" name="city" placeholder="Enter your city" required>

      <!-- GENDER FIELD (New) -->
      <label for="gender">Gender</label>
      <select id="gender" name="gender" class="fields" required>
        <option value="">Select gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Prefer not to say">Prefer not to say</option>
      </select>

      <label for="email">Email</label>
      <div class="email-wrapper">
        <input type="email" class="fields" id="email" name="email" placeholder="Enter email address" required>
        <p id="email-notification">Must contain e.g @gmail</p>
      </div>

      <label for="password">Password</label>
      <div class="password-wrapper">
        <input type="password" class="fields" id="password" name="password" placeholder="Enter password" required>
        <i class="fa-solid fa-eye icon"></i>
        <p class="pw-notification">Password do not match</p>
      </div>

      <label for="confirm">Confirm Password</label>
      <div class="password-wrapper">
        <input type="password" class="fields" id="confirm" placeholder="Re-enter password" required>
        <i class="fa-solid fa-eye icon"></i>
        <p class="pw-notification">Password do not match</p>
      </div>

      <label class="checkbox-wrap">
        <input type="checkbox" class="fields" id="terms" />
        <span>I agree to the terms &amp; conditions</span>
      </label>

      <button type="submit" id="submit-btn" name="submit-btn">Create Account</button>

      <p class="login-link">Already have an account? <a href="http://localhost/Projects/EDP_Prefinals/php/">Log in</a></p>

    </form>
  </div>
</div>

<script src="http://localhost/Projects/EDP_Prefinals/js/sign_up.js"></script>

</body>
</html>