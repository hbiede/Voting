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
                <h5 class="card-header">Election Editor</h5>

                <div class="card-body">
                    <h5 class="card-title">Edit Election</h5>
                    <select id="electionSelector">
                        <?php
                            // election_editor.php?electionID='id'
                            global $connection;
                            $query = "SELECT electionName,id FROM elections;";

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
                    </select>
                    <a id="electionSelectorLink" href="#" class="btn btn-primary">Edit Election</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#electionSelector").change(function () {
            $("#electionSelectorLink").attr('href', this.value);
        });
    </script>

<?php include("php/footer.php");?>