<?php
function getProfilePic($conn, $email) {
    $sql = "SELECT profile_pic FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['profile_pic'];
    } else {
        return '../Images/user.png'; // Default image
    }
}
?>
