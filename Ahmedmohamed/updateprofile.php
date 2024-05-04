<?php
session_start();
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";

use App\Services\UserService;

$userService = new UserService();
$error = '';

// Fetch existing user data
$user = $userService->getById($_GET['user_id']);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input fields
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    
    // Check if password is provided and hash it
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Check if a new photo is uploaded
    if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = __DIR__ . '/uploads/';
        $targetFile = $targetDir . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
    } else {
        $photo = $user->photo;
    }

    // Update user data
    $user->username = $username;
    $user->email = $email;
    if ($password !== null) {
        $user->password = $password;
    }
    $user->photo = $photo;

    // Save updated user data
    try {
        $userService->update($user->user_id, $user);
        // Redirect to profile page or display success message
        header("Location: viewprofile.php");
        exit;
    } catch (Exception $e) {
        // Handle the error gracefully, e.g., display an error message to the user
        $error = "An error occurred while updating the profile: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Profile</h2>
        <hr>
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user->username); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" class="form-control-file" id="photo" name="photo">
                <?php if ($user->photo): ?>
                    <img src="<?php echo htmlspecialchars($user->photo); ?>" alt="Current Photo" style="max-width: 200px; margin-top: 10px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
