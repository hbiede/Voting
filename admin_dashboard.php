<?php $_REQUEST['title'] = 'Admin Dashboard';
include("php/header.php");
confirmLoggedInAdmin();

include("php/navbar.php");?>
<!-- TODO: EVERYTHING -->

    <h1>Admin Dashboard</h1>

    <div class="card">
        <h5 class="card-header">Elections</h5>

        <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="election_editor.php" class="btn btn-primary">Create Election</a>
        </div>
    </div>

<?php include("php/footer.php");?>