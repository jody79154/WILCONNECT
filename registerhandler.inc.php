<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();

require_once "dbh.inc.php";
require"../PHPMailer/Exception.php";
require"../PHPMailer/PHPMailer.php";
require"../PHPMailer/SMTP.php";
require_once "config.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = trim($_POST["fullName"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];
    $company = null;
    $verificationCode = random_int(100000, 999999); //better than rand() its more secure

    //Company only applies to recruiters
    if ($role === "recruiter" && isset($_POST["company"])) {
        $company = trim($_POST["company"]);
    }

    //validation
    if (empty($fullName) || empty($email) || empty($password) || empty($role)) {
        die("Please fill in all required fields.");
    }

    //Check if email already exists or not
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        die("Email already exists.");
    }

    //Hash Password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //Insert user
    $sql = "INSERT INTO users (fullName, email, password, role, company, verificationCode, isVerified)
    VALUES (?, ?, ?, ?, ?, ?, 0)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $fullName,
        $email,
        $hashedPassword,
        $role,
        $company,
        $verificationCode
    ]);

    $_SESSION['email'] = $email;

    //send to email
    $mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = MAIL_USERNAME;
    $mail->Password = MAIL_APP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom(MAIL_USERNAME, 'Campus Recruit');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Verify your account';
    $mail->Body = "Your verification code is: $verificationCode";

    $mail->send();
} catch (Exception $e) {
    die("Email could not be sent. Error: {$mail->ErrorInfo}");
}

    //Redirect to login page
    header("Location: ../verify.php");
    die();

    
}



?>
