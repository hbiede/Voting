<?php
$_REQUEST['title'] = 'Login';
include("php/header.php");?>

<?php include("php/navbar.php");?>
<!-- TODO: EVERYTHING -->

    <form class="form-signin" style="padding-top: 50px;" action="login.php" method="POST">
        <div class="text-center mb-4">
            <img class="mb-4" src="img/BVSLogo.png" alt="" width="144" height="144">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        </div>

        <div class="form-label-group">
            <input type="text" id="voterID" name="voterID" class="form-control" placeholder="Voter ID" required="" autofocus="">
            <label for="voterID">Voter ID</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required="">
            <label for="inputPassword">Password</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted text-center">©2019 - Hundter Biede</p>
    </form>

<?php include("php/footer.php");?>