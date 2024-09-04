<?php
class User{

    protected $conn;

    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $is_admin;
    protected $is_active;
    protected $dateModified;

    public function __construct($db) {
        $this->conn = $db;
        // echo "connection created";
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
            // echo "Connection closed.";
        }
    }

    public function getName(){
        return $this->username;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getRole(){
        return $this->is_admin;
    }
    public function getStatus(){
        return $this->is_active;
    }
    public function getDate(){
        return $this->dateModified;
    }
    function sanitizeData($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }
    // Create a new user
    public function create($name, $email, $pass) {
        
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }else{
            $stmt->close();
            return false;
        }
    }

    public function signin($email,$pass){
        // echo "<script>alert('".$email."')</script>";
        $stmt = $this->conn->prepare("SELECT password, username,role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($hashed_password, $name, $role);
            $stmt->fetch();
            
            $this->username = $name;
            // Verify the password
            if (password_verify($pass, $hashed_password)) {
                // Set session variables
                // echo $email;
                $_SESSION['role']=$role;
                if($role=="admin"){
                    $_SESSION['name']=$this->username;
                    $_SESSION['email']=$email;
                    header("Location: ../view/adminHome.php");
                    exit();
                }elseif($role=="user"){
                    $_SESSION['name']=$this->username;
                    $_SESSION['email']=$email;
                    
                    header("Location: ../view/Home.php");
                    exit();
                }
                // echo "test 2 " . $_SESSION['email']." ";
                // exit();
                $stmt->close();
                return true;
                
            } else {
                $passErr = "Invalid password";
                header("Location: ../view/signinForm.php?error=Invalid+password");
                $stmt->close();
                return false;
            }
        } else {
            $emailErr = "No account found with this email";
            header("Location: ../view/signinForm.php?error=No+account+found+with+this+email");
            $stmt->close();
            return false;
        }

        
    }

    // Update user information
    public function update($id, $username, $email, $role, $status) {
        // SQL query with placeholders
        $query = "UPDATE users SET username = ?, email = ?, role = ?, userStatus = ?, lastModified = NOW() WHERE u_id = ?";
    
        // Prepare the statement
        $stmt = $this->conn->prepare($query);
    
        if ($stmt === false) {
            die("Failed to prepare the statement: " . $this->conn->error);
        }
    
        // Sanitize input
        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));
        $role = htmlspecialchars(strip_tags($role));
        $status = htmlspecialchars(strip_tags($status));
    
        // Bind data
        $stmt->bind_param('sssss', $username, $email, $role, $status, $id);

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    

    public function getUserData($id){
        $sql = "SELECT username, email,password,userStatus, role, lastModified FROM users WHERE u_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($username, $email, $hashedPassword, $status, $role,$lastModified);
            $stmt->fetch();
            $this->username = $username;
            $this->email = $email;
            $this->password = $hashedPassword;
            $this->is_admin = $role;
            $this->is_active = $status;
            $this->dateModified = $lastModified;

        } else {
            die("User not found.");
        }
    }

    // Delete a user
    public function deleteFromId($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE u_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {    
            $stmt->close();  
            return true;      
        } else {
            $stmt->close();
            return false;
        }
    }

    public function viewUsersData($limit, $offset){
        $stmt = $this->conn->prepare("SELECT profile_pic, u_id, username, email, role FROM users LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            
            echo "<td><img src=". str_replace(' ', '%20', $row["profile_pic"]) ." alt='Profile' class='rounded-circle' style='width: 40px; height: 40px;'></td>";
            echo "<td>" . $row["u_id"] . "</td>";
            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
            echo "</tr>";
        }
        $stmt->close();
    }
    
    public function countUsers() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'];
    }
    
    public function viewAllUsers($limit, $offset){
        $stmt = $this->conn->prepare("SELECT u_id, username, email FROM users WHERE role = 'user' LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["u_id"] . "</td>";
            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>
                <a href='../view/editUserAdmin.php?id=" . $row["u_id"] . "' class='btn btn-warning btn-sm'>Edit</a>
                <form method='POST' action='../Controller/deleteUser.php' style='display:inline;'>
                    <input type='hidden' name='u_id' value='" . $row["u_id"] . "'>
                    <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                </form>
            </td>";
            echo "</tr>";
        }
        $stmt->close();
    }
}
    

?>