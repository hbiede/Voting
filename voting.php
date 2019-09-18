<?php require_once("php/functions.php");
$_REQUEST['title'] = "Voting - ". getOrganizationName();
include("php/header.php");
confirmLoggedInVoter();
?>

<?php include("php/navbar.php");?>
<!-- TODO: EVERYTHING -->

<?php include("php/footer.php");?>