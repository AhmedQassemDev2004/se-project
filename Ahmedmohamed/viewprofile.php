<?php
// Include the necessary files
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";
use App\Services\UserService;

// Instantiate the userservice
$userService = new UserService();

// Fetch answers by user ID (assuming $userID contains the current user's ID)
$userID = 1; // Assuming the user ID is 1 for demonstration
$user = $userService->getByID($userID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
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

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3><?php echo $user->username; ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo $user->photo; ?>" class="img-fluid" alt="User Photo">
                </div>
                <div class="col-md-8">
                    <p>Email: <?php echo $user->email; ?></p>
                    <p>Reputations: <?php echo $user->reputations; ?></p>
                    <p>Role: <?php echo ucfirst($user->role); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="updateprofile.php" method="GET">
                <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>


</body>
</html>
