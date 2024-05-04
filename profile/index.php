<?php
// Include the necessary files
require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../Utils/config.php";
use App\Services\UserService;

$userService = new UserService();
$user = isset($_GET['id']) ? $userService->getByID($_GET['id']) : $authService->getCurrentUser();
$currentUserId = $authService->getCurrentUser()->getUserId();
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3><?php echo $user->username; ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo $domain . $user->photo; ?>" class="img-fluid" alt="User Photo">
                </div>
                <div class="col-md-8">
                    <p>Email: <?php echo $user->email; ?></p>
                    <p>Reputations: <?php echo $user->reputations; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <?php if ($user->getUserId() == $currentUserId): ?>
                <form action="updateprofile.php" method="GET">
                    <input type="hidden" name="user_id" value="<?php echo $user->getUserId(); ?>">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
                <a href="viewownanswers.php" class="btn btn-primary">View Own Answers</a>
                <a href="viewownquestions.php" class="btn btn-primary">View Own Questions</a>
                <a href="viewownbadges.php" class="btn btn-primary">View Own Badges</a>
            <?php endif; ?>
        </div>
    </div>
</div>