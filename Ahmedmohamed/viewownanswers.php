<?php
// Include the necessary files
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";
use App\Services\AnswerService;


// Instantiate the AnswerService
$answerService = new AnswerService();

// Fetch answers by user ID (assuming $userID contains the current user's ID)
$userID = 1; // Assuming the user ID is 1 for demonstration
$answers = $answerService->getAnswersByUserID($userID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Answers</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>My Answers</h2>
        <hr>
        <!-- Answer List -->
        <div class="card">
            <div class="card-header">
                My Answer List
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                        // Loop through the answers and display them
                        foreach ($answers as $answer) {
                            echo '<li class="list-group-item">';
                            echo '<h5>' . $answer->body . '</h5>';
                            echo '<small>Created at: ' . $answer->created_at . '</small>';
                            echo '</li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
