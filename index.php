<?php

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/partials/header.php";

use App\Services\QuestionService;
use App\Services\TagService;
use App\Services\UserService;

$questionService = new QuestionService();
$questions = $questionService->getAll();

$tagService = new TagService();
$tags = $tagService->getAll();

$userService = new UserService();

// Retrieve selected tag from URL parameter
$selected_tag_id = isset($_GET['tag']) ? $_GET['tag'] : null;
// Get the questions based on the selected tag (if any)
if ($selected_tag_id) {
    $questions = $questionService->getQuestionsByTagID($selected_tag_id);
} else {
    // Get all questions if no tag is selected
    $questions = $questionService->getAll();
}

?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1 class="mb-4">View Questions</h1>
            <!-- Display tag filter options -->
            <form action="index.php" method="get" class="mb-4">
                <div class="form-group mb-2">
                    <label for="tag">Filter by Tag:</label>
                    <select class="form-control" id="tag" name="tag">
                        <option value="">All Tags</option>
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?php echo $tag->getTagID(); ?>" <?php echo ($selected_tag_id == $tag->getTagID()) ? 'selected' : ''; ?>><?php echo $tag->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            </form>

            <!-- Display questions -->
            <?php foreach ($questions as $question): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question->getTitle(); ?></h5>
                    <p class="card-text"><strong>Tags:</strong>
                        <?php foreach ($tagService->getTagsByQuestionID($question->getQuestionID()) as $tag): ?>
                            <span class="badge rounded-pill text-bg-info"><?php echo $tag->getName(); ?></span>
                        <?php endforeach; ?>
                    </p>
                    <p class="card-text"><?php echo $question->getBody(); ?></p>
                    <p class="card-text"><small class="text-muted">Posted by <?php echo $userService->getById($question->getUserID())->username; ?> | Created at <?php echo $question->getCreatedAt(); ?></small></p>
                    <?php if ($authService->isLoggedIn()): ?>
                        <a href="question_details.php?id=<?php echo $question->getQuestionID(); ?>" class="btn btn-primary btn-sm btn-view-question">Details</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
