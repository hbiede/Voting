<?php $_REQUEST['title'] = 'Super Admin Dashboard';
include("php/header.php");
confirmLoggedInSuperAdmin();

global $connection;
if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
    if (isset($_POST['create_org']) && $_POST['create_org'] === 'Create Organization') {
        $orgName = prepMySQLString($_POST['orgName']);
        if (trim($orgName) !== "") {
            $query = "INSERT INTO organizations (organizationName) VALUES ('{$orgName}');";
        } else {
            $_SESSION['error'] = "Please give the organization an actual name";
            redirect("superadmin_dashboard.php");
        }
    }
}
?>

<!-- TODO: EVERYTHING -->

    <h1>Admin Dashboard</h1>
<?php if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center php-error-alert" role="alert">'.$_SESSION['error'].'</div>';
} unset($_SESSION['error']);?>

    <div class="container">
        <div class="row"> <!-- 3 items per row -->
            <div class="card" style="width: 18rem;">
                <h5 class="card-header">Create Organization</h5>

                <div class="card-body">
                    <form action="superadmin_dashboard.php" method="POST">
                        <label for="orgName" class="card-title">Organization Name:</label>
                        <input type="text" class="card-text" placeholder="Organization Name" name="orgName" value="" required>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Create Organization" name="create_org">
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("php/footer.php");?>