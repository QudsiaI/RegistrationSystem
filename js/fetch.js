$(document).ready(function () {
    getdata();
});

function getdata() {
    $.ajax({
        type: "GET",
        url: "../Controller/fetch.php",
        success: function (response) {
            $('#userData').empty(); // Clear the existing table rows
            $.each(response, function (key, value) {
                $('#userData').append('<tr>' +
                    '<td>' + value['u_id'] + '</td>' +
                    '<td>' + value['username'] + '</td>' +
                    '<td>' + value['email'] + '</td>' +
                    '<td>' +
                    '<button type="button" class="btn btn-warning btn-sm me-2" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#editUserModal" ' +
                    'data-id="' + value['u_id'] + '" data-username="' + value['username'] + '" data-userStatus="' + value['userStatus'] + '" data-lastModified="' + value['lastModified'] + '" data-role="' + value['role'] + '" data-email="' + value['email'] + '">Edit</button>' +
                    '<button class="btn btn-danger btn-sm" onclick="deleteUser(' + value['u_id'] + ')">Delete</button>' +
                    '</td>' +
                    '</tr>');
            });
        }
    });
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            type: "POST",
            url: "../Controller/deleteUser.php",
            data: { u_id: id },
            success: function (response) {
                var res = JSON.parse(response); // Parse JSON response
                if (res.success) {
                    alert("User deleted successfully.");
                    // window.location.href = '../view/adminUserData.php';
                    getdata(); // Refresh the user data after deletion
                } else {
                    alert("Failed to delete user.");
                }
            },
            error: function () {
                alert("Error while deleting user.");
            }
        });
    }
}
