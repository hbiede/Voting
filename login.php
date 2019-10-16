<?php
$_REQUEST['title'] = 'Login';
include("php/header.php");

if (loggedInSuperAdmin()) {
    redirect("superadmin_dashboard.php");
} elseif (loggedInAdmin()) {
    redirect("admin_dashboard.php");
} elseif (loggedInVoter()) {
    redirect("voting.php");
}

global $connection;
if (isset($_GET['username']) || isset($_POST['username'])) {
    if ((isset($_GET['username']) && isset($_GET['password'])) || (isset($_POST['username']) && isset($_POST['password']))) {
        if ($_POST['si'] === 'Sign in - Admin') {
            $username = prepMySQLString(isset($_POST['username']) ? $_POST['username'] : $_GET['username']);
            $password = sha1(prepMySQLString(isset($_POST['password']) ? $_POST['password'] : $_GET['password']));
            confirmCredentialsAdmin($username, $password);
        } else {
            $voterID = prepMySQLString(isset($_POST['username']) ? $_POST['username'] : $_GET['username']);
            $password = sha1(prepMySQLString(isset($_POST['password']) ? $_POST['password'] : $_GET['password']));
            confirmCredentialsVoter($voterID, $password);
        }
    } else {
        $_SESSION['error'] = "Fill all fields";
        redirect("login.php");
    }
}

?>

    <form class="form-signin" action="login.php" method="POST">
        <div class="text-center mb-4">
            <img class="mb-4" src="img/BVSLogo.png" alt="" width="144" height="144">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        </div>

        <div class="form-label-group">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required="" autofocus="">
            <label for="username">Username</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
            <label for="password">Password</label>
        </div>
        <?php if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger text-center" role="alert">'.$_SESSION['error'].'</div>';
        } unset($_SESSION['error']);?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="si" value="Sign in">Sign in</button>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="si" value="Sign in - Admin">Sign in - Admin</button>
        <p class="mt-5 mb-3 text-muted text-center">©2019 - Hundter Biede</p>
    </form>

<?php include("php/footer.php");?>