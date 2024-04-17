<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/partials/header.php";

use App\Models\Vote;
use App\Models\Answer;
use App\Services\QuestionService;
use App\Services\TagService;
use App\Services\UserService;
use App\Services\AnswerService;
use App\Services\VotingService;
use App\Services\AuthService;

$authService = new AuthService();
$questionService = new QuestionService();
$userService = new UserService();
$answerService = new AnswerService();
$tagService = new TagService();
$voteService = new VotingService();

$tags = $tagService->getAll();

$logged_in_user = $authService->getCurrentUser();
if ($logged_in_user->getRole() == "user") {
    $isAdmin = false;
} else {
    $isAdmin = true;
}


// Retrieve the question ID from the URL parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $questionId = $_GET['id'];

    $question = $questionService->getById($questionId);
    $answers = $answerService->getAnswersByQuestionID($questionId);

} else {
    header("Location: index.php");
    exit();
}

// Handle delete question submission
if (isset($_POST['delete_question'])) {
    $questionID = $_POST['question_id'];

    $questionService->delete($questionID);

    header("Location: index.php");
    exit();
}

// Handle voting
if (isset($_POST['vote_type'])) {
    $questionID = $_POST['question_id'];
    $userID = $_POST['user_id'];
    $voteType = $_POST['vote_type'];

    $vote = new Vote($logged_in_user->getUserId(), $questionID, $voteType);

    // Handle the reputation process
    $reputation = $question->getReputations();

    if ($voteService->create($vote)) {
        if ($voteType == "upvote") {
            $reputation += 1;
        } else {
            $reputation -= 1;
        }
    } else {
        if ($voteType == "upvote") {
            $reputation += 2;
        } else {
            $reputation -= 2;
        }
    }

    $question->setReputations($reputation);

    $questionService->update($questionID, $question);

    // Redirect or refresh the page after voting
    header("Location: question_details.php?id=$questionID");
    exit;
}

// Handle answer submission
if (isset($_POST['submit_answer'])) {
    $answerText = $_POST['answer'];
    $questionID = $_POST['question_id'];
    
    $currentDateTime = date("Y-m-d H:i:s");
    // Create an Answer object
    $answer = new Answer($logged_in_user->getUserId(), $questionID, $answerText, $currentDateTime, null, null);
    
    // Use the AnswerService to save the answer
    $answerService = new AnswerService();
    $answerService->create($answer);
    
    // Redirect the user back to the same page or display a success message
    header("Location: question_details.php?id=" . $questionID);
    exit();
}


?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        <div class="card mb-4 mt-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question->getTitle(); ?></h5>
                    <p class="card-text"><strong>Tags:</strong>
                        <?php foreach ($tagService->getTagsByQuestionID($question->getQuestionID()) as $tag): ?>
                            <span class="badge rounded-pill text-bg-info"><?php echo $tag->getName(); ?></span>
                        <?php endforeach; ?>
                    </p>
                    <p class="card-text"><?php echo $question->getBody(); ?></p>
                    <p class="card-text"><small class="text-muted">Posted by <?php echo $userService->getById($question->getUserID())->getUsername(); ?> | Created at <?php echo $question->getCreatedAt(); ?></small></p>
                    <div class="btn-group mb-2" role="group" aria-label="Vote Question">
                        <form method="post">
                            <input type="hidden" name="question_id" value="<?php echo $question->getQuestionID(); ?>">
                            <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                            <button type="submit" class="btn btn-success d-flex p-2" name="vote_type" value="upvote" style="width: 50px; margin-left: 15px;"><span>⬆</span> <span> <?php echo $voteService->getUpvotesCount($question->getQuestionId()) ?></span>  </button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="question_id" value="<?php echo $question->getQuestionID(); ?>">
                            <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                            <button type="submit" class="btn btn-danger d-flex p-2" name="vote_type" value="downvote" style="width: 50px; margin-left: 15px;"> <span>⬇</span> <span><?php echo $voteService->getDownvotesCount($question->getQuestionId()) ?></span> </button>
                        </form>
                    </div>
                    <?php if ($question->getUserID() == $logged_in_user->getUserId()): ?>
                        <form method="post">
                            <input type="hidden" name="question_id" value="<?php echo $question->getQuestionID(); ?>">
                            <a href="edit_question.php?id=<?php echo $question->getQuestionID(); ?>" class="btn btn-primary w-25">Edit</a>
                            <button type="submit" class="btn btn-danger w-25" name="delete_question">Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <form method="post">
                <input type="hidden" name="question_id" value="<?php echo $question->getQuestionID(); ?>">
                <div class="form-group">
                    <label for="answer">Your Answer:</label>
                    <textarea class="form-control" name="answer" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2" name="submit_answer">Submit Answer</button>
            </form>

        <h2>Answers</h2>
        <?php foreach ($answers as $answer): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text"><?php echo $answer->getBody(); ?></p>
                    <p class="card-text"><small class="text-muted">Posted by <?php echo $userService->getById($answer->getUserID())->getUsername(); ?> | Created at <?php echo $answer->getCreatedAt(); ?></small></p>
                </div>
                <div class="btn-group mb-2" role="group" aria-label="Vote Answer">
                        <form method="post">
                            <input type="hidden" name="question_id" value="<?php echo $question->getQuestionID(); ?>">
                            <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                            <button type="submit" class="btn btn-sm btn-success d-flex p-2" name="vote_type" value="upvote" style="width: 50px; margin-left: 15px;"> <span>⬆</span> <span>0</span></button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="question_id" value="<?php echo $question->getQuestionID(); ?>">
                            <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                            <button type="submit" class="btn btn-sm btn-danger d-flex p-2" name="vote_type" value="downvote" style="width: 50px; margin-left: 15px;"><span>⬇</span> <span>0</span></button>
                        </form>
                    </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>