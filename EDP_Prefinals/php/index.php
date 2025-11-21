<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>
<style>
    body
    {
        height: 100vh;
        width: 100%;
        padding: 0;
        margin: 0;
        background: radial-gradient(circle, #1b2838, #171a21 );
        user-select: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-family: sans-serif;
    }

    #container
    {
        width: 1000px;
        height: auto;
        box-sizing: border-box;
        background-color: #1b2838;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    #header
    {
        width: 100%;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 40px;
        padding: 20px 0 0 0;
        font-weight: bold;
    }

    #body
    {
        width: 100%;
        height: 430px;
        box-sizing: border-box;
        display: flex;
    }

    #body form
    {
        width: 55%;
        height: 100%;
        display: flex;
        justify-content: center;
        flex-direction: column;
        box-sizing: border-box;
        padding: 10px 50px 40px 80px;
    }

    form label
    {
        font-size: 20px;
        font-weight: 400;
        margin: 0 0 15px 0;
    }

    form label:not(:first-child)
    {
        margin-top: 30px;
    }

    form input
    {
        height: 2.5rem;
        font-size: 1.1rem;
        padding: 0 0 0 20px;
        border: none;
        border-radius: 7px;
        outline: none;
        color: white;
        background-color: #0e141b;
    }

    form input:focus {
        border-color: #66c0f4;
        background-color: #0e141b;
        box-shadow: 0 0 5px rgba(102,192,244,0.5);
    }


    form .options
    {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .options a {
        color: #66c0f4;
        text-decoration: none;
        transition: 0.2s;
    }

    .options a:hover {
        color: white;
    }

    .options label {
    font-size: 14px;
    font-weight: normal;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
    }

    form button {
        width: 150px;
        margin-top: 25px;
        height: 3rem;
        align-self: flex-end;
        background-color: limegreen;
        border: none;
        border-radius: 7px;
        font-size: 16px;
        color: white;
        cursor: pointer;
        transition: 0.2s;
    }
    form button:hover {
        background-color: #46a249;
    }

    #qr
    {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    #qr img
    {
        width: 60%;
        background-color: white;
        border-radius: 7px;
        transition: 0.25s;
    }

    #qr img:hover {
        transform: scale(1.02);
    }


    #sign-up-link
    {
         margin: 0 0 30px 0;
    }

    #sign-up-link a
    {
        color: #66c0f4;
        text-decoration: none;
        transition: 0.25s;
    }
    #sign-up-link a:hover{
        color: white;
    }
</style>
<body>
    <div id="container">
        <div id="header"><p>Login now</p></div>
        <div id="body">
            <form action="login.php" method="POST">
                <label for="email">email</label>
                <input type="text" placeholder="Enter email" name="email">

                <label for="password">Password</label>
                <input type="password" placeholder="Enter password" name ="password">

                <div class="options">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="https://www.youtube.com/watch?v=DN0G0Lbj6os&list=RDDN0G0Lbj6os&start_radio=1">Forgot password?</a>
                </div>

                <button>Login now</button>
            </form>
            <div id="qr">
                <p>Or log in using</p>
                <img src="http://localhost/Projects/EDP_Prefinals/resources/images/Qr-code.svg" alt="this is a qr">
            </div>
        </div>
        <label id="sign-up-link" for="signup">Don't have an account? <a href="http://localhost/Projects/EDP_Prefinals/php/sign_up.php">Sign up</a></label>
    </div>
<script>
$(document).ready(function() {
    <?php if (isset($_SESSION['login_status'])): 
        $status = $_SESSION['login_status']; 
        unset($_SESSION['login_status']);
    ?>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        toastr.<?php echo $status['type']; ?>("<?php echo $status['message']; ?>");
    <?php endif; ?>
});
</script>


    
</body>
</html>