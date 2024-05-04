<?php
// Include the necessary files
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";
use App\Services\UserService;

// Create an instance of the UserService
$userService = new UserService();

// Initialize variables
$user = null;
$message = '';

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data by user ID
    $user = $userService->getById($userId);

    // Check if the user exists
    if (!$user) {
        $message = 'User not found.';
    }
} else {
    // If user ID is not provided, display an error message
    $message = 'User ID is missing.';
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validate form data
    if (!empty($username) && !empty($email) && !empty($role)) {
        // Update user data
        $userData = (object) [
            'user_id' => $userId,
            'username' => $username,
            'email' => $email,
            'role' => $role
        ];

        // Call the update method of UserService to update the user in the database
        $success = $userService->update($userId ,$userData);

        if ($success) {
            // User updated successfully
            $message = "User updated successfully";
        } else {
            // Failed to update user
            $message = 'Failed to update user';
        }
    } else {
        // If form fields are empty, display an error message
        $message = 'Please fill out all fields';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="<?php echo $domain; ?>/css/bootstrap.min.css" />
    <style>
        body {
            padding-top: 56px;
        }

        .container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container"> 
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="EditUser.php?id=<?php echo $user->user_id; ?>">Edit User</a> 
            </div>
        </nav>

        <?php if (!empty($message)): ?>
            <div class="alert alert-primary" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <?php if ($user): ?>
            <form action="EditUser.php?id=<?php echo $user->user_id; ?>" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" <?php echo ($user->role === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo ($user->role === 'user') ? 'selected' : ''; ?>>User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="ViewUsers.php" class="btn btn-danger">Go Back</a>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>
