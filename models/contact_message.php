<?php

class Message{

    protected $con;

    protected $id;
    protected $email;
    protected $name;
    protected $message;
    protected $timestamp;

    public function __construct($con){
        $this->con = $con;
        if ($this->con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
    }
    public function __destruct() {
        if ($this->con) {
            $this->con->close();
        }
    }
    public function getName(){
        return $this->name;
    }
    public function getMsg(){
        return $this->message;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getTime(){
        return $this->timestamp;
    }
    
    function testData($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }

    public function addMessage($name, $email, $message) {
        $this->email = $email;
        $this->name = $name;
        $this->message = $message;
        $query = "INSERT INTO contact_messages (email, username, message) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($query);
        if ($stmt === false) {
            die("Error preparing statement: " . $this->con->error);
        }
    
        $stmt->bind_param('sss', $this->email, $this->name, $this->message);
    
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    public function getMsgData($id){
        $sql = "SELECT username, email,message, submitted_at FROM contact_messages WHERE m_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($username, $email, $message, $submitted_at);
            $stmt->fetch();

            $this->name = $username;
            $this->email = $email;
            $this->message = $message;
            $this->timestamp = $submitted_at;

        } else {
            die("User not found.");
        }
    }
    public function showAllMessages(){
        $sql = "SELECT m_id, username, email, message FROM contact_messages";
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["m_id"] . "</td>";
                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                echo "<td>
                    <a href='../view/showMessage.php?id=" . $row["m_id"] . "' class='btn btn-warning btn-sm'>Show</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>No users found.</td></tr>";
        }
    }
    
}

?>