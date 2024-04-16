<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/partials/header.php";

use App\Services\UserService;
use App\Utils\Utils;

$userService = new UserService();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = Utils::clean_input($_POST["username"]);
    $password = Utils::clean_input($_POST["password"]);

    $user = $userService->getUserByUsername($username);

    if ($user && password_verify($password, $user->password)) {
        (new \App\Services\AuthService())->auth($username);
        header("Location: ".$domain);
        exit();
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login</div>

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
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

