<?php
session_start();
require_once "../includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = trim(($_POST["email"]));
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        die("Please enter email and password");
    }

    //Find user by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //Verify user password
    if ($user && password_verify($password, $user["password"])) {
        if($user["isVerified"] != 1) {
            die("Please verify your email before logging in.");
        }

        
        //store session information
        $_SESSION["userID"] = $user["id"];
        $_SESSION["fullName"] = $user["fullName"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["company"] = $user["company"];
    } else {
    die("Invalid email or password.");
    }

    //Redirect based on role
    switch ($user["role"]) {

        case "student":
            header("Location: ../student/dashboard.php");
            break;
        case "recruiter":
            header("Location: ../recruiter/dashboard.php");
            break;
        case "lecturer":
            header("Location: ../lecturer/dashboard.php");
            break;
        default:
            header("Location: ../login.php");
            break;
    }

    exit();

    
} 

?>
