<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/partials/header.php";

use App\Services\TagService;

// Create instance of TagService with $db as parameter
$tagService = new TagService();

// Get all tags
$tags = $tagService->getAll();

// Check if the delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_tag"])) 
{
    // Get the tag ID to be deleted
    $tag_id = $_POST["delete_tag"];
    
    // Create instance of TagService with $db as parameter
    $tagService = new App\Services\TagService();

    // Delete the tag
    $tagService->delete($tag_id);
}

?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="display-6 text-center">Tags</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <tr>
                            <td>Tag ID</td>
                            <td>Name</td>
                            <td>Action</td> <!-- Add a new column for actions -->
                        </tr>
                        <?php
                            // Display tags
                            foreach ($tags as $tag) {
                                echo "<tr>";
                                echo "<td>" . $tag->getTagId() . "</td>";
                                echo "<td>" . $tag->getName() . "</td>";
                                echo "<td>";
                                // Create a form with edit and delete buttons
                                echo "<form method='POST'>";
                                echo "<input type='hidden' name='delete_tag' value='" . $tag->getTagId() . "'>";
                                echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                echo "</form>";
                                echo "<a href='edit_tags.php?tag_id=" . $tag->getTagId() . "' class='btn btn-primary'>Edit</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

