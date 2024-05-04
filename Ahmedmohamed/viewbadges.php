
<?php
// Include the necessary files
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";

use App\Services\UserService;

// Instantiate the badgeService
$userService = new userService();
// Fetch answers by user ID (assuming $userID contains the current user's ID)
$userID = 1; // Assuming the user ID is 1 for demonstration
$badges = $userService->getbadgesByUserID($userID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Badges</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>My Badges</h2>
        <hr>
        <!-- Badge List -->
        <div class="card">
            <div class="card-header">
                My Badge List
            </div>
            <div class="card-body">
                <ul class="list-group">
                <?php
                  // Include the file containing the UserBadge class definition
                  require_once 'viewbadges.php';

                    // Loop through the user badges and display them
                     foreach ($badges as $userBadge) {
                     echo '<li class="list-group-item">';
                     echo 'Badge Name: ' . $userBadge['name'];
                     echo '</li>';
                     }
                        ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
