<?php
// Include the necessary files
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../Utils/config.php";

use App\Services\TagService;

// Instantiate the tagService
$tagService = new TagService();

$questionID = 1; // Assuming the question ID is 1 for demonstration

$tag = $tagService->getTagsByQuestionID($questionID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tags</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Tags</h2>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h4>Question Tags</h4>
                <ul class="list-group">
                    <?php
                    // Fetch question tags
                    $questionTags = $tagService->getTagsByQuestionID($questionID);

                    // Check if there are any question tags
                    if ($questionTags) {
                        // Loop through the question tags
                        foreach ($questionTags as $tag) {
                            echo '<li class="list-group-item">' . $tag['name'] . '</li>';
                        }
                    } else {
                        echo '<li class="list-group-item">No tags found for this question.</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h4>All Tags</h4>
                <ul class="list-group">
                    <?php
                    // Fetch all tags from the database using TagService
                    $allTags = $tagService->getAll();

                    // Display all tags
                    foreach ($allTags as $tag) {
                        echo '<li class="list-group-item">' . $tag->name . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>