<?php
// Include the necessary files
require_once __DIR__."/../../vendor/autoload.php";
require_once __DIR__."/../../Utils/config.php";
require_once __DIR__."/../partials/admin_header.php";

use App\Services\UserService;

// Create an instance of the UserService
$userService = new UserService();

// Initialize variables
$users = [];
$error = '';

$users = $userService->getAll();
?>
    <div class="container p-5">
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
