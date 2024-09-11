<?php
include '../Controller/checkSession.php';
include '../Controller/ini_db.php';
include_once '../models/user.php';

$name = $email = $pass = "";
$nameErr = isset($_SESSION['nameErr']) ? $_SESSION['nameErr'] : '';
$emailErr = isset($_SESSION['emailErr']) ? $_SESSION['emailErr'] : '';
$passErr = isset($_SESSION['passErr']) ? $_SESSION['passErr'] : '';
unset($_SESSION['nameErr']);
unset($_SESSION['emailErr']);
unset($_SESSION['passErr']);

$user = new User($conn);

$total_users = $user->countUsers();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data - Admin Panel</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/fetch.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="../Styling/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . "/navigation/adminNavBar.php"; ?>
    <div class="sidebar">
        <?php include "navigation/adminSideNav.php"; ?>
    </div>
    <div class="main-content">
        <div class="container mt-5">
            <img src="../Images/addUser.png" alt="Add User" style="width: 30px; height: 30px; cursor: pointer;" data-toggle="modal" data-target="#exampleModal">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addUserForm">
                                <!-- <method="POST" action="../Controller/addUserValidation.php"> -->
                                <div class="mb-3">
                                    <label for="username" class="col-form-label">Username:</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($name); ?>">
                                    <small class="text-danger"><?php echo $nameErr; ?></small>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
                                    <small class="text-danger"><?php echo $emailErr; ?></small>
                                </div>
                                <div class="mb-3">
                                    <label for="Password" class="col-form-label">Password:</label>
                                    <input type="password" class="form-control" name="Password" id="Password">
                                    <small class="text-danger"><?php echo $passErr; ?></small>
                                </div>
                                <input type="hidden" name="fromAdmin" value="true">
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="text-center">Registered Users</h2>
            <!-- <small>
                <form method="GET" action="">
                    <label for="recordsPerPage">Records per page:</label>
                    <select name="recordsPerPage" id="recordsPerPage" onchange="this.form.submit()">
                        <option value="5" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == 5) echo 'selected'; ?>>5</option>
                        <option value="10" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == 10) echo 'selected'; ?>>10</option>
                        <option value="20" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == 20) echo 'selected'; ?>>20</option>
                        <option value="<?php echo htmlspecialchars($total_users); ?>" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == $total_users) echo 'selected'; ?>>All</option>
                    </select>
                </form>
            </small> -->
            <table class="table table-bordered border-dark border-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userData">
                </tbody>
            </table>
        </div>
    </div>

<!-- Modal for Editing User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <div class="mb-3">
                        <label for="name">Username</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailEdit">Email address</label>
                        <input type="email" class="form-control" id="emailEdit" name="emailEdit" required>
                    </div>
                    <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role"  required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="lastModified">Last Modified</label>
                            <input type="text" class="form-control" id="lastModified" name="lastModified" readonly>
                        </div> -->
                    <input type="hidden" id="editUserId" name="editUserId">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

<script>

    // Handle the click event for the Edit button
$('#editUserModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget); // Button that triggered the modal
    var userId = button.data('id'); // Extract info from data-* attributes
    var username = button.data('username');
    var email = button.data('email');
    var role = button.data('role');
    var userStatus = button.data('userStatus');
    // var lastModified = button.data('lastModified');

    var modal = $(this);
    modal.find('#editUserId').val(userId);
    modal.find('#name').val(username);
    modal.find('#emailEdit').val(email);
    modal.find('#role').val(role);
    // modal.find('#status').val(userStatus);
    // modal.find('#lastModified').val(lastModified);
});

// Handle form submission
$('#editUserForm').submit(function (event) {
    event.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    $.ajax({
        type: 'POST',
        url: '../Controller/updateUser.php', // Change to your update endpoint
        data: formData,
        success: function (response) {
           
            var parsed_data = JSON.parse(response);
            console.log(parsed_data.success);
            if (parsed_data.success) {
                alert('User updated successfully.');
                $('#editUserModal').modal('hide');
                getdata(); // Reload the user data
            } else {
                // getdata();
                alert('Failed to update user.');
            }
        },
        error: function () {
            alert('An error occurred.');
        }
    });
});
$('#addUserForm').submit(function (e) { 
    e.preventDefault();
        var formData = $(this).serialize();
        if(username != '' & email !='' & Password !=''){
            $.ajax({
                type: "POST",
                url: "../Controller/addUserValidation.php",
                data:formData,
                success: function (response) {
                    var parsed_data = JSON.parse(response);
                    if (parsed_data.success) {
                        alert('User added successfully.');
                        $('#editUserModal').modal('hide');
                        getdata(); // Reload the user data
                    } else {
                        // getdata();
                        alert('Failed to add new user.');
                    }
                }
            });
        }
        else{
            $('.error-message').append('\
            <div class="alert alert-warning alert-dismissible fade show" role="alert">\
                <strong>Hey!</strong> Please enter all fileds.\
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                    <span aria-hidden="true">&times;</span>\
                </button>\
            </div>\
            ');
        }
    });
    $(document).ready(function () {
        getdata();
    });
    </script>
</body>
</html>
