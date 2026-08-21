<?php
require_once "auth.inc.php";
require_role('recruiter');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../recruiter/dashboard.php");
    die();
}

$applicationID = $_POST['applicationID'];
$status = $_POST['status'];
$jobID = $_POST['jobID'];

try {
    require_once "dbh.inc.php";

    //UPDATE status
    $updateQuery = "UPDATE applications SET status = :status WHERE id = :applicationID";

    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(":applicationID", $applicationID);
    $stmt->bindParam(":status", $status);

    if ($stmt ->execute()) {
        header("Location: ../recruiter/applications.php?jobID=" . $jobID . "&success=status_updated");
    } else {
        header("Location: ../recruiter/applications.php?jobID=" . $jobID . "&error=database_error");
    }

    die();
} catch (PDOException $e) {
    error_log("status update failed: " . $e->getMessage());
    header("Location: ../recruiter/applications.php?error=database_error");
    die();
}


?>
