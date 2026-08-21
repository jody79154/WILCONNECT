<?php
require_once "../includes/auth.inc.php";
require_once "../includes/session_timeout.inc.php";
require_role('recruiter');

$jobID = $_GET['jobID'];


try {
    require_once "../includes/dbh.inc.php";
    $applicationsQuery = "SELECT applications.*, users.fullName as studentName FROM applications
                        JOIN users ON applications.studentID = users.id
                        WHERE applications.jobID = :jobID";

    $stmt = $pdo->prepare($applicationsQuery);
    $stmt->bindParam(":jobID", $jobID);
    $stmt->execute();
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($stmt->rowCount() == 0) {
        header("Location: ../recruiter/dashboard.php");
        die();
    }

}catch (PDOException $e)
{
    die("Query Failed: " . $e->getMessage());
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

<table>
    <tr>
        <th>Student Name</th>
        <th>Project File</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php if (isset($applicationsError)): ?>

    <tr>
        <td colspan="4">
            <?php echo $applicationsError; ?>
        </td>
    </tr>

<?php elseif (empty($applications)): ?>

    <tr>
        <td colspan="4">No Applications Yet</td>
    </tr>

<?php else: ?>

    <?php foreach ($applications as $application): ?>

        <tr>
            <td><?php echo $application['studentName']; ?></td>
            <td><a href="../<?php echo $application['projectFile']; ?>" download>Download Project</a></td>
            <td><?php echo $application['status']; ?></td>
            <td>
                <form action="../includes/status_handler.inc.php" method="post">
                    <input type="hidden" name="applicationID" value="<?php echo $application['id']; ?>">
                    <input type="hidden" name="status" value="accepted">
                    <input type="hidden" name="jobID" value="<?php echo $jobID; ?>">
                    <button type="submit">Accept</button>
                </form>

                <form action="../includes/status_handler.inc.php" method="post">
                    <input type="hidden" name="applicationID" value="<?php echo $application['id']; ?>">
                    <input type="hidden" name="status" value="denied">
                    <input type="hidden" name="jobID" value="<?php echo $jobID; ?>">
                    <button type="submit">Deny</button>
                </form>
            </td>
        </tr>

    <?php endforeach; ?>

<?php endif; ?>

</table>
</body>



