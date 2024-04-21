<?php
// Include the necessary files
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";
use App\Services\UserService;

// Create an instance of the UserService
$userService = new UserService();

// Initialize variables
$users = [];
$error = '';

// Check if search parameters are provided in the URL
if (isset($_GET['search'])) {
    // Trim and lowercase the search query
    $searchTerm = trim(strtolower($_GET['search']));

    // Check if the search term is empty
    if (!empty($searchTerm)) {
        try {
            // Check if the search term is numeric (user ID) or alphanumeric (username)
            if (is_numeric($searchTerm)) {
                // Search by user ID
                $users = [$userService->getById((int)$searchTerm)];
            } else {
                // Search by username
                $users = $userService->getByUsername($searchTerm);
            }
        } catch (Exception $e) {
            // Handle any exceptions that may occur during the search
            $error = 'An error occurred while searching: ' . $e->getMessage();
        }
    } else {
        $error = 'Please enter a valid search term.';
        $users = $userService->getAll();
    }
} else {
    // No search parameters provided, fetch all users
    $users = $userService->getAll();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="<?php echo $domain; ?>/css/bootstrap.min.css" />
    <style>
        body {
            padding-top: 56px; /* Adjust based on your navbar height */
        }

        .container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="ViewUsers.php">View Users</a> 
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" href="AddUser.php">Add User</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" action="ViewUsers.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search by user ID or username" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch users from the database and display them in the table
                if ($users) {
                    foreach ($users as $user) {
                            echo "<tr>";
                            echo "<td>" . $user->user_id . "</td>";
                            echo "<td>" . $user->username . "</td>";
                            echo "<td>" . $user->email . "</td>";
                            echo "<td>" . $user->role . "</td>";
                            echo "<td>";
                            echo "<a href='EditUser.php?id=" . $user->user_id . "' class='btn btn-primary btn-sm'>Edit</a>";
                            echo "&nbsp;";
                            echo "<a href='DeleteUser.php?id=" . $user->user_id . "' class='btn btn-danger btn-sm'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                    }
                } else {
                        // Handle the case where $user is null (if needed)
                        // For example, you could log a message or display a warning to the user
                        echo "<tr><td colspan='5'>No users found</td></tr>";
                }                          
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
