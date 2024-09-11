<?php 

include ("ini_db.php");

$query = "SELECT * FROM users ORDER BY `users`.`lastModified` DESC";
$query_run = mysqli_query($conn, $query);

$result_array = [];

if(mysqli_num_rows($query_run) > 0) {
    foreach($query_run as $row) {
        array_push($result_array, $row);
    }
    
    header('Content-type: application/json');
    echo json_encode($result_array);
} else {
    header('Content-type: application/json');
    echo json_encode(['message' => 'No Record Found']);
}
?>
