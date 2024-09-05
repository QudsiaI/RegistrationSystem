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
                            <form method="POST" action="../Controller/addUserValidation.php">
                                <div class="mb-3">
                                    <label for="username" class="col-form-label">Username:</label>
                                    <input type="text" class="form-control" name="Username" id="username" value="<?php echo htmlspecialchars($name); ?>">
                                    <small class="text-danger"><?php echo $nameErr; ?></small>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <input type="email" class="form-control" name="Email" id="email" value="<?php echo htmlspecialchars($email); ?>">
                                    <small class="text-danger"><?php echo $emailErr; ?></small>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="col-form-label">Password:</label>
                                    <input type="password" class="form-control" name="Password" id="password">
                                    <small class="text-danger"><?php echo $passErr; ?></small>
                                </div>
                                <button type="submit" class="btn btn-primary">Add User</button>
                                <input type="hidden" name="fromAdmin" value="true">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="text-center">Registered Users</h2>
            <small>
                <form method="GET" action="">
                    <label for="recordsPerPage">Records per page:</label>
                    <select name="recordsPerPage" id="recordsPerPage" onchange="this.form.submit()">
                        <option value="5" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == 5) echo 'selected'; ?>>5</option>
                        <option value="10" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == 10) echo 'selected'; ?>>10</option>
                        <option value="20" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == 20) echo 'selected'; ?>>20</option>
                        <option value="<?php echo htmlspecialchars($total_users); ?>" <?php if (isset($_GET['recordsPerPage']) && $_GET['recordsPerPage'] == $total_users) echo 'selected'; ?>>All</option>
                    </select>
                </form>
            </small>
            <table class="table table-bordered border-dark border-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $limit = 5;
                if (isset($_GET['recordsPerPage']) && is_numeric($_GET['recordsPerPage'])) {
                    $limit = (int)$_GET['recordsPerPage'];
                }
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                if ($limit != $total_users) {
                    $total_pages = ceil($total_users / $limit);
                } else {
                    $total_pages = 1; // When "All" is selected, there's only one page
                }

                $user->viewAllUsers($limit, $offset);
                ?>
                </tbody>
            </table>
            <!-- Pagination Links -->
            <?php if ($limit != $total_users): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page-1; ?>&recordsPerPage=<?php echo $limit; ?>">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&recordsPerPage=<?php echo $limit; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page+1; ?>&recordsPerPage=<?php echo $limit; ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
        </div>
    </div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
