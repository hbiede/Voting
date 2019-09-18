<?php

echo '
<header>
  <!-- Fixed navbar -->
  <nav id="navbar" class="navbar navbar-expand-md navbar-dark fixed-top navbar-blue">
    <a class="navbar-brand" href="index.php">Vote</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">';
        if (loggedInSuperAdmin()) {
            echo '<li class="nav-item"><a class="nav-link" title="Super Admin Dashboard" href="superadmin_dashboard.php">Super Admin Dashboard</a></li>';
            echo '<li class="nav-item"><a class="nav-link" title="Election Selector" href="organization_picker.php">Election Selector</a></li>';
        } elseif (loggedInAdmin()) {
            echo '<li class="nav-item"><a class="nav-link" title="Admin Dashboard" href="admin_dashboard.php">Admin Dashboard</a></li>';
        } elseif (loggedInVoter()) {
            echo '<li class="nav-item"><a class="nav-link" title="Voting" href="voting.php">Voting</a></li>';
        }
        if (loggedIn()) {
            echo '<li class="nav-item"><a class="nav-link" title="Logout" href="logout.php">Logout</a></li>';
        } else {
            echo '<li class="nav-item"><a class="nav-link" title="Logout" href="login.php">Login</a></li>';
        }
    echo '</ul>
    </div>
  </nav>
</header>
';