<?php $_REQUEST['title'] = 'Admin Dashboard';
include("php/header.php");
confirmLoggedInAdmin();
?>
<!-- TODO: EVERYTHING -->

    <h1>Admin Dashboard</h1>
<?php if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center php-error-alert" role="alert">'.$_SESSION['error'].'</div>';
} unset($_SESSION['error']);?>

    <div class="container">
        <div class="row"> <!-- 3 items per row -->
            <div class="card">
                <h5 class="card-header" style="width: 18rem;">Election Creator</h5>

                <div class="card-body">
                    <h5 class="card-title">Create a new election</h5>
                    <a href="election_editor.php" class="btn btn-primary">Create Election</a>
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <h5 class="card-header">Election Creator</h5>

                <div class="card-body">
                    <h5 class="card-title">Create a new election</h5>
                    <a href="election_editor.php" class="btn btn-primary">Create Election</a>
                </div>
            </div>
        </div>
    </div>

<?php include("php/footer.php");?>