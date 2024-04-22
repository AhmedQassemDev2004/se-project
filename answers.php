<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/partials/header.php";

use App\Services\AnswerService;

// Create instance of AnswerService
$answerService = new AnswerService();

// Get all answers
$answers = $answerService->getAll();

?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="display-6 text-center">Answers</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <tr>
                            <td>Answer ID</td>
                            <td>User ID</td>
                            <td>Question ID</td>
                            <td>Body</td>
                            <td>Created At</td>
                            <td>Reputations</td>
                        </tr>
                        <?php
                            // Display answers
                            foreach ($answers as $answer) {
                                echo "<tr>";
                                echo "<td>" . $answer->getAnswerId() . "</td>";
                                echo "<td>" . $answer->getUserId() . "</td>";
                                echo "<td>" . $answer->getQuestionId() . "</td>";
                                echo "<td>" . $answer->getBody() . "</td>";
                                echo "<td>" . $answer->getCreatedAt() . "</td>";
                                echo "<td>" . $answer->getReputations() . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
