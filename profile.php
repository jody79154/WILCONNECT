<?php
session_start();
require_once "../includes/auth.inc.php";
require_role('student');
require_once "../includes/session_timeout.inc.php";


// Get the userID from the session
$userID = $_SESSION['userID'];

try {
    // Connect to database
    require_once "../includes/dbh.inc.php";

    //  Get studens details
    $studentQuery = "SELECT fullName, email, role, profilePic
                     FROM users
                     WHERE id = :userID";

    $stmt = $pdo->prepare($studentQuery);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();

    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // checks If student doesn't exist
    if (!$student) {
        header("Location: ../login.php");
        die();
    }


    // 5. Get student's applications
    $applicationsQuery = "SELECT applications.*, 
                                 job_postings.jobTitle,
                                 job_postings.company
                          FROM applications
                          JOIN job_postings 
                          ON applications.jobID = job_postings.id
                          WHERE applications.studentID = :userID";

    $stmt = $pdo->prepare($applicationsQuery);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();

    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // 6. Get lecturer notes
    $notesQuery = "SELECT lecturer_notes.note,
                          users.fullName
                   FROM lecturer_notes
                   JOIN users 
                   ON lecturer_notes.lecturerID = users.id
                   WHERE lecturer_notes.studentID = :userID";

    $stmt = $pdo->prepare($notesQuery);
    $stmt->bindParam(":userID", $userID);
    $stmt->execute();

    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile</title>

    <link rel="stylesheet" href="#">
</head>

<body>

    <!-- Student Profile-->

    <h1>My Profile</h1>

    <?php if (!empty($student['profilePic'])): ?>

        <img src="../<?php echo $student['profilePic']; ?>"
             alt="Profile Picture"
             width="150">

    <?php endif; ?>


    <h2>
        <?php echo $student['fullName']; ?>
    </h2>

    <p>
        <strong>Email:</strong>
        <?php echo $student['email']; ?>
    </p>

    <p>
        <strong>Role:</strong>
        <?php echo $student['role']; ?>
    </p>


    <!-- Applications -->

    <h2>My Applications</h2>

    <table border="1">

        <tr>
            <th>Job Title</th>
            <th>Company</th>
            <th>Date Applied</th>
            <th>Status</th>
        </tr>

        <?php if (empty($applications)): ?>

            <tr>
                <td colspan="4">
                    No Applications Yet
                </td>
            </tr>

        <?php else: ?>

            <?php foreach ($applications as $application): ?>

                <tr>

                    <td>
                        <?php echo $application['jobTitle']; ?>
                    </td>

                    <td>
                        <?php echo $application['company']; ?>
                    </td>

                    <td>
                        <?php echo $application['appliedAt']; ?>
                    </td>

                    <td>
                        <?php echo $application['status']; ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>

    </table>


    <!-- Lecture Notes -->

    <h2>Lecturer Notes</h2>

    <?php if (empty($notes)): ?>

        <p>No lecturer notes yet.</p>

    <?php else: ?>

        <?php foreach ($notes as $note): ?>

            <div>

                <p>
                    <strong>Lecturer:</strong>
                    <?php echo $note['fullName']; ?>
                </p>

                <p>
                    <strong>Note:</strong>
                    <?php echo $note['note']; ?>
                </p>

            </div>

            <hr>

        <?php endforeach; ?>

    <?php endif; ?>

</body>
</html>
