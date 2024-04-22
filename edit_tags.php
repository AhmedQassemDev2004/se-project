<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/partials/header.php";

use App\Services\TagService;

// Check if the tag ID is provided in the URL
if (!isset($_GET["tag_id"])) 
{
    // Redirect to the tags page if tag ID is not provided
    header("Location: tags.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the edited tag details from the form
    $tag_id = $_POST["tag_id"];
    $name = $_POST["name"];
    
    $tagService = new TagService();

    // Update the tag details
    $tagService->update($tag_id, (object)["name" => $name]);

    // Redirect back to the tags page after updating
    header("Location: tags.php");
    exit();
}

// Get the tag ID from the URL
$tag_id = $_GET["tag_id"];

// Get the tag details by ID
$tag = $tagService->getById($tag_id);

// Check if the tag exists
if (!$tag) {
    // Redirect to the tags page if tag does not exist
    header("Location: tags.php");
    exit();
}
?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="display-6 text-center">Edit Tag</h2>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $tag->getName(); ?>" required>
                        </div>
                        <input type="hidden" name="tag_id" value="<?php echo $tag->getTagId(); ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

