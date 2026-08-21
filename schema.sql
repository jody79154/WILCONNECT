CREATE DATABASE wil_connect;

USE wil_connect;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'recruiter', 'lecturer') NOT NULL,
    company VARCHAR(150) DEFAULT NULL,
    profilePic VARCHAR(255) DEFAULT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verificationCode VARCHAR(6) DEFAULT NULL,
    isVerified TINYINT(1) DEFAULT 0
);

CREATE TABLE job_postings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recruiterID INT NOT NULL,
    company VARCHAR(150) NOT NULL,
    jobTitle VARCHAR(150) NOT NULL,
    jobType ENUM('Full-Time', 'Part-Time', 'Internship') NOT NULL,
    workSetup ENUM('Remote', 'On-Site', 'Hybrid') NOT NULL,
    location VARCHAR(150) DEFAULT NULL,
    jobDescription TEXT NOT NULL,
    requirements TEXT NOT NULL,
    deadline DATE NOT NULL,
    status ENUM('open', 'closed') DEFAULT 'open',
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (recruiterID)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    studentID INT NOT NULL,
    jobID INT NOT NULL,
    projectFile VARCHAR(255) DEFAULT NULL,
    status ENUM('pending', 'accepted', 'denied') DEFAULT 'pending',
    appliedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (studentID)
        REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (jobID)
        REFERENCES job_postings(id)
        ON DELETE CASCADE,

    UNIQUE(studentID, jobID)
);

CREATE TABLE lecturer_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lecturerID INT NOT NULL,
    studentID INT NOT NULL,
    note TEXT NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lecturerID) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (studentID) REFERENCES users(id) ON DELETE CASCADE
);
