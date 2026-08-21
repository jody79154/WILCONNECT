<?php
require_once "auth.inc.php";
require_role('student');

//Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../recruiter/dashboard.php");
    die();
}

$jobID = trim($_POST['jobID']);
$userID = $_SESSION['userID'];

//Handle file upload
$fileLocation = null;

if (isset($_FILES['projectFile']) && $_FILES['projectFile']['error'] === UPLOAD_ERR_OK){
    $file = $_FILES['projectFile'];

    //validate file is a correct format
    $allowedTypes = ['application/zip', 'application/rar', 'application/pdf'];
    $fileType = mime_content_type($file['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        header("Location: ../student/dashboard.php?error=invalid_file_type");
        die();
    }

    // Validate file size (max 5mb)
    if ($file['size'] > 5 * 1024 * 1024) {
        header("Location:../student/dashboard.php?error=file_too_large");
        die();
    }

    // create uplaods directory if it doesnt exist
    $uploadDir = '../uploads/projects/';
    if(!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    //unique file name
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('project_', true). '.' . $fileExtension;
    $uploadPath = $uploadDir . $fileName;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $fileLocation = 'uploads/projects/' . $fileName;
    } else {
        header("Location: ../student/dashboard.php?error=upload_failed");
        die();
    }
}



try {
    //connect to db
    require_once "dbh.inc.php";

    //Insert post into db
    $query = "INSERT INTO applications (studentID, jobID, projectFile)
              VALUES (:studentID, :jobID, :projectFile)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":studentID", $userID);
    $stmt->bindParam(":jobID", $jobID);
    $stmt->bindParam(":projectFile", $fileLocation);
    
    

    if ($stmt ->execute()) {
        header("Location: ../student/dashboard.php?success=application_submitted");
    } else {
        header("Location: ../student/dashboard.php?error=database_error");
    }

    die();
    
    
} catch (PDOException $e) {
    error_log("Job creation failed: " . $e->getMessage());
    header("Location: ../student/dashboard.php?error=database_error");
    die();
}




?>

