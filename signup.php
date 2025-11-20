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

  .email-wrapper
  {
    position: relative;
    margin-bottom: 25px;
    box-sizing: border-box;
    height: 45px;
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
  <div id="container">
    <div id="header"><p>Sign up now</p></div>

    <div id="body">
      <form action="register_user.php" method="POST">

        <label for="fullname">Full Name</label>
        <input type="text" class="fields" id="fullname" name="name" placeholder="Enter your full name" required>

        <label for="username">Username</label>
        <input type="text" class="fields" id="username" name="username" placeholder="Enter username" required>
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

        <button id="submit-btn">Create Account</button>

        <p class="login-link">Already have an account? <a href="index.php">Log in</a></p>

      </form>
    </div>
  </div>
  <script src="EDP_Prefinals/js/sign_up.js"></script>
  <script>
    /*declaring the variables
    const form = document.querySelector("form");
    const pw_wrappers = document.querySelectorAll(".password-wrapper");
    const submit = document.getElementById("submit-btn");
    const terms = document.getElementById("terms");
    const allFields = document.querySelectorAll(".fields");
    const password = document.getElementById("password");
    const confirm = document.getElementById("confirm");
    const pw_notification = document.querySelectorAll(".pw-notification");
    const email = document.getElementById("email");
    const email_notification = document.getElementById("email-notification");

    //toggling the view-password icon
    pw_wrappers.forEach(wrapper => {
      const icon = wrapper.querySelector(".icon");
      const field = wrapper.querySelector(".fields");

      icon.addEventListener("click", (e) => {
        e.preventDefault();
        field.type = (field.type === "password") ? "text" : "password";
      });
    });

    //validate the email
    email.addEventListener("input", () => {
      if(!email.value.includes("@")) {
        email_notification.style.display = "block";
      }else {
        email_notification.style.display = "none";
      }
    });


    //validating the password
    function validatePasswords() {
      if(password.value === confirm.value || (password.value === "" && confirm.value === "")) {
      confirm.style.outline = "";
      password.style.outline = "";
      pw_notification.forEach(notif => notif.style.display = "none");
      } else {
        confirm.style.outline = "2px solid red";
        password.style.outline = "2px solid red";
        pw_notification.forEach(notif => notif.style.display = "flex");
      }
    }

    password.addEventListener("input", validatePasswords);
    confirm.addEventListener("input", validatePasswords);


    //submitting
    submit.addEventListener("click", (e) => {
      e.preventDefault();

      let firstEmpty = null;

      allFields.forEach(field => { 
        if (field.value.trim() === "") {
          field.classList.add("empty");
          if (!firstEmpty) firstEmpty = field;
        } else {
          field.classList.remove("empty");
        }
      });

      //if at least one of the input is empty
      if (firstEmpty) {
        firstEmpty.focus();
        toastr.error("You must fill all the required fields to proceed", "Validation Error");
        return;
      }

      //if the user hasn't checked the terms and conditions
      if (!terms.checked) {
        toastr.error("You must agree to the terms and conditions.", "Validation Error");
        return;
      }

      //if successful, submit the form
      form.submit();
    });*/
  </script>
</body>

</html>

