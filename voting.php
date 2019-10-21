<?php
require_once("php/functions.php");
if (hasVoted($_SESSION['voterCode'])) {
    redirect("voted.php");
}
$_REQUEST['title'] = "Voting - " . getMyElectionName($_SESSION['voterCode']);
include("php/header.php");
confirmLoggedInVoter();
?>

<!-- TODO: EVERYTHING -->

<?php include("php/footer.php");?>