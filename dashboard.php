<?php
require_once "../includes/auth.inc.php";
require_once "../includes/session_timeout.inc.php";
require_role('student');

// get the data
$userID = $_SESSION['userID'];
$username = $_SESSION['fullName'];

// Still to do connect and get pfp

//Fetch available postings
try {
    require_once "../includes/dbh.inc.php";
    $jobsQuery = "SELECT * FROM job_postings WHERE status = 'open'"; 
    $jobsStmt = $pdo->prepare($jobsQuery);
    $jobsStmt->execute();
    $jobs = $jobsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $jobs = [];
    $jobsError = "Error loading jobs.";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="#">
</head>

<body>
    <h2>Job Postings</h2>

    <div id="job-cards">
        <?php if (isset($jobsError)): ?>
            <p><?php echo $jobsError; ?></p>
        <?php elseif (empty($jobs)): ?>
            <p>No Jobs Yet</p>
        <?php else: ?>
            <?php foreach ($jobs as $job): ?>
                <div>
                    <h3><?php echo $job['jobTitle']; ?></h3>
                    <p><?php echo $job['company']; ?></p>
                    <p><?php echo $job['workSetup']; ?></p>
                    <p><?php echo $job['deadline']; ?></p>
                    <img src="../assets/<?php echo strtolower($job['company']); ?>.png" alt="Company Logo">
                    <a href="job_detail.php?id=<?php echo $job['id']; ?>">View Details</a>
                    <?php if ($job['workSetup'] == 'On-Site' || $job['workSetup'] == 'Hybrid'): ?>
                      <p><?php echo $job['location']; ?></p>
                    <?php endif; ?> 
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>


