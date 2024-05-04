<?php
// Include the necessary files
require_once __DIR__ . "/../partials/header.php";
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../Utils/config.php";
use App\Services\AuthService;
use App\Services\QuestionService;
use App\Services\UserService;

// Instantiate the QuestionService
$questionService = new QuestionService();
$authService = new AuthService();
$userService = new UserService();

$user = isset($_GET['id']) ? $userService->getById($_GET['id']) : $authService->getCurrentUser();

$questions = $questionService->getQuestionsByUserID($user->getUserId());
?>

<div class="container mt-5">
    <h2>Questions</h2>
    <hr>
    <!-- Question List -->
    <div class="card">
        <div class="card-header">
            Question List
        </div>
        <div class="card-body">
            <ul class="list-group">
                <?php
                foreach ($questions as $question) {
                    echo '<li class="list-group-item">';
                    echo '<h5>' . $question->title . '</h5>';
                    echo '<p>' . $question->body . '</p>';
                    echo '<small>Created at: ' . $question->created_at . '</small><br />';
                    echo "<a class='btn btn-outline-primary' href='{$domain}question_details.php?id={$question->getQuestionId()}'>Go</a>";
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>