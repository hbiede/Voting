<?php
$_REQUEST['title'] = 'Login';
include("php/header.php");
include("php/navbar.php");

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
        if ($_POST['si'] == 'Sign in - Admin') {
            $username = prepMySQLString(isset($_POST['username']) ? $_POST['username'] : $_GET['username']);
            $password = sha1(prepMySQLString(isset($_POST['password']) ? $_POST['password'] : $_GET['password']));

            // entered a password
            if (!empty($username) && !empty($password)) {
                $query = "SELECT username,password,isSuperAdmin FROM admins WHERE username='{$username}'";

                // SQL error prevention
                if ($executeQuery = mysqli_query($connection, $query)) {

                    // only one such voterID
                    if ((mysqli_num_rows($executeQuery) == 1)) {
                        while ($row = mysqli_fetch_assoc($executeQuery)) {
                            $dbPassword = $row['password'];

                            // password match detection
                            if ($password == $dbPassword) {
                                $_SESSION['username'] = $row['username'];
                                if ($row['isSuperAdmin'] == 0) {
                                    $_SESSION['admin'] = $username;
                                    redirect("admin_dashboard.php");
                                } else {
                                    $_SESSION['superAdmin'] = $username;
                                    redirect("superadmin_dashboard.php");
                                }
                            } else {
                                $_SESSION['error'] = "Enter correct username and password";
                                redirect("login.php");
                            }
                        }
                    } else {
                        $_SESSION['error'] = "Enter correct username and password";
                        redirect("login.php");
                    }
                }
            } else {
                $_SESSION['error'] = "Fill all fields";
                redirect("login.php");
            }
        } else {
            $voterID = prepMySQLString(isset($_POST['username']) ? $_POST['username'] : $_GET['username']);
            $password = sha1(prepMySQLString(isset($_POST['password']) ? $_POST['password'] : $_GET['password']));

            // entered a password
            if (!empty($voterID) && !empty($password)) {
                $query = "SELECT voterID,password FROM users WHERE voterID='{$voterID}'";

                // SQL error prevention
                if ($executeQuery = mysqli_query($connection, $query)) {

                    // only one such voterID
                    if ((mysqli_num_rows($executeQuery) == 1)) {
                        while ($row = mysqli_fetch_assoc($executeQuery)) {
                            $dbPassword = $row['password'];

                            // password match detection
                            if ($password == $dbPassword) {
                                $_SESSION['voterID'] = $row['voterID'];
                                redirect("voting.php");
                            } else {
                                $_SESSION['error'] = "Enter correct username and password";
                                redirect("login.php");
                            }
                        }
                    } else {
                        $_SESSION['error'] = "Enter correct username and password";
                        redirect("login.php");
                    }
                }
            } else {
                $_SESSION['error'] = "Fill all fields";
                redirect("login.php");
            }
        }
    } else {
        $_SESSION['error'] = "Fill all fields";
        redirect("login.php");
    }
}

?>

    <form class="form-signin" style="padding-top: 50px;" action="login.php" method="POST">
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
        <p class="text-center" style="color:darkred"><?php echo $_SESSION['error']; unset($_SESSION['error'])?></p>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="si" value="Sign in">Sign in</button>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="si" value="Sign in - Admin">Sign in - Admin</button>
        <p class="mt-5 mb-3 text-muted text-center">©2019 - Hundter Biede</p>
    </form>

<?php include("php/footer.php");?>