<?php
    require_once "db_connect.php";


    //function to connect to the database
    function connect()
    {   
        global $dsn, $user, $pw, $options;
        try
        {
            $pdo = new PDO($dsn, $user, $pw, $options);
            return $pdo;
        }catch(PDOException $e)
        {
            die("Unable to connect to the database" .$e->getMessage());
        }
    }

    //function to check for possible email duplication
    function check_email(PDO $pdo, string $email)
    {
        $sql = "SELECT COUNT(*) FROM account_table WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email"=>$email]);
        return $stmt->fetchColumn() > 0;
    }


    //function to insert values to the database
    function insert_input(PDO $pdo, string $fullname, string $username, string $hashed_password, string $email)
    {
        $sql = "INSERT INTO account_table(fullname, username, password, email)
                VALUES(:fullname, :username, :password, :email)";

        $stmt = $pdo->prepare($sql);

        try
        {
            $stmt ->execute(
            [
                ":fullname" =>$fullname,
                ":username" =>$username,
                ":password" =>$hashed_password,
                ":email" => $email
            ]);
        }catch(PDOException $e)
        {
            die("Failed to sign up. Please try again later" .$e->getMessage());
        }
    }
?>


