<?php

require_once("connection.php");

/*
 * Login Checkers
 */

function loggedInSuperAdmin() {
    return isset($_SESSION['superAdmin']);
}

function loggedInAdmin() {
    return isset($_SESSION['admin']) || isset($_SESSION['orgID']);
}

function loggedInVoter() {
    return isset($_SESSION['voterID']);
}


function loggedIn() {
    return loggedInSuperAdmin() || loggedInAdmin() || loggedInVoter();
}

function confirmLoggedInSuperAdmin() {
    if (!loggedInSuperAdmin() && !loggedIn()) {
        redirect("login.php");
    } elseif (loggedInAdmin()) {
        redirect("admin_dashboard.php");
    } elseif (loggedInVoter()) {
        redirect('voting.php');
    }
}

function confirmLoggedInAdmin() {
    if (!loggedInAdmin() && !loggedIn()) {
        redirect("login.php");
    } elseif (loggedInSuperAdmin()) {
        redirect("organization_picker.php");
    } elseif (loggedInVoter()) {
        redirect('voting.php');
    }
}

function confirmLoggedInVoter() {
    if (!loggedInVoter()) {
        redirect("login.php");
    }
}

function confirmLoggedIn() {
    if (!loggedIn()) {
        redirect("login.php");
    }
}


/*
 * Election-specific SQL functions
 */
function confirmCredentialsVoter($voterID, $password) {
    global $connection;

    // entered a password
    if (!empty($voterID) && !empty($password)) {
        $query = "SELECT voterID,password FROM users WHERE voterID='{$voterID}'";

        // SQL error prevention
        if ($executeQuery = mysqli_query($connection, $query)) {

            // only one such voterID
            if ((mysqli_num_rows($executeQuery) == 1)) {
                while ($row = mysqli_fetch_assoc($executeQuery)) {
                    $dbPassword = $row['password'];

                    // password match detection
                    if ($password == $dbPassword) {
                        $_SESSION['voterID'] = $row['voterID'];
                        redirect("voting.php");
                    } else {
                        $_SESSION['error'] = "Enter correct username and password";
                        redirect("login.php");
                    }
                }
            } else {
                $_SESSION['error'] = "Enter correct username and password";
                redirect("login.php");
            }
        }
    } else {
        $_SESSION['error'] = "Fill all fields";
        redirect("login.php");
    }
}

function confirmCredentialsAdmin($username, $password) {
    global $connection;

    // entered a password
    if (!empty($username) && !empty($password)) {
        $query = "SELECT username,password,isSuperAdmin FROM admins WHERE username='{$username}'";

        // SQL error prevention
        if ($executeQuery = mysqli_query($connection, $query)) {

            // only one such voterID
            if ((mysqli_num_rows($executeQuery) == 1)) {
                while ($row = mysqli_fetch_assoc($executeQuery)) {
                    $dbPassword = $row['password'];

                    // password match detection
                    if ($password == $dbPassword) {
                        $_SESSION['username'] = $row['username'];
                        if ($row['isSuperAdmin'] == 0) {
                            $_SESSION['admin'] = $username;
                            redirect("admin_dashboard.php");
                        } else {
                            $_SESSION['superAdmin'] = $username;
                            redirect("superadmin_dashboard.php");
                        }
                    } else {
                        $_SESSION['error'] = "Enter correct username and password";
                        redirect("login.php");
                    }
                }
            } else {
                $_SESSION['error'] = "Enter correct username and password";
                redirect("login.php");
            }
        }
    } else {
        $_SESSION['error'] = "Fill all fields";
        redirect("login.php");
    }
}

/**
 * @param $orgID int The ID representing the organization in the DB
 * @return int The ID of the newly created election
 */
function createElection($orgID) {
    // TODO create an election and return the election ID
    if (is_numeric($orgID)) {
        global $connection;
        $query = "INSERT INTO elections (organizationID) VALUES ('{$orgID}');";
        if ($executeQuery = mysqli_query($connection, $query)) {
            return mysqli_insert_id($connection);
        } else {
            $_SESSION['error'] = "SQL Error";
            redirect("election_editor.php");
        }
    } else {
        $_SESSION['error'] = "Invalid Organization ID";
        redirect("election_editor.php");
    }
}

/**
 * @param $voterCode string Represents the voter (the username for the voter)
 * @return int The ID representing the organization in the DB
 */
function getMyElectionID($voterCode) {
    return 0;
}

/**
 * @param $orgID int The ID representing the organization in the DB
 * @return string The name of the organization
 */
function getOrganizationName($orgID) {
    // TODO return the name of the organization as logged in
    return "";
}

/**
 * @param $orgID int The ID representing the organization in the DB
 * @param $username string Represents the admin (the username for the admin)
 * @param $password string The string that will permit the admin to log in (will be hashed before storing to the DB)
 */
function createAdmin($orgID, $username, $password) {
    // TODO add an admin to an org
}

/**
 * @param $electionID int The ID representing the election in the DB
 * @param $voterCode string Represents the voter (the username for the voter)
 * @param $password string The string that will permit the user to log in (will be hashed before storing to the DB)
 */
function createUser($electionID, $voterCode, $password) {
    // TODO add a user to an election
}

/**
 * Create a new candidate for a given election
 *
 * @param $electionID int The ID representing the election in the DB
 * @param $name string The candidate's name
 * @param $position string The position being sought
 */
function createCandidate($electionID, $name, $position) {
    // TODO add a candidate to an org
}

/**
 * Returns whether a given voter has voted yet
 * @param $voterCode string Represents the voter (the username for the voter)
 * @return bool Whether the given voter has voted
 */
function hasVoted($voterCode) {
    // TODO return if a user has voted
    return false;
}

/**
 * Generate a list of the candidates seeking a given position and return them in a list for use on the election_editor page
 *
 * @param $position string A name for the position you're seeking to get a listing of
 * @param $electionID int The ID from the DB referring to the election
 * @return string The list geneterated
 */
function generatePositionList($position, $electionID) {
    global $connection;
    $output = "";
    if (is_numeric($electionID)) {
        $positionName = prepMySQLString($position);
        $query = "SELECT name FROM ballot_entries WHERE electionID='{$electionID}' AND position='{$positionName}';";
        if ($executeQuery = mysqli_query($connection, $query)) {
            while ($row = mysqli_fetch_assoc($executeQuery)) {
                $output .= '<li><div class="alert alert-secondary" role="form">' . $row['name'] . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></li>';
            }
        } else {
            $_SESSION['error'] = "SQL Error";
            redirect("election_editor.php");
        }
    } else {
        $_SESSION['error'] = "Invalid Election ID";
        redirect("election_editor.php");
    }
    return $output;
}

/*
 * Utility functions
 */
/**
 * Sanitizes a string for SQL use
 *
 * @param $string string to be sanitized
 * @return string The sanitized string
 */
function prepMySQLString($string) {
    global $connection;
    $magicQuotesExist = get_magic_quotes_gpc(); // always false after PHP 5.4
    if (function_exists("mysqli_real_escape_string")) { // PHP 5 or later
        if ($magicQuotesExist) $string = stripcslashes($string); // get rid of extra slashes from early PHP
        $string = mysqli_real_escape_string($connection, $string);
    } else { // pre-PHP 4.3.0
        if (!$magicQuotesExist) {
            $string = addslashes($string);
        }
    }
    return $string;
}

function redirect($loc) {
    if ($loc != NULL) {
        header("Location:{$loc}");
        exit;
    }
}