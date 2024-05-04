<?php
// Include the necessary files
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";
use App\Services\QuestionService;

// Instantiate the QuestionService
$questionService = new QuestionService();

// Fetch questions by user ID (assuming $userID contains the current user's ID)
$userID = 1; // Assuming the user ID is 1 for demonstration
$questions = $questionService->getQuestionsByUserID($userID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Questions</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>My Questions</h2>
        <hr>
        <!-- Question List -->
        <div class="card">
            <div class="card-header">
                My Question List
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                        // Loop through the questions and display them
                        foreach ($questions as $question) {
                            echo '<li class="list-group-item">';
                            echo '<h5>' . $question->title . '</h5>';
                            echo '<p>' . $question->body . '</p>';
                            echo '<small>Created at: ' . $question->created_at . '</small>';
                            echo '</li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
