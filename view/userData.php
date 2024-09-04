<?php
include '../Controller/checkSession.php';
include '../Controller/ini_db.php';
include_once '../models/user.php';

$user = new User($conn);
$total_users = $user->countUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Styling/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <title>Users List</title>
</head>
<body>
    <?php include __DIR__ . "/navigation/userNavBar.php"; ?>
        <div class="sidebar">
            <?php include "navigation/userSideNav.php"; ?>
        </div>
        <div class="main-content">
            <div class="container mt-5">
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
                        <th>Profile Pic</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
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
                
                $total_pages = ceil($total_users / $limit);
    
                $user->viewUsersData($limit, $offset);
                ?>
                </tbody>
            </table>
            <!-- Pagination Links -->
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

        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
