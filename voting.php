<?php require_once("php/functions.php");
$_REQUEST['title'] = "Voting - ". getOrganizationName();
include("php/header.php");
confirmLoggedInVoter();
?>

<!-- TODO: EVERYTHING -->

<?php include("php/footer.php");?>