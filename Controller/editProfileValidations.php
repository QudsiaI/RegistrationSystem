<?php

include "../Controller/checkSession.php";
require_once '../models/User.php'; 
include "../Controller/ini_db.php";  

// Check if connection was successful
if (!isset($conn)) {
    die("Database connection failed.");
}

// Create User object
$user = new User($conn);

$nameErr = $emailErr = $passErr = $picErr = "";
$uploadOk = 1;
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;
    
    // Username validation
    if (empty($_POST['Username'])) {
        $nameErr = "Name is Required";
        $valid = false;
    } else {
        $name = $user->sanitizeData($_POST['Username']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and spaces allowed";
            $valid = false;
        }
    }
    
    // Email validation
    if (empty($_POST['Email'])) {
        $emailErr = "Email is Required";
        $valid = false;
    } else {
        $email = $user->sanitizeData($_POST['Email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $valid = false;
        }
    }
    
    // Password handling
    if (!empty($_POST['Password'])) {
        $pass = $user->sanitizeData($_POST['Password']);
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    }
    
    // Profile picture upload handling
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
        $targetDir = "../Images/"; 
        $fileName = basename($_FILES["profilePic"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Debugging: Print file and target paths
        // echo "Temporary file path: " . $_FILES["profilePic"]["tmp_name"] . "<br>";
        
        // Check if file is an image
        $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
        if ($check === false) {
            $picErr = "File is not an image.";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["profilePic"]["size"] > 5000000) { // 500KB
            $picErr = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $picErr = "Sorry, only JPG, JPEG, & PNG files are allowed.";
            $uploadOk = 0;
        }
        // echo "uploadOk: " . $uploadOk . "<br>";
        
        // Upload file if all checks are passed
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFile)) {
                // Update user's profile picture path in the database
                $profilePicPath = $targetFile; // Store only the file name
                // echo "Target file path: " . $conn->real_escape_string($profilePicPath) . "<br>";
                $sql = "UPDATE users SET profile_pic='" . $conn->real_escape_string($profilePicPath) . "' WHERE email='" . $conn->real_escape_string($_SESSION['email']) . "'";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['profile_pic'] = $profilePicPath;
                } else {
                    $picErr = "Error updating record: " . $conn->error;
                }
            } else {
                $picErr = "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    if ($valid) {
        // Update user information in the database
        if (!empty($pass)) {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, lastModified = NOW() WHERE email = ?");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $_SESSION["email"]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, lastModified = NOW() WHERE email = ?");
            // echo "<script>alert('Your information has been updated.');</script>";
            $stmt->bind_param("sss", $name, $email, $_SESSION["email"]);
        }

        $stmt->execute();
        $stmt->close();

        // Update session variables
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;

    }
} else {
    // Pre-fill form with current user information
    $name = $_SESSION["name"];
    $email = $_SESSION["email"];
    $profilePicPath = "../Images/" . ($_SESSION['profile_pic'] ?? 'user.png');
}
?>
