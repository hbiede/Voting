<?php
require_once ("functions.php");
require_once ("connection.php");

if (isset($_GET['electionID'])) {
    global $connection;
    $query = "SELECT positionOrder FROM elections WHERE id='{$_GET['electionID']}'";
    // SQL error prevention
    if ($executeQuery = mysqli_query($connection, $query)) {
        while ($row = mysqli_fetch_assoc($executeQuery)) {
            echo generatePositionList($row['positionOrder'], $_GET['electionID']);
        }
    } else {
        $_SESSION['error'] = "SQL Error";
        redirect("election_editor.php");
    }

} else {
    echo '';
}
