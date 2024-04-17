<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/partials/header.php";

use App\Services\UserService;
use App\Utils\Utils;
use App\Models\User;

$userService = new UserService();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = Utils::clean_input($_POST["username"]);
    $email = Utils::clean_input($_POST["email"]);
    $password = Utils::clean_input($_POST["password"]);

    if ($userService->getUserByUsername($username)) {
        $error = "Username already exists. Please choose another username.";
    } else if($userService->getUserByEmail($email)) {
        $error = "Email already exists.";
    } else {
        $user = new User(0, $username, $email, password_hash($password, PASSWORD_DEFAULT), null, date("Y-m-d H:i:s"), 0, 'user');
        $userId = $userService->add_vote($user);
        if ($userId) {
            (new \App\Services\AuthService())->auth($username);
            header("Location: ".$domain);
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

