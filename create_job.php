<?php

    require_once "../includes/auth.inc.php";
require_once "../includes/session_timeout.inc.php";
    require_role('recruiter');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RECRUITER DASHBOARD</title>
    <link rel="stylesheet" href="#">
</head>

<body>
    <h2>Open Job Position Creation</h2>

    <form action="../includes/application_handler.inc.php" method="post">
        <label for="jobTitle"> Job Title </label>
        <input type="text" id="jobTitle" name="jobTitle" placeholder="e.g. Help Desk Intern" required>
        <br><br>
        
        <label for="jobType">Job Type:</label><br>
        <select name="jobType" id="jobType" required>
            <option value="" selected disabled>Select a Job Type</option>
            <option value="Full-Time"> Full-Time </option>
            <option value="Part-Time"> Part-Time </option>
            <option value="Internship"> Internship </option>
        </select>
        
        <br><br>
        
        <label for="workSetup">Work Setup:</label><br>
        <select name="workSetup" id="workSetup" required>
            <option value="" selected disabled>Select a Work Setup</option>
            <option value="Remote">Remote</option>
            <option value="On-Site">On-Site</option>
            <option value="Hybrid">Hybrid</option>
        </select>

        <br><br>

        <div id="locationField">
            <label for="location">Location:</label><br>
            <input type="text" name="location" id="location" placeholder="e.g. Westville, Durban">
            <br><br>
        </div>

        <label for="jobDescription">Job Description:</label><br>
        <textarea name="jobDescription" placeholder="Description..." rows="6" cols="60" required></textarea>
        <br><br>
                
        <label for="requirements">Requirements:</label><br>
        <textarea name="requirements" placeholder="Requirements..." rows="6" cols="60" required></textarea>
        <br><br>
        
        <label for="deadline">Choose a date:</label>
        <input type="date" id="deadline" name="deadline" required/>

        <input type="hidden" name="company" id="company" value = "<?php echo $_SESSION['company'];?>">
        <input type="hidden" name="recruiterID" id="recruiterID" value = "<?php echo $_SESSION['userID'];?>">

        <input type="submit" value="Create">
    </form>

    <script>
        //grabbing the html elements
        const workSetup = document.getElementById('workSetup');
        const locationField = document.getElementById('locationField');

        //when page first loads location is hidden by default
        locationField.style.display = 'none';

        workSetup.addEventListener('change', function() {
            if (this.value === 'On-Site' || this.value === 'Hybrid') {
                locationField.style.display = 'block';
            } else {
                locationField.style.display = 'none';
            }
        });
    </script>
</body>


