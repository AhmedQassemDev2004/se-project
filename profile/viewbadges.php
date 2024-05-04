<?php
// Include the necessary files
require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../Utils/config.php";

use App\Services\UserService;
use App\Services\AuthService;

$userService = new userService();
$authService = new AuthService();

$userId = isset($_GET['id']) ? $_GET['id'] : $authService->getCurrentUser()->getUserId();
$badges = $userService->getbadgesByUserID($userId);
?>

<style>
    /* Styles for Bronze badge */
    .badge-bronze {
        background-color: #cd7f32;
        /* Bronze color */
        color: white;
    }

    /* Styles for Silver badge */
    .badge-silver {
        background-color: #c0c0c0;
        /* Silver color */
        color: black;
    }

    /* Styles for Gold badge */
    .badge-gold {
        background-color: #ffd700;
        /* Gold color */
        color: black;
    }
</style>

<div class="container mt-5">
    <h2>My Badges</h2>
    <hr>
    <!-- Badge List -->
    <div class="card">
        <div class="card-header">
            My Badge List
        </div>
        <div class="card-body">
            <?php
            if (empty($badges)) {
                echo "<h3>No badges yet</h3>";
            }
            ?>
            <ul class="list-group">
                <?php
                foreach ($badges as $userBadge) {
                    $badgeClass = '';
                    switch ($userBadge['type']) {
                        case 'Beginner':
                            $badgeClass = 'badge-bronze';
                            break;
                        case 'Intermediate':
                            $badgeClass = 'badge-silver';
                            break;
                        case 'Advanced':
                            $badgeClass = 'badge-gold';
                            break;
                        default:
                            $badgeClass = '';
                            break;
                    }
                    ?>
                    <li class="list-group-item <?php echo $badgeClass; ?>">
                        <?php echo $userBadge['name']; ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>