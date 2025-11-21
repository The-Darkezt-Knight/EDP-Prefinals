<?php
session_start();
require_once 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
    
    // Check if username already exists
    if (empty($errors)) {
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        
        if ($stmt->rowCount() > 0) {
            $errors[] = "Username already exists";
        }
    }
    
    // Check if email already exists
    if (empty($errors)) {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        if ($stmt->rowCount() > 0) {
            $errors[] = "Email already exists";
        }
    }
    

    if (empty($errors)) {
        // for password hashing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user
        $sql = "INSERT INTO users (full_name, email, username, password) VALUES (:full_name, :email, :username, :password)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([':full_name' => $name, ':email' => $email, ':username' => $username, ':password' => $hashed_password])) {
            $_SESSION['success'] = "Registration successful! You can now login.";
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
    
    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_name'] = $name;
        $_SESSION['old_email'] = $email;
        $_SESSION['old_username'] = $username;
        header("Location: signup.php");
        exit();
    }
}
?>