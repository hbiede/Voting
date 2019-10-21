<?php $_REQUEST['title'] = 'Organization Picker';
include("php/header.php");
confirmLoggedInSuperAdmin();

if ($_POST['si'] === 'choose') {
    $_SESSION['organizationID'] = $_POST['orgIDSelection'];
}
?>


<form action="organization_picker.php" method="POST">

    <?php
        global $connection;
        $query = "SELECT id,organizationName FROM organizations;";

        // SQL error prevention
        if ($executeQuery = mysqli_query($connection, $query)) {
            if ((mysqli_num_rows($executeQuery) > 0)) {
                echo '<select name="orgIDSelection">';
                while ($row = mysqli_fetch_assoc($executeQuery)) {
                    $orgID = $row['id'];
                    $orgName = $row['organizationName'];
                    echo "<option value=\"$orgID\">$orgName</option>";
                }
                echo '</select>';
                echo '<input type="submit" class="btn btn-primary" name="choose" value="choose">';
            } else {
                echo '<div class="alert alert-danger text-center php-error-alert" role="alert">No Organizations Exist</div>';
            }
        } else {
            echo '<div class="alert alert-danger text-center php-error-alert" role="alert">SQL Error</div>';
        }

    ?>

</form>



<?php include("php/footer.php");?>